<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        return view('admin.content.content_manage', compact('contents'));
    }

    public function getCreate()
    {
        $services = Service::where('is_active', 1)
                    ->where('date_start', '<=', Carbon::today()->format('Y-m-d'))
                    ->where('date_end', '>=', Carbon::today()->format('Y-m-d'))
                    ->get();

        return view('admin.content.content_create', compact('services'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'service_id'    => 'required|numeric|digits_between:0,11',
            'type'          => 'required|max:50',
            'send_type'     => 'required|max:50',
            'text'          => 'required_if:type,text|max:2000',
            'photo_url'     => 'required_if:type,photo|max:255',
            'video_url'     => 'required_if:type,video|max:255',
            'audio_url'     => 'required_if:type,audio|max:255',
            'order'         => 'required_if:send_type,pull|numeric|digits_between:0,11',
            'score'         => 'numeric|digits_between:0,11',
            'publish_time'  => 'required_if:send_type,push|date_format:Y/m/d H:i',
        ];

        Validator::make($request->all(), $rules)->validate();

        $request['user_id']     = Auth::id();
        $request['is_active']   = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? 1 : 0;
        Content::create($request->all());

        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $services = Service::where('is_active', 1)
                    ->where('date_start', '<=', Carbon::today()->format('Y-m-d'))
                    ->where('date_end', '>=', Carbon::today()->format('Y-m-d'))
                    ->get();

        $content = Content::find($id);

        return view('admin.content.content_edit', compact('content', 'services'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'service_id'    => 'required|numeric|digits_between:0,11',
            'type'          => 'required|max:50',
            'send_type'     => 'required|max:50',
            'text'          => 'required_if:type,text|max:2000',
            'photo_url'     => 'required_if:type,photo|max:255',
            'video_url'     => 'required_if:type,video|max:255',
            'audio_url'     => 'required_if:type,audio|max:255',
            'order'         => 'required_if:send_type,pull|numeric|digits_between:0,11',
            'score'         => 'numeric|digits_between:0,11',
            'publish_time'  => 'required_if:send_type,push|date_format:Y/m/d H:i',
        ];

        Validator::make($request->all(), $rules)->validate();

        $request['is_active']   = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? 1 : 0;

        $content = Content::find($request->id);
        $content->update($request->all());

        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        Content::destroy($id);
        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت حذف شد.');
    }
}
