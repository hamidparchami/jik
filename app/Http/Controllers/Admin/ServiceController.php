<?php

namespace App\Http\Controllers\Admin;


use App\Lib\GeneralFunctions;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Catalog;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('catalog')->get();
        return view('admin.service.service_manage', compact('services'));
    }

    public function getCreate()
    {
        $catalogs = Catalog::where('is_active', 1)->get();
        return view('admin.service.service_create', compact('catalogs'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'catalog_id'        => 'required|max:255',
            'name'              => 'required|max:255',
            'cover_image'       => 'required',
            'icon'              => 'required',
            'short_description' => 'required',
            'price_description' => 'required',
            'manual_register_description' => 'required',
            'increase_points_description' => 'required',
            'disable_service_description' => 'required',
            'welcome_message'   => 'required',
            /*'date_start'        => 'required|date',
            'date_end'          => 'required|date',
            'display_awards_date_start'   => 'required|date',
            'display_awards_date_end'     => 'required|date',*/
        ];

        Validator::make($request->all(), $rules)->validate();

        //check cover image dimensions
        //1110x450 is the standard size
        $image_path = parse_url($request['cover_image']);
        $image_path = substr($image_path['path'], 1); //retrieve image by request to local server by removing domain from image path
        $image_dimensions   = getimagesize($image_path);
        $allowed_dimensions = ['min_width' => 1110, 'min_height' => 450];
        if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions))) {
            return Redirect::back()->withInput()->withErrors(['ابعاد عکس کاور صحیح نیست.']);
        }

        //check icon image dimensions
        $image_path = parse_url($request['icon']);
        $image_path = substr($image_path['path'], 1); //retrieve image by request to local server by removing domain from image path
        $image_dimensions   = getimagesize($image_path);
        $allowed_dimensions = ['min_width' => 512, 'min_height' => 512];
        if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions, "1:1"))) {
            return Redirect::back()->withInput()->withErrors(['ابعاد آیکن صحیح نیست.']);
        }

        $request['is_active'] = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? '1' : '0';

        Service::create($request->all());

        return redirect('/admin/service/manage')->with('message', "سرویس مورد نظر ذخیره شد.");
    }

    public function getEdit($id)
    {

        $service = Service::find($id);
        $catalogs = Catalog::where('is_active', 1)->get();

        return view('admin.service.service_edit', compact('service', 'catalogs'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'catalog_id'                => 'required|max:255',
            'name'              => 'required|max:255',
            'cover_image'       => 'required',
            'icon'              => 'required',
            'short_description' => 'required',
            'price_description' => 'required',
            'manual_register_description' => 'required',
            'increase_points_description' => 'required',
            'disable_service_description' => 'required',
            'welcome_message'   => 'required',
            /*'date_start'        => 'required|date',
            'date_end'          => 'required|date',
            'display_awards_date_start'   => 'required|date',
            'display_awards_date_end'     => 'required|date',*/
        ];

        Validator::make($request->all(), $rules)->validate();

        //check cover image dimensions
        //1110x450 is the standard size
        $image_path = parse_url($request['cover_image']);
        $image_path = substr($image_path['path'], 1); //retrieve image by request to local server by removing domain from image path
        $image_dimensions   = getimagesize($image_path);
        $allowed_dimensions = ['min_width' => 1110, 'min_height' => 450];
        if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions))) {
            return Redirect::back()->withInput()->withErrors(['ابعاد عکس کاور صحیح نیست.']);
        }

        //check icon image dimensions
        $image_path = parse_url($request['icon']);
        $image_path = substr($image_path['path'], 1); //retrieve image by request to local server by removing domain from image path
        $image_dimensions   = getimagesize($image_path);
        $allowed_dimensions = ['min_width' => 512, 'min_height' => 512];
        if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions, "1:1"))) {
            return Redirect::back()->withInput()->withErrors(['ابعاد آیکن صحیح نیست.']);
        }

        $request['is_active'] = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? '1' : '0';

        $service = Service::find($request->id);
        $service->update($request->all());

        return redirect('/admin/service/manage')->with('message', "سرویس مورد نظر ذخیره شد.");
    }

    public function getDelete($id)
    {
        DB::transaction(function () use($id) {
            Service::destroy($id);
            //@TODO delete related awards and winners
        });

        return redirect('/admin/service/manage')->with('message', "سرویس مورد نظر حذف شد.");
    }
}
