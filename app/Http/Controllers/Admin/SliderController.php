<?php

namespace App\Http\Controllers\Admin;

use App\SliderImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class SliderController extends Controller
{
    public function index()
    {
        $slider_images = SliderImages::all();
        return view('admin.slider.slider_manage', compact('slider_images'));
    }

    public function getCreate()
    {
        return view('admin.slider.slider_form');
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'title'       => 'required|max:100',
            'link'      => 'required|max:255',
            'image'      => 'required|max:255',
        ];

        Validator::make($request->all(), $rules)->validate();

        $request['status'] = ($request['status'] == 'on' || $request['status'] == '1') ? 1 : 0;
        SliderImages::create($request->all());

        return redirect('/admin/slider/manage')->with('message', 'اسلاید با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $slider_image = SliderImages::find($id);
        return view('admin.slider.slider_form', compact('slider_image'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'title'       => 'required|max:100',
            'link'      => 'required|max:255',
            'image'      => 'required|max:255',
        ];

        Validator::make($request->all(), $rules)->validate();

        $request['status'] = ($request['status'] == 'on' || $request['status'] == '1') ? 1 : 0;
        $slider_image = SliderImages::find($request->id);
        $slider_image->update($request->all());

        return redirect('/admin/slider/manage')->with('message', 'اسلاید با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        SliderImages::destroy($id);
        return redirect('/admin/slider/manage')->with('message', 'اسلاید با موفقیت حذف شد.');
    }
}
