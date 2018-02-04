<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('admin.article.article_manage', compact('articles'));
    }

    public function getCreate()
    {
        $categories = ArticleCategory::where('is_active', 1)->orderBy('order', 'desc')->get();
        return view('admin.article.article_create', compact('categories'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'category_id'      => 'required|numeric',
            'title'            => 'required|max:255',
//            'short_content'    => 'required',
            'content'          => 'required',
//            'image'            => 'required',
            'order'            => 'sometimes|numeric',
            'meta_keyword'     => 'sometimes|max:255',
            'meta_description' => 'sometimes|max:255',
        ];

        $request['is_active']    = ($request['is_active']    == 'on' || $request['is_active']    == '1') ? 1 : 0;
        $request['is_important'] = ($request['is_important'] == 'on' || $request['is_important'] == '1') ? 1 : 0;
        $request['can_comment']  = ($request['can_comment']  == 'on' || $request['can_comment']  == '1') ? 1 : 0;
        $request['can_like']     = ($request['can_like']     == 'on' || $request['can_like']     == '1') ? 1 : 0;

        Validator::make($request->all(), $rules)->validate();

        Article::create($request->all());

        return redirect('/admin/article/manage')->with('message', 'مطلب با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $categories = ArticleCategory::where('is_active', 1)->orderBy('order', 'desc')->get();
        $article = Article::find($id);

        return view('admin.article.article_edit', compact('article', 'categories'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'category_id'      => 'required|numeric',
            'title'            => 'required|max:255',
//            'short_content'    => 'required',
            'content'          => 'required',
//            'image'            => 'required',
            'order'            => 'sometimes|numeric',
            'meta_keyword'     => 'sometimes|max:255',
            'meta_description' => 'sometimes|max:255',
        ];

        $request['is_active']    = ($request['is_active']    == 'on' || $request['is_active']    == '1') ? 1 : 0;
        $request['is_important'] = ($request['is_important'] == 'on' || $request['is_important'] == '1') ? 1 : 0;
        $request['can_comment']  = ($request['can_comment']  == 'on' || $request['can_comment']  == '1') ? 1 : 0;
        $request['can_like']     = ($request['can_like']     == 'on' || $request['can_like']     == '1') ? 1 : 0;

        Validator::make($request->all(), $rules)->validate();

        $article = Article::find($request->id);
        $article->update($request->all());

        return redirect('/admin/article/manage')->with('message', 'مطلب با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        Article::destroy($id);
        return redirect('/admin/article/manage')->with('message', 'مطلب با موفقیت حذف شد.');
    }
}
