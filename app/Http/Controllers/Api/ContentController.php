<?php

namespace App\Http\Controllers\Api;

use App\Content;
use App\ContentCategory;
use App\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    const FEED_CONTENTS_CHUNK_SIZE = 10;

    public function getContentListByCategory($category_id, $order='asc')
    {
        return Content::where('category_id', $category_id)->where('is_active', 1)->orderBy('id', $order)->get();
    }

    public function getContentView($id)
    {
        return Content::where('id', $id)->where('is_active', 1)->first();
    }

    public function getUserFeed($account_id, $catalog_id, $offset=1)
    {
        //get all categories in requested catalog
        $catalog_categories = ContentCategory::where('catalog_id', $catalog_id)->get(['id'])->implode('id', ',');
        $catalog_categories = (strpos($catalog_categories, ',')) ? explode(',', $catalog_categories) : str_split($catalog_categories, 1);

        //get all user categories in requested catalog
        $user_categories    = CustomerCategory::whereHas('customer', function($q) use($account_id) {
                                                       $q->where('account_id', $account_id);
                                                })
                                                ->whereIn('category_id', $catalog_categories)
                                                ->get(['category_id'])
                                                ->implode('category_id', ',');

        $user_categories = (strpos($user_categories, ',')) ? explode(',', $user_categories) : str_split($user_categories, 1);

        //check if user has any favorite category or not, if not warn customer to select at least one category
        if (count($user_categories) == 0 || strlen($user_categories[0]) == 0) {
            $result = [
                    'success'   => false,
                    'code'      => 2100,
                    'message'   => "برای استفاده از امکانات ابتدا علاقه‌مندی‌هات رو از طریق زیر مشخص کن.",
                    ];
            
            return compact('result');
        }

        //get all contents in customer categories
        $take = $offset*self::FEED_CONTENTS_CHUNK_SIZE;
        $skip = ($offset > 1) ? $take-self::FEED_CONTENTS_CHUNK_SIZE : 0;
        $contents = Content::whereIn('category_id', $user_categories)
                            ->where('is_active', '1')
                            ->orderBy('order', 'desc')
                            ->skip($skip)
                            ->take($take)
                            ->get();

        return compact('contents');
    }
}
