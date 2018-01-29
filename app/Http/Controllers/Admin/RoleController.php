<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.role_manage', compact('roles'));
    }

    public function getCreate()
    {
        $urls = Url::where('parent_id', 0)->orderBy('order', 'desc')->get();
        return view('admin.role.role_create', compact('urls'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'name' => 'required|max:100',
        ];

        Validator::make($request->all(), $rules)->validate();

        Role::create($request->all())->urls()->sync(explode(',', $request['allowed_urls']));

        return redirect('/admin/role/manage')->with('message', 'نقش با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $role = Role::find($id);
        $urls = Url::where('parent_id', 0)->orderBy('order', 'desc')->get();
        $allowed_urls = $role->urls->pluck('id')->toArray();

        return view('admin.role.role_edit', compact('role', 'urls', 'allowed_urls'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'name' => 'required|max:100',
        ];

        Validator::make($request->all(), $rules)->validate();

        $role = Role::find($request->id);
        $role->update($request->all());
        $role->urls()->sync(explode(',', $request['allowed_urls']));

        return redirect('/admin/role/manage')->with('message', 'نقش مورد نظر با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        DB::transaction(function () use($id) {
            $role = Role::find($id);
            $role->delete();
            $role->urls()->detach();
        });

        return redirect('/admin/role/manage')->with('message', 'نقش مورد نظر با موفقیت حذف شد.');
    }
}
