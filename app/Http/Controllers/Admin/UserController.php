<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.user.user_manage', compact('users'));
    }

    public function getEdit($id)
    {
        $user  = User::find($id);
        $roles = Role::all();
        return view('admin.user.user_edit', compact('user', 'roles'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'name'    => 'required|max:100',
            'email'   => 'required|email',
            'role_id' => 'required|numeric',
        ];
        $request['is_active'] = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? '1' : '0';

        Validator::make($request->all(), $rules)->validate();

        User::find($request->id)->update($request->all());

        return redirect('/admin/user/manage')->with('message', 'کاربر با موفقیت ذخیره شد.');
    }

    public function getChangePassword()
    {
        return view('admin.user.change_password');
    }

    public function postChangePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required|max:100',
            'new_password'     => 'required|confirmed|different:current_password|min:8|max:100|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/|',
        ];

        Validator::make($request->all(), $rules)->validate();

        if (Hash::check($request->current_password, Auth::user()->password)) {
            $user = User::find(Auth::id());
            $user->update(['password' => Hash::make($request->new_password)]);

            return redirect('/admin/user/change-password')->with('message', 'رمز عبور جدید با موفقیت ذخیره شد.');
        } else {
            return redirect('/admin/user/change-password')->withErrors(['رمز عبور فعلی صحیح نیست.']);
        }
    }
}
