<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\TemporaryToken;
use App\Token;
use Validator;

class ReportController extends Controller
{
    public function index()
    {
        $reportSubscribersUrl = config('general.red9_base_url') . '/api/client/subscribers?service=jikopik';
        //send a request to aggregator for subscribers report
        $client = new CurlRequest();
        $client->setCurlHeaders('client-key: ' . config('general.red9_client_key'));
        $client->setCurlHeaders('Content-Type: application/json');
        $client->setCurlHeaders('Cache-Control: no-cache');
        $client->sendCurlRequest($reportSubscribersUrl, 'GET');
        $responseBody = json_decode($client->response);
        $totalSubscribers = (!empty($responseBody->count)) ? $responseBody->count : 0;

        //receive data from MongoDB
        $activeTokens = Token::where('is_valid', 1)->count();
        $temporaryTokens = TemporaryToken::where('is_valid', 1)->count();

        return view('admin.report.report_manage', compact('activeTokens', 'temporaryTokens', 'totalSubscribers'));
    }
}
