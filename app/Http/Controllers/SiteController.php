<?php

namespace App\Http\Controllers;

use App\Award;
use App\Catalog;
use App\Event;
use App\Service;
use App\SliderImages;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * main page on frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return 'Jikopeek.ir';
        $slider_images = SliderImages::where('is_active', 1)->get();
        $catalogs      = Catalog::where('is_important', 1)->get();

        return view('frontend.index', compact('slider_images', 'catalogs'));
    }

    public function getCatalogList()
    {
        $catalogs = Catalog::whereNull('parent_id')->get();
        return view('frontend.catalog.catalog_list', compact('catalogs'));
    }

    public function getCatalogView($id)
    {
        $catalog = Catalog::find($id);
        $services = Service::where('catalog_id', $id)->where('is_active', 1)->where('date_start', '<=', Carbon::today()->format('Y-m-d'))->where('date_end', '>=', Carbon::today()->format('Y-m-d'))->get();
        return view('frontend.catalog.catalog_view', compact('services', 'catalog'));
    }

    public function getAllAwards()
    {
        $awards = Award::with('service')->where('display_date_start', '<', Carbon::today())->where('display_date_end', '>', Carbon::today())->orderBy('order', 'desc')->get();
        return view('frontend.all_awards', compact('awards'));
    }

    public function getAllDeliveredAwards()
    {
        $delivered_awards = Award::with('service')->with('winners')->where('display_date_end', '<', Carbon::today())->orderBy('order', 'desc')->get();
        return view('frontend.all_delivered_awards', compact('delivered_awards'));
    }
}
