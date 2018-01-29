<?php

namespace App\Http\Controllers\Admin;

use App\AwardType;
use App\Lib\GeneralFunctions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AwardController extends Controller
{
    public function index()
    {
        $awards = AwardType::all();
        return view('admin.award.award_manage', compact('awards'));
    }

    public function getCreate()
    {
        return view('admin.award.award_create');
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'image' => 'required',
        ];

        Validator::make($request->all(), $rules)->validate();

        //check image dimensions
        //900x450 is the standard size
        $image_path = parse_url($request->image);
        $image_path = substr($image_path['path'], 1); //retrieve image by request to local server by removing domain from image path
        $image_dimensions   = getimagesize($image_path);
        $allowed_dimensions = ['min_width' => 880, 'min_height' => 430, 'max_width' => 920, 'max_height' => 470];
        if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions))) {
            $errors = ['ابعاد تصویر صحیح نیست.'];
            return redirect()->back()->withErrors($errors)->withInput();
        }

        AwardType::create($request->all());
        return redirect('/admin/award/manage')->with('message', "جایزه مورد نظر ذخیره شد.");
    }

    public function getEdit($id)
    {
        $award = AwardType::find($id);
        return view('admin.award.award_edit', compact('award'));
    }


    public function postEdit(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'image' => 'required',
        ];

        Validator::make($request->all(), $rules)->validate();

        //check image dimensions
        //900x450 is the standard size
        $image_path = parse_url($request->image);
        $image_path = substr($image_path['path'], 1);
        $image_dimensions   = getimagesize($image_path);
        $allowed_dimensions = ['min_width' => 880, 'min_height' => 430, 'max_width' => 920, 'max_height' => 470];
        if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions))) {
            $errors = ['ابعاد تصویر صحیح نیست.'];
            return redirect()->back()->withErrors($errors)->withInput();
        }

        AwardType::find($request->id)->update($request->all());
        return redirect('/admin/award/manage')->with('message', "جایزه مورد نظر ذخیره شد.");
    }
}
