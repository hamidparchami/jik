<?php

namespace App\Http\Controllers\Api;

use App\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    public function getContent($id)
    {
        return Content::where('id', $id)->where('is_active', 1)->get();
    }
}
