<?php

namespace App\Http\Controllers\Admin;

use App\Award;
use App\AwardStaticPage;
use App\AwardStaticPageImage;
use App\AwardType;
use App\AwardWinner;
use App\Lib\GeneralFunctions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Validator;

class ServiceAwardController extends Controller
{
    /**
     * @param $service_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($service_id)
    {
        $awards = Award::where('service_id', $service_id)->get();
        return view('admin.service.service_award_manage', compact('awards', 'service_id'));
    }

    /**
     * @param $service_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate($service_id)
    {
        $award_types = AwardType::all();
        return view('admin.service.service_award_create', compact('award_types', 'service_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $rules = [
            'award_type_id'      => 'required|numeric',
            'title'              => 'required|max:255',
            'count'              => 'required|numeric|digits_between:0,11',
            'description'        => 'required',
            'order'              => 'sometimes|numeric',
            'display_date_start' => 'required|date',
            'display_date_end'   => 'required|date',
            'minimum_point'      => 'required|numeric|digits_between:0,11',
            'price'              => 'sometimes|numeric|digits_between:0,11',
        ];

/*        if ((!is_null($request['display_date_start']) && $request['display_date_start'] != '') || (!is_null($request['display_date_end']) && $request['display_date_end'] != '')) {
            $rules['display_date_start'] = 'sometimes|required|date';
            $rules['display_date_end'] = 'sometimes|required|date';
        } else {
            $request['display_date_start'] = null;
            $request['display_date_end']   = null;
        }*/
        $request['important'] = ($request['important'] == 'on' || $request['important'] == '1') ? '1' : '0';

        Validator::make($request->all(), $rules)->validate();

        if (!is_null($request->input('image')) && $request->input('image') != '') {
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

            //resize award image
            $sizes = [
                ['width' => 260, 'height' => 260], //small
                ['width' => 550, 'height' => 270], //medium
            ];
            for ($i = 0; $i < count($sizes); $i++) {
                $image_name = 'upload/photos/thumbnails/awards/' . substr(basename($request->input('image')), 0, -4) . '-' . $sizes[$i]['width'] . 'x' . $sizes[$i]['height'] . substr(basename($request->input('image')), -4);

                if (!file_exists($image_name)) {
                    $image = Image::make($request->input('image'))->resize($sizes[$i]['width'], null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->resizeCanvas($sizes[$i]['width'], $sizes[$i]['height']);
                    $image->save(public_path($image_name));
                }
            }
        }

        Award::create($request->all());
        return redirect('/admin/service/award/service_id/'.$request->service_id)->with('message', "جایزه مورد نظر ذخیره شد.");
    }

    /**
     * @param $service_id
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($service_id, $id)
    {
        $award = Award::find($id);
        $award_types = AwardType::all();
        return view('admin.service.service_award_edit', compact('award', 'award_types', 'service_id'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(Request $request)
    {
        $rules = [
            'award_type_id'      => 'required|numeric',
            'title'              => 'required|max:255',
            'count'              => 'required|numeric|digits_between:0,11',
            'description'        => 'required',
            'order'              => 'sometimes|numeric',
            'display_date_start' => 'required|date',
            'display_date_end'   => 'required|date',
            'minimum_point'      => 'required|numeric|digits_between:0,11',
            'price'              => 'sometimes|numeric|digits_between:0,11',
        ];

        /*if ((!is_null($request['display_date_start']) && $request['display_date_start'] != '') || (!is_null($request['display_date_end']) && $request['display_date_end'] != '')) {
            $rules['display_date_start'] = 'sometimes|required|date';
            $rules['display_date_end'] = 'sometimes|required|date';
        } else {
            $request['display_date_start'] = null;
            $request['display_date_end']   = null;
        }*/
        $request['important'] = ($request['important'] == 'on' || $request['important'] == '1') ? '1' : '0';

        Validator::make($request->all(), $rules)->validate();

        if (!is_null($request->input('image')) && $request->input('image') != '') {
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

            //resize award image
            $sizes = [
                ['width' => 260, 'height' => 260], //small
                ['width' => 550, 'height' => 270], //medium
            ];
            for ($i = 0; $i < count($sizes); $i++) {
                $image_name = 'upload/photos/thumbnails/awards/' . substr(basename($request->input('image')), 0, -4) . '-' . $sizes[$i]['width'] . 'x' . $sizes[$i]['height'] . substr(basename($request->input('image')), -4);

                if (!file_exists($image_name)) {
                    $image = Image::make($request->input('image'))->resize($sizes[$i]['width'], null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->resizeCanvas($sizes[$i]['width'], $sizes[$i]['height']);
                    $image->save(public_path($image_name));
                }
            }
        }

        Award::find($request->id)->update($request->all());
        return redirect('/admin/service/award/service_id/'.$request->service_id)->with('message', "جایزه مورد نظر ذخیره شد.");
    }

