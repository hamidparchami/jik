<?php

namespace App\Http\Controllers\Admin;


use App\Catalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CatalogController extends Controller
{
    public function index($parent_id = null)
    {
        if(!is_null($parent_id)) {
            $parent_catalog = Catalog::find($parent_id);
            $catalogs = Catalog::where('parent_id', $parent_id)->get();
        } else {
            $catalogs = Catalog::where('parent_id', null)->get();
        }
        return view('admin.catalog.catalog_manage', compact('catalogs', 'parent_catalog'));
    }

    public function getCreate($parent_id = null)
    {
        if(!is_null($parent_id)) {
            $parent_catalog = Catalog::find($parent_id);
        }
        return view('admin.catalog.catalog_form', compact('parent_catalog', 'parent_id'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'name' => 'required|max:100',
            'image' => 'required|max:255',
        ];

        $request['is_important'] = ($request['is_important'] == 'on' || $request['is_important'] == '1') ? '1' : '0';

        Validator::make($request->all(), $rules)->validate();

        Catalog::create($request->all());
        return redirect('/admin/catalog/manage/'.$request->parent_id)->with('message', "کاتالوگ مورد نظر ذخیره شد.");
    }

    public function getEdit($id, $parent_id = null)
    {
//        $catalogs = Catalog::all();
        $current_catalog = Catalog::find($id);
        return view('admin.catalog.catalog_form', compact('current_catalog', 'parent_id'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'name' => 'required|max:100',
            'image' => 'required|max:255',
        ];

        $request['is_important'] = ($request['is_important'] == 'on' || $request['is_important'] == '1') ? '1' : '0';

        Validator::make($request->all(), $rules)->validate();

        Catalog::find($request->id)->update($request->all());
        return redirect('/admin/catalog/manage/'.$request->parent_id)->with('message', "کاتالوگ مورد نظر ذخیره شد.");
    }

    public function getDelete($id, $parent_id = null)
    {
        Catalog::destroy($id);
        //@TODO delete related services and send a request to service getDelete() to delete related awards and winners as well
        return redirect('/admin/catalog/manage/'.$parent_id)->with('message', "کاتالوگ مورد نظر حذف شد.");
    }
}
