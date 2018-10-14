<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AggregatorController extends Controller
{
    public function postMo(Request $request)
    {
        Log::useDailyFiles(storage_path().'/logs/mo.log');
        Log::info(json_encode($request->all()).PHP_EOL.PHP_EOL);

        return 'true';
    }

    public function postRenewal(Request $request)
    {
        Log::useDailyFiles(storage_path().'/logs/renewal.log');
        Log::info(json_encode($request->all()).PHP_EOL.PHP_EOL);

        return 'true';
    }

    public function postNotification(Request $request)
    {
        Log::useDailyFiles(storage_path().'/logs/notification.log');
        Log::info(json_encode($request->all()).PHP_EOL.PHP_EOL);

        return 'true';
    }
}