    /**
     * @param $service_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($service_id, $id)
    {
        DB::transaction(function () use($service_id, $id) {
            Award::destroy($id);
            AwardWinner::where('award_id', $id)->delete();
        });

        return redirect('/admin/service/award/service_id/'.$service_id)->with('message', "جایزه مورد نظر حذف شد.");
    }

    public function getWinner($service_id, $award_id)
    {
        $winners = AwardWinner::where('award_id', $award_id)->get();
        return view('admin.service.service_award_winner', compact('winners', 'service_id', 'award_id'));
    }

    public function postWinner(Request $request)
    {
        parse_str($_POST['data'], $parsed_input);

        $total_winner_forms = (isset($parsed_input['name'])) ? count($parsed_input['name']) : 0;
        $total_winner_deletes = (isset($parsed_input['delete_id'])) ? count($parsed_input['delete_id']) : 0;

        $input = [];
        $rules = [];
        $label = [];
        for($i=0; $i < $total_winner_forms; $i++) {
            //inputs
            $input['name_'.$i]    = $parsed_input['name'][$i];
            $input['surname_'.$i] = $parsed_input['surname'][$i];
            $input['phone_'.$i]   = $parsed_input['phone'][$i];
            //rules
            $rules['name_'.$i]    = 'required';
            $rules['surname_'.$i] = 'required';
            $rules['phone_'.$i]   = 'required|numeric|digits_between:0,11';
            //labels
            $label['name_'.$i] = 'نام شماره ' . $i;
            $label['surname_'.$i] = 'نام خانوادگی شماره ' . $i;
            $label['phone_'.$i] = 'شماره تماس شماره ' . $i;
        }

        /*$validator = Validator::make($input, $rules);
        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }*/
        Validator::make($input, $rules)->setAttributeNames($label)->validate();

        //insert service record into DB for each service (method form)
        for ($i = 0; $i < $total_winner_forms; $i++) {
            if (isset($parsed_input['winner_id'][$i])) {
                AwardWinner::find($parsed_input['winner_id'][$i])->update([
                    'name'    => $parsed_input['name'][$i],
                    'surname' => $parsed_input['surname'][$i],
                    'phone'   => $parsed_input['phone'][$i],
                    'photo'   => (isset($parsed_input['photo'][$i]) && !is_null($parsed_input['photo'][$i]) && $parsed_input['photo'][$i] != '  ') ? $parsed_input['photo'][$i] : null,
                ]);
            } else {
                //check image dimensions
                //900x450 is the standard size
                if (isset($parsed_input['photo'][$i]) && file_exists($parsed_input['photo'][$i])) {
                    $image_path = parse_url($parsed_input['photo'][$i]);
                    $image_path = substr($image_path['path'], 1); //retrieve image by request to local server by removing domain from image path
                    $image_dimensions = getimagesize($image_path);
                    $allowed_dimensions = ['min_width' => 880, 'min_height' => 430, 'max_width' => 920, 'max_height' => 470];
                    if (!(GeneralFunctions::checkDimensions($image_dimensions, $allowed_dimensions))) {
                        $errors = ['ابعاد تصویر صحیح نیست.'];
                        return redirect()->back()->withErrors($errors)->withInput();
                    }
                }

                AwardWinner::create([
                    'award_id' => $parsed_input['award_id'],
                    'name'     => $parsed_input['name'][$i],
                    'surname'  => $parsed_input['surname'][$i],
                    'phone'    => $parsed_input['phone'][$i],
                    'photo'    => (isset($parsed_input['photo'][$i]) && !is_null($parsed_input['photo'][$i]) && $parsed_input['photo'][$i] != '  ') ? $parsed_input['photo'][$i] : null,
                ]);
            }
        }

        for ($j=0; $j < $total_winner_deletes; $j++) {
            AwardWinner::destroy($parsed_input['delete_id'][$j]);
        }

//        $award = Award::find($parsed_input['award_id']);
        return 'true';
//        return redirect('/admin/service/award/service_id/'.$parsed_input['service_id'])->with('message', "تغببرات برندگان ". $award->title . " اعمال شد.");
    }

    public function getPageEdit($service_id, $award_id)
    {
        $page = AwardStaticPage::firstOrCreate(['award_id' => $award_id]);
        $images = AwardStaticPageImage::where('static_page_id', $page->id)->get();
        return view('admin.service.service_award_page', compact('page', 'images', 'service_id', 'award_id'));
    }

    public function postPageEdit(Request $request)
    {
        AwardStaticPage::find($request->page_id)->update($request->all());

        return redirect('/admin/service/award/service_id/'.$request->service_id)->with('message', "صفحه جایزه با موفقیت ذخیره شد.");
    }

    public function postAddPageImage(Request $request)
    {
        $rules = [
            'static_page_id' => 'required|numeric',
            'image' => 'required|max:255',
        ];

        Validator::make($request->all(), $rules)->validate();

        AwardStaticPageImage::create($request->all());
        Session::flash('message', 'عکس مورد نظر با موفقیت ذخیره شد!');
    }

    public function getDeletePageImage(Request $request)
    {
        AwardStaticPageImage::destroy($request->input('id'));
        Session::flash('message', 'عکس مورد نظر حذف شد!');
        return 'true';
    }
}
