<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\ContentCategory;
use App\Customer;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Longman\TelegramBot\Request as TelegramRequest;
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

        $categories = ContentCategory::where('is_active', 1)->get();

        return view('admin.content.content_create', compact('services', 'categories'));
    }

    public function postCreate(Request $request)
    {
        $rules = [
            'service_id'    => 'required|numeric|digits_between:0,11',
            'category_id'   => 'required|numeric|digits_between:0,11',
            'type'          => 'required|max:50',
            'send_type'     => 'required|max:50',
            'text'          => 'required_if:type,text|max:2000',
            'full_content'  => 'required_if:type,text|max:50000',
            'photo_url'     => 'required_if:type,photo|max:255',
            'video_url'     => 'required_if:type,video|max:255',
            'audio_url'     => 'required_if:type,audio|max:255',
            'order'         => 'required_if:send_type,pull|numeric|digits_between:0,11',
            'score'         => 'numeric|digits_between:0,11',
            'reference'     => 'sometimes|max:4080',
            'publish_time'  => 'required_if:send_type,push|date_format:Y/m/d H:i',
        ];

        Validator::make($request->all(), $rules)->validate();

        $request['user_id']     = Auth::id();
        $request['is_active']   = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? 1 : 0;
        $request['show_instant_view']   = ($request['show_instant_view'] == 'on' || $request['show_instant_view'] == '1') ? 1 : 0;
        Content::create($request->all());

        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت ذخیره شد.');
    }

    public function getEdit($id)
    {
        $services = Service::where('is_active', 1)
                    ->where('date_start', '<=', Carbon::today()->format('Y-m-d'))
                    ->where('date_end', '>=', Carbon::today()->format('Y-m-d'))
                    ->get();

        $categories = ContentCategory::where('is_active', 1)->get();
        $content = Content::find($id);

        return view('admin.content.content_edit', compact('content', 'services', 'categories'));
    }

    public function postEdit(Request $request)
    {
        $rules = [
            'service_id'    => 'required|numeric|digits_between:0,11',
            'category_id'   => 'required|numeric|digits_between:0,11',
            'type'          => 'required|max:50',
            'send_type'     => 'required|max:50',
            'text'          => 'required_if:type,text|max:2000',
            'full_content'  => 'required_if:type,text|max:50000',
            'photo_url'     => 'required_if:type,photo|max:255',
            'video_url'     => 'required_if:type,video|max:255',
            'audio_url'     => 'required_if:type,audio|max:255',
            'order'         => 'required_if:send_type,pull|numeric|digits_between:0,11',
            'score'         => 'numeric|digits_between:0,11',
            'reference'     => 'sometimes|max:4080',
            'publish_time'  => 'required_if:send_type,push|date_format:Y/m/d H:i',
        ];

        Validator::make($request->all(), $rules)->validate();

        $request['is_active']   = ($request['is_active'] == 'on' || $request['is_active'] == '1') ? 1 : 0;
        $request['show_instant_view']   = ($request['show_instant_view'] == 'on' || $request['show_instant_view'] == '1') ? 1 : 0;

        $content = Content::find($request->id);
        $content->update($request->all());

        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت ذخیره شد.');
    }

    public function getDelete($id)
    {
        Content::destroy($id);
        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت حذف شد.');
    }

    public function getLastContentOrder($category_id, $content_id=null)
    {
        $content = Content::where('category_id', $category_id)->where('id', '<', $content_id)->where('id', '!=', $content_id)->orderBy('id', 'desc')->get()->first();
//        (is_null($content_id)) ?: $content->where('id', '!=', $content_id);
//        $content->orderBy('id', 'desc')->get()->first();

        return $content;
    }

    public function getSendContentToAdmin($id, $username)
    {
        // Add bot's API key and name
        $bot_api_key  = config('telegram.api_key');
        $bot_username = config('telegram.username');
        $telegram = new \Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

        $content    = Content::find($id);
        $customer   = Customer::where('username', $username)->first();

        $text = $content->text . PHP_EOL . sprintf("محتوای کامل را در Instant View ببینید: ". PHP_EOL ." https://t.me/iv?url=%s/%d&rhash=e6f66e7d26291d", url('/content/'), $content->id);
        $data = [
            'chat_id' => $customer->chat_id,
            'text' => $text,
        ];
        TelegramRequest::sendMessage($data);

        return redirect('/admin/content/manage')->with('message', 'محتوا با موفقیت ارسال شد.');
    }
}
