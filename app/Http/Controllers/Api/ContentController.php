<?php

namespace App\Http\Controllers\Api;

use App\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    public function getContentListByCategory($category_id, $order='asc')
    {
        return Content::where('category_id', $category_id)->where('is_active', 1)->orderBy('id', $order)->get();
    }

    public function getContentView($id)
    {
        return Content::where('id', $id)->where('is_active', 1)->first();
    }

    public function getUserFeed($user_id)
    {
        //@TODO
    }
}
