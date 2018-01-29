<?php

namespace App\Http\Controllers\Admin;

use App\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::where('parent_id', 0)->orderBy('order', 'desc')->get();
        return view('admin.url.url_manage', compact('urls'));
    }

    public function getCreate()
    {
        $parents = Url::where('parent_id', 0)->orderBy('order', 'desc')->get();
        return view('admin.url.url_create', compact('parents'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'order' => 'sometimes|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();

        Url::create($request->all());

        return redirect('/admin/url/manage')->with('message', 'آدرس URL با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $url = Url::find($id);
        $parents = Url::where('parent_id', 0)->orderBy('order', 'desc')->get();
        return view('admin.url.url_edit', compact('url', 'parents'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'order' => 'sometimes|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();

        Url::find($request->id)->update($request->all());

        return redirect('/admin/url/manage')->with('message', 'آدرس URL با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        DB::transaction(function () use($id) {
            Url::destroy($id);
            Url::where('parent_id', $id)->delete();
        });

        return redirect('/admin/url/manage')->with('message', 'آدرس URL با موفقیت حذف شد.');
    }

    public function createUrl()
    {
        Url::create(['parent_id' => 0, 'url' => 'admin/home', 'title' => 'داشبورد']);
    }
}
