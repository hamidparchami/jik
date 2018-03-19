<?php

namespace App\Http\Controllers\Api;

use App\ContentCategory;
use App\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentCategoryController extends Controller
{
    public function getCategoryContents($id)
    {
        return ContentCategory::where('id', $id)->where('is_active', 1)->with('contents')->first();
    }

    public function getCustomerCategories($customer_id)
    {
        $categories = ContentCategory::where('is_active', 1)->get();

        $customer_categories = CustomerCategory::where('customer_id', $customer_id)->get(['category_id'])->implode('category_id', ',');
        $customer_categories = explode(',', $customer_categories);

        return compact('categories', 'customer_categories');
    }
}
