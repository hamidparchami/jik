<?php

namespace App\Http\Controllers\Api;

use App\ContentCategory;
use App\Customer;
use App\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentCategoryController extends Controller
{
    public function getCategoryListByCatalog($catalog_id, $offset)
    {
        $default_limit = 10;
        return ContentCategory::where('catalog_id', $catalog_id)->where('is_active', 1)->offset($offset)->limit($default_limit)->get();
    }

    public function getCategoryContents($id, $offset)
    {
        $default_limit = 10;
        return ContentCategory::where('id', $id)
                                ->where('is_active', 1)
                                ->with(array('contents' => function($query) use($default_limit, $offset) {
                                                $query->offset($offset)->limit($default_limit);
                                            }))
                                ->first();
    }

    public function getUserCategories($user_id)
    {
        $categories = ContentCategory::where('is_active', 1)->get();

        $user_categories = CustomerCategory::where('customer_id', $user_id)->get(['category_id'])->implode('category_id', ',');
        $user_categories = explode(',', $user_categories);

        $categories->map(function ($category) use ($user_categories) {
            if (in_array($category['id'], $user_categories)) {
                $category['is_favorite'] = true;
            }
            return $category;
        });

        return compact('categories');
    }

    public function putUserCategory($user_id, $category_id)
    {
        $customer = Customer::find($user_id);
        $customer->categories()->toggle([$category_id]);

        $result = ['success' => 'true'];
        return compact('result');
    }
}
