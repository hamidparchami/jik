<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::all();
        return view('admin.article.article_category_manage', compact('categories'));
    }

    public function getCreate()
    {
        $categories = ArticleCategory::where('parent_id', 0)->where('is_active', 1)->orderBy('order', 'desc')->get();
        return view('admin.article.article_category_create', compact('categories'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'parent_id' => 'numeric',
            'name'      => 'required|max:255',
        ];

        $request['is_active']    = ($request['is_active']    == 'on' || $request['is_active']    == '1') ? 1 : 0;
        $request['is_important'] = ($request['is_important'] == 'on' || $request['is_important'] == '1') ? 1 : 0;

        Validator::make($request->all(), $rules)->validate();

        ArticleCategory::create($request->all());

        return redirect('/admin/article-category/manage')->with('message', 'دسته با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $categories = ArticleCategory::where('parent_id', 0)->where('is_active', 1)->orderBy('order', 'desc')->get();
        $category   = ArticleCategory::find($id);

        return view('admin.article.article_category_edit', compact('categories', 'category'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'parent_id' => 'numeric',
            'name'      => 'required|max:255',
        ];

        $request['is_active']    = ($request['is_active']    == 'on' || $request['is_active']    == '1') ? 1 : 0;
        $request['is_important'] = ($request['is_important'] == 'on' || $request['is_important'] == '1') ? 1 : 0;

        Validator::make($request->all(), $rules)->validate();

        $article = ArticleCategory::find($request->id);
        $article->update($request->all());

        return redirect('/admin/article-category/manage')->with('message', 'دسته با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        DB::transaction(function () use($id) {
            ArticleCategory::destroy($id);
            ArticleCategory::where('parent_id', $id)->delete();
            Article::where('category_id', $id)->delete();
        });
        return redirect('/admin/article-category/manage')->with('message', 'دسته با موفقیت حذف شد.');
    }
}
