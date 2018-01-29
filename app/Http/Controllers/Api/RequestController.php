<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\DeliveredContent;
use App\Lib\CurlRequest;
use App\Lib\GeneralFunctions;
use App\Lib\Tesseract;
use App\RequestByMessage;
use App\RouteKeyword;
use App\Tags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    //key pairs values
    private $messaging_key_file = 'framework/keys/messaging/private.rsa';
    private $payment_key_file   = 'framework/keys/payment/private.rsa';

    //messaging values
    public $send_message_url    = 'https://cp.appson.ir/api/message/dispatch';
    public $service_id          = '99B8DACA35A34B9F905E7C5E231A2396'; //@TODO read from panel

    //payment values
    public $payment_push_otp_url    = 'https://pg.appson.ir/api/otp/push';
    public $payment_charge_url      = 'https://pg.appson.ir/api/otp/charge';

    /**
     * check signed data by messaging platform
     * @param $request
     * @return string
     */
    private function checkSignedHeaders($request)
    {
        $verify_signature = openssl_verify($request->input('appson-messaging-message'), base64_decode($request->input('appson-messaging-signature')), config('general.messaging_public_key'));
        if ($verify_signature != 1) {
            return "We do not trust you!";
        }
    }

    /**
     * @return string
     */
    private function readKeyFile($file)
    {
        //read private key file
        $key_file    = fopen(storage_path($file),"r");
        $private_key = fread($key_file, 8192);
        fclose($key_file);

        return $private_key;
    }

    /**
     * @param $content
     * @param $account_id
     * @param $customer_id
     * @param $service_id
     * @param $unique_id
     * @param string $operator
     * @param int $content_type
     * @return string
     */
    protected function sendMessageViaSMS($content, $account_id, $customer_id, $service_id, $unique_id, $operator='MCI', $content_type=0)
    {
        $private_key = openssl_pkey_get_private($this->readKeyFile($this->messaging_key_file));

        //set required body parameters
        $text = [
            'Content'       => $content,
            'SID'           => $service_id,
            'ContentType'   => $content_type,
            'AccountId'     => $account_id,
            'Operator'      => $operator,
            'Date'          => gmdate('Y-m-d H:i:s'),
            'Uid'           => GeneralFunctions::GUID(),
        ];
        $body = json_encode($text, JSON_UNESCAPED_UNICODE);

        openssl_sign($body, $signature, $private_key); //sign given data with private key
        openssl_free_key($private_key);

        //set required header parameters
        $header = [
            "SIGN"   => "SIGN:".base64_encode($signature),
        ];

        //store delivered content log
        $delivered_content = DeliveredContent::create(['customer_id' => $customer_id, 'content' => $content, 'guid' => $unique_id, 'status' => 'sent']);

        //make curl request
        $client = new CurlRequest();
        $client->setCurlHeaders($header['SIGN']);
        $client->setCurlHeaders('Content-Type: application/json');

        $result = $client->sendCurlRequest($this->send_message_url, $body);

        if (!isset($result->IsSuccess)) {
            $delivered_content->update(['status' => 'pending']);
        }

    }

    /**
     * handle requests
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReceiveRequests(Request $request)
    {
        //            Customer::create(['account_id' => $contact->getUserId(), 'phone_number' => $contact->getPhoneNumber(), 'first_name' => $contact->getFirstName(), 'last_name' => $contact->getLastName(), 'user_name' => $message->getChat()->getUsername(), 'chat_id' => $chat_id]);
//                    Customer::create(['account_id' => '123456']);

        // Add you bot's API key and name
        $bot_api_key  = config('telegram.api_key');
        $bot_username = config('telegram.username');
// Define all IDs of admin users in this array (leave as empty array if not used)
        $admin_users = [
//    123,
        ];
// Define all paths for your custom commands in this array (leave as empty array if not used)
        $commands_paths = [
//    __DIR__ . '/Commands/',
            app_path().'/Telegram/Commands/',
        ];
// Enter your MySQL database credentials
//$mysql_credentials = [
//    'host'     => 'localhost',
//    'user'     => 'dbuser',
//    'password' => 'dbpass',
//    'database' => 'dbname',
//];
        try {
            // Create Telegram API object
            $telegram = new \Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
            // Add commands paths containing your custom commands
            $telegram->addCommandsPaths($commands_paths);
            // Enable admin users
//            $telegram->enableAdmins($admin_users);
            // Enable MySQL
            //$telegram->enableMySql($mysql_credentials);
            // Logging (Error, Debug and Raw Updates)
            //Longman\TelegramBot\TelegramLog::initErrorLog(__DIR__ . "/{$bot_username}_error.log");
            //Longman\TelegramBot\TelegramLog::initDebugLog(__DIR__ . "/{$bot_username}_debug.log");
            //Longman\TelegramBot\TelegramLog::initUpdateLog(__DIR__ . "/{$bot_username}_update.log");
            // If you are using a custom Monolog instance for logging, use this instead of the above
            //Longman\TelegramBot\TelegramLog::initialize($your_external_monolog_instance);
            // Set custom Upload and Download paths
            //$telegram->setDownloadPath(__DIR__ . '/Download');
            //$telegram->setUploadPath(__DIR__ . '/Upload');
            // Here you can set some command specific parameters
            // e.g. Google geocode/timezone api key for /date command
            //$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);
            // Botan.io integration
            //$telegram->enableBotan('your_botan_token');
            // Requests Limiter (tries to prevent reaching Telegram API limits)
            $telegram->enableLimiter();
            // Handle telegram webhook request
            $telegram->handle();
        } catch (\Longman\TelegramBot\Exception\TelegramException $e) {
            // Silence is golden!
            //echo $e;
            // Log telegram errors
            \Longman\TelegramBot\TelegramLog::error($e);
        } catch (\Longman\TelegramBot\Exception\TelegramLogException $e) {
            // Silence is golden!
            // Uncomment this to catch log initialisation errors
            //echo $e;
        }
    }

    public function getTest()
    {
//        return __DIR__ . '/Commands/';

        return app_path();
    }
}
