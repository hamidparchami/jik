<?php

namespace App\Http\Controllers;

use App\Article;
use App\Award;
use App\Catalog;
use App\Content;
use App\Event;
use App\Like;
use App\Service;
use App\SliderImages;
use App\VariableValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SiteController extends Controller
{
    /**
     * main page on frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
/*        $like = Like::create(['customer_id' => 963852, 'customer_name' => 'Hamid Parchami', 'content_id' => 123654]);
        if ($like) {
            return 'succeed';
        } else {
            return 'error';
        }*/
        return view('frontend.index');
    }

    public function getArticle($id)
    {
        $article = Article::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.article.article_view', compact('article'));
    }

    public function getContent($id)
    {
        $content = Content::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.content.content_view', compact('content'));
    }

    public function getDownloadLandingPage()
    {
        $downloadDescription = VariableValue::where('variable', 'download_description')->get()->first();
        $downloadLinkForAndroid = VariableValue::where('variable', 'download_link_for_android')->get()->first();

        return view('frontend.landing.download', compact('downloadDescription', 'downloadLinkForAndroid'));
    }

    public function getShortUrl($id)
    {
//        $article = Article::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.short_url_view'/*, compact('article')*/);
    }

}
