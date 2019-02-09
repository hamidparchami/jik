<?php

namespace App\Http\Controllers;

use App\Article;
use App\Content;
use App\Customer;
use App\Lib\CurlRequest;
use App\Lib\GeneralFunctions;
use App\Token;
use App\VariableValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class SiteController extends Controller
{
    /**
     * main page on frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function getArticle($id)
    {
        $article = Article::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.article.article_view', compact('article'));
    }

    public function getContent($id)
    {
        $content = Content::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.content.content_view', compact('content'));
    }

    public function getDownloadLandingPage()
    {
        $downloadDescription = VariableValue::where('variable', 'download_description')->get(['value'])->first();
        $downloadLinkForAndroid = VariableValue::where('variable', 'download_link_for_android')->get(['value'])->first();

        return view('frontend.landing.download', compact('downloadDescription', 'downloadLinkForAndroid'));
    }

    public function getShortUrl($id)
    {
//        $article = Article::where('id', $id)->where('is_active', 1)->get()->first();
        return view('frontend.short_url_view'/*, compact('article')*/);
    }

    public function getSubscribe(Request $request)
    {
        $step = !empty($request->step) ? $request->step : null;
        $accountId = !empty($request->account_id) ? $request->account_id : null;
        return view('frontend.landing.subscribe', compact('step', 'accountId'));
    }

    public function postSubscribe(Request $request)
    {
        //normalize phone number
        $request->merge(['phone_number' => GeneralFunctions::convertToLatinNumbers($request->phone_number)]);

        //validate phone number
        $rules = [
            //this regex is only for MCI. for all mobile numbers (MCI, Irancell, Rightel) use this: /09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}/
            'phone_number'  => ['bail', 'required', 'size:11', 'regex:/09(0[1-2]|1[0-9])-?[0-9]{3}-?[0-9]{4}/'],
        ];

        $messages = [
            'phone_number.required' => 'لطفا شماره موبایل خود را وارد کنید.',
            'phone_number.size'     => 'شماره موبایل را بصورت ۱۱ رقمی وارد کنید.',
            'phone_number.regex'    => 'متاسفانه در حال حاضر فقط مشترکین همراه اول امکان عضویت دارند.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //prepare data for send
        $url        = config('general.red9_base_url') . config('general.red9_otp_subscribe');
        $body['country_code']       = '98';
        $body['national_number']    = $request->phone_number;

        //send a request to aggregator for subscription OTP
        $client = new CurlRequest();
        $client->setCurlHeaders('api-key: ' . config('general.red9_api_key'));
        $client->setCurlHeaders('Content-Type: application/json');
        $client->setCurlHeaders('Cache-Control: no-cache');
        $response = $client->sendCurlRequest($url, 'POST', json_encode($body));
        $response = json_decode($response);
        $responseCode = substr($client->http_code, 0, 1);
        if ($responseCode == 2) {
            //create or get first customer
            $accountId = (!empty($request->account_id)) ? $request->account_id : GeneralFunctions::GUID();
            $customer = Customer::updateOrCreate(
                ['phone_number' => $request->phone_number],
                ['account_id' => $accountId]
            );
            //store phone number and correlator in db
            Token::create(['customer_id' => $customer->id, 'account_id' => $accountId, 'correlator' => $response->correlator]);
            //return success and ask user about OTP
            return redirect('/subscribe?step=otp&account_id='.$accountId)
                    ->with('message', "لطفا کد چهار رقمی دریافت شده در پیامک را وارد کنید.");
        } else {
            //error between our server and aggregator!
            return redirect()->back()->withErrors(['subscription_otp' => 'خطا در ارتباط با سرور! لطفا چند دقیقه دیگر مجدد تلاش کنید.']);
        }
    }

    public function postVerifyOtp(Request $request)
    {
        //normalize otp
        $request->merge(['otp' => GeneralFunctions::convertToLatinNumbers($request->otp)]);

        //validate otp pattern and account id
        $rules = [
            'account_id'    => 'required|min:32|max:64',
            'otp'           => 'required|numeric|digits:4',
        ];

        $messages = [
            'otp.required' => 'لطفا کد دریافتی از طریق پیامک را وارد کنید.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //search for customer and correlator
        $token  = Token::where('account_id', $request->account_id)->orderBy('created_at', 'desc')->first();

        if (empty($token)) {
            //customer not found!
            return redirect('subscribe?step=account_not_found')->withErrors(['account' => 'اکانت شما پیدا نشد لطفا دوباره تلاش کنید!']);
        }

        //prepare data for send
        $url    = config('general.red9_base_url') . config('general.red9_otp_confirm_subscribe');
        $body['correlator'] = $token->correlator;
        $body['pin']        = $request->otp;
        //send a request to aggregator for OTP validation
        $client = new CurlRequest();
        $client->setCurlHeaders('api-key: ' . config('general.red9_api_key'));
        $client->setCurlHeaders('Content-Type: application/json');
        $client->setCurlHeaders('Cache-Control: no-cache');
        $client->sendCurlRequest($url, 'POST', json_encode($body));

        $responseCode = substr($client->http_code, 0, 1);
        $responseBody = json_decode($client->response);
        if ($responseCode == 2 || ($responseCode == 5 && $responseBody->errorCode == 'SVC726')) {
            $success            = true;
            $generated_token    = Hash::make(uniqid()); //generate token
            //store token
            $token->update(['token' => $generated_token, 'is_valid' => 1]);
            //return result
            return redirect('/subscribe?step=subscribed');
        } else {
            //OTP is not correct!
            return redirect()->back()->withErrors(['otp' => 'کد وارد شده صحیح نیست! کد دریافتی را با دقت وارد کنید.']);
        }
    }

}
