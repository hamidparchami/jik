<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Lib\GeneralFunctions;
use App\Lib\Sms_SendMessage;
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
}
