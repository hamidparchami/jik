<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Lib\CurlRequest;
use App\Lib\GeneralFunctions;
use App\Lib\Sms_SendMessage;
use App\TemporaryToken;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;

class CustomerController extends Controller
{
    public function sendSMS($mobile_numbers, $messages)
    {
            date_default_timezone_set("Asia/Tehran");

            // sending date
            @$SendDateTime = date("Y-m-d")."T".date("H:i:s");

            $SmsIR_SendMessage = new Sms_SendMessage(config('general.sms_ir_APIKey'), config('general.sms_ir_SecretKey'), config('general.sms_ir_LineNumber'));
            $SendMessage = $SmsIR_SendMessage->SendMessage([$mobile_numbers], [$messages], $SendDateTime);
//            Log::info($SendMessage);
    }

    public function postGenerateOTP(Request $request)
    {
        //validate phone number
        $rules = [
            'account_id'    => 'sometimes|min:32|max:64',
            'phone_number'  => ['required', 'regex:/09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}/'],
        ];

        $messages = [
            'phone_number.required' => 'لطفا شماره موبایل خود را وارد کنید.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_code' => '1010',  'error' => $validator->errors()]);
        }

        //check maximum request @TODO
        //create or first customer
        $account_id = (!empty($request->account_id)) ? $request->account_id : GeneralFunctions::GUID();
//        $customer = Customer::firstOrCreate(['account_id' => $account_id, 'phone_number' => $request->phone_number]);
        $customer = Customer::updateOrCreate(
                                            ['phone_number' => $request->phone_number],
                                            ['account_id' => $account_id]
                                            );
        //generate OTP
        $otp = rand(1000, 9999);
        //store OTP
        Token::create(['customer_id' => $customer->id, 'otp' => $otp]);
        //send OTP via SMS
        $otp_message = 'کد احراز هویت شما: ' . $otp;
        $this->sendSMS($customer->phone_number, $otp_message);
        //return result
        $success = true;
        return compact('success', 'account_id', 'otp');
    }

    public function putVerifyOTP(Request $request)
    {
        //validate otp pattern and account id
        $rules = [
            'account_id'    => 'required|min:32|max:64',
            'otp'           => 'required|numeric|digits:4',
        ];

        $messages = [
            'otp.required' => 'لطفا کد دریافتی از طریق پیامک را وارد کنید.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_code' => '1020', 'error' => $validator->errors()]);
        }

        //find customer
        $customer = Customer::where('account_id', $request->account_id)->first();
        //get latest valid otp in db (does no have token)
        $token = Token::where('customer_id', $customer->id)
                        ->where('otp', $request->otp)
                        ->whereNull('token')
                        ->orderBy('id', 'desc')
                        ->first();
        //if succeed
        if (!is_null($token)) {
            $success            = true;
            $generated_token    = Hash::make(uniqid()); //generate token
            //store token
            $token->update(['token' => $generated_token, 'is_valid' => 1]);
            //return token
            return compact('success', 'generated_token');
        } else {
            //return error
            $success    = false;
            $error_code = '1021';
            $error      = (object)['otp' => 'OTP is not correct.'];
            return compact('success', 'error_code', 'error');
        }
    }

    public function postStartTrial()
    {
        //generate temporary token and set viewed contents count to 0
        $success            = true;
        $generated_token    = md5(str_random(12).microtime()); //generate token
        $remaining_trial_contents_count = config('general.allowed_view_content_count');
        //store token
        TemporaryToken::create(['token' => $generated_token, 'is_valid' => 1, 'viewed_contents_count' => 0]);
        //return token
        return compact('success', 'generated_token', 'remaining_trial_contents_count');
    }

    public function postRequestSubscriptionOtp(Request $request)
    {
        //normalize phone number
        $request->merge(['phone_number' => GeneralFunctions::convertToLatinNumbers($request->phone_number)]);

        //validate phone number
        $rules = [
            'account_id'    => 'sometimes|min:32|max:64',
            'phone_number'  => ['required', 'regex:/09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}/'],
        ];

        $messages = [
            'phone_number.required' => 'لطفا شماره موبایل خود را وارد کنید.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_code' => '1010',  'error' => $validator->errors()]);
        }

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
            $success = true;
            return compact('success', 'accountId');
        } else {
            //error between our server and aggregator!
            return response()->json(['success' => false, 'error_code' => '1040', 'error' => (object)['subscription_otp' => 'خطا در ارتباط با سرور اپراتور!<br> لطفا چند دقیقه دیگر مجدد تلاش کنید.']]);
        }
    }

    public function postRequestSubscriptionOtpVerification(Request $request)
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

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_code' => '1020', 'error' => $validator->errors()]);
        }

        //search for customer and correlator @TODO test
        $token  = Token::where('account_id', $request->account_id)->orderBy('created_at', 'desc')->first();

        if (empty($token)) {
            //customer not found!
            return response()->json(['success' => false, 'error_code' => '1030', 'error' => (object)['account' => 'customer account not found!']]);
        }

        //prepare data for send @TODO test
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
            //return token
            return compact('success', 'generated_token');
        } else {
            //OTP is not correct!
            return response()->json(['success' => false, 'error_code' => '1021', 'error' => (object)['otp' => 'کد وارد شده صحیح نیست!']]);
        }
    }
}
