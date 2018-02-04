<?php

namespace App\Http\Controllers;

use App\Article;
use App\Award;
use App\Catalog;
use App\Event;
use App\Service;
use App\SliderImages;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * main page on frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return 'Jikopeek.ir';
        $slider_images = SliderImages::where('is_active', 1)->get();
        $catalogs      = Catalog::where('is_important', 1)->get();

        return view('frontend.index', compact('slider_images', 'catalogs'));
    }

    public function getArticle($id)
    {
        $article = Article::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.article.article_view', compact('article'));
    }

}
