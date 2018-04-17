<?php

namespace App\Http\Controllers\Api;

use App\ContentCategory;
use App\Customer;
use App\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentCategoryController extends Controller
{
    public function getCategoryListByCatalog($catalog_id)
    {
        return ContentCategory::where('catalog_id', $catalog_id)->where('is_active', 1)->get();
    }

    public function getCategoryContents($id)
    {
        return ContentCategory::where('id', $id)->where('is_active', 1)->with('contents')->first();
    }

    public function getUserCategories($user_id)
    {
//        $categories = ContentCategory::where('is_active', 1)->get();

        $user_categories = CustomerCategory::where('customer_id', $user_id)->get(['category_id'])->implode('category_id', ',');
        $user_categories = explode(',', $user_categories);

        return compact('user_categories');
    }

    public function putUserCategory($user_id, $category_id)
    {
        $customer = Customer::find($user_id);
        $customer->categories()->toggle([$category_id]);

        $result = ['success' => 'true'];
        return compact('result');
    }
}
