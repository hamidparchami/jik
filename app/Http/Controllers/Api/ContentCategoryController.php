<?php

namespace App\Http\Controllers\Api;

use App\CategoryVisitLog;
use App\ContentCategory;
use App\ContentLikeLog;
use App\Customer;
use App\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class ContentCategoryController extends Controller
{
    public function getCategoryListByCatalog($catalog_id, $offset)
    {
        $default_limit = 10;
        return ContentCategory::where('catalog_id', $catalog_id)->where('is_active', 1)->offset($offset)->limit($default_limit)->get();
    }

    public function getCategoryContents($id, $offset, Request $request)
    {
        $default_limit = 10;
        $categories = ContentCategory::where('id', $id)
                                ->where('is_active', 1)
                                ->with(array('contents' => function($query) use($default_limit, $offset) {
                                                $query->where('is_active', '1');
                                                $query->orderBy('updated_at', 'desc');
                                                $query->offset($offset)->limit($default_limit);
                                            }))
                                ->first();

        if (!$request->isTemporary) {
            $customer       = Customer::where('account_id', $request->accountId)->first();
            $likeByCustomer = ContentLikeLog::where('customer_id', $customer->id)->get(['content_id'])->implode('content_id', ',');
            $likeByCustomer = explode(',', $likeByCustomer);

            $categories->contents->map(function ($content) use ($likeByCustomer) {
                if (in_array($$content->id, $likeByCustomer)) {
                    $content->user_has_liked_this_content = true;
                }
                return $content;
            });
        }

        return $categories;
    }

    public function getUserCategories($accountId, $catalogId, Request $request)
    {
        $default_last_visit_category_date = '2018-05-01';
        $customer   = '';
        if (!$request->isTemporary) {
            $customer = Customer::where('account_id', $accountId)->first();
        }
        $categories = DB::table('content_categories')
                            ->when(!$request->isTemporary, function ($query) use ($customer, $default_last_visit_category_date) {
                                $query->select('content_categories.*');
                                return $query->selectRaw("(select count(*) from `contents` where `contents`.`category_id` = `content_categories`.`id` and date(`updated_at`) > IFNULL((select category_visit_logs.created_at from category_visit_logs where category_visit_logs.category_id=contents.category_id AND category_visit_logs.customer_id = ? ORDER BY id DESC LIMIT 1), ?) and `contents`.`deleted_at` is null) as `contents_count`", [$customer->id, $default_last_visit_category_date]);
                            })
                            ->where('catalog_id', $catalogId)
                            ->where('is_active', 1)
                            ->whereNull('deleted_at')
                            ->get();

        if (!$request->isTemporary) {
            $userCategories = CustomerCategory::where('customer_id', $customer->id)->get(['category_id'])->implode('category_id', ',');
            $userCategories = explode(',', $userCategories);

            $categories->map(function ($category) use ($userCategories) {
                if (in_array($category->id, $userCategories)) {
                    $category->is_favorite = true;
                }
                return $category;
            });
        }

        return compact('categories');
    }

    public function putUserCategory($account_id, $category_id)
    {
        $customer = Customer::where('account_id', $account_id)->first();
        $customer->categories()->toggle([$category_id]);

        $result = ['success' => 'true'];
        return compact('result');
    }

    public function postCategoryVisitLog(Request $request)
    {
        $rules = [
            'account_id'    => 'sometimes|min:32|max:64',
            'category_id'   => 'required|numeric|digits_between:1,11',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_code' => '1100',  'error' => $validator->errors()]);
        }

        $customer = Customer::where('account_id', $request->account_id)->first();
        CategoryVisitLog::create(['category_id' => $request->category_id, 'customer_id' => $customer->id]);
    }
}
