<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ContentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class ContentCategoryController extends Controller
{
    public function index()
    {
        $categories = ContentCategory::all();
        return view('admin.content.content_category_manage', compact('categories'));
    }

    public function getCreate()
    {
        $categories = ContentCategory::where('parent_id', 0)->where('is_active', 1)->orderBy('order', 'desc')->get();
        return view('admin.content.content_category_create', compact('categories'));
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

        ContentCategory::create($request->all());

        return redirect('/admin/content-category/manage')->with('message', 'دسته با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $categories = ContentCategory::where('parent_id', 0)->where('is_active', 1)->orderBy('order', 'desc')->get();
        $category   = ContentCategory::find($id);

        return view('admin.content.content_category_edit', compact('categories', 'category'));
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

        $content = ContentCategory::find($request->id);
        $content->update($request->all());

        return redirect('/admin/content-category/manage')->with('message', 'دسته با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        DB::transaction(function () use($id) {
            ContentCategory::destroy($id);
            ContentCategory::where('parent_id', $id)->delete();
            Article::where('category_id', $id)->delete();
        });
        return redirect('/admin/content-category/manage')->with('message', 'دسته با موفقیت حذف شد.');
    }
}
