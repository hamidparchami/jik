<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {
    //Request resource
    Route::post('/request/reception', 'Api\RequestController@postReceiveRequests');
    Route::get('/request/display-error',                'Api\RequestController@getDisplayError')->name('display-error');
    Route::get('/request/display-menu',                 'Api\RequestController@getDisplayMenu')->name('display-menu');
    Route::get('/request/display-fetriyeh-description', 'Api\RequestController@getDisplayFetriyehDescription')->name('display-fetriyeh-description');
    Route::get('/request/calculate-fetriyeh',           'Api\RequestController@getCalculateFetriyeh')->name('calculate-fetriyeh');
//    Route::get('/request/settle-fetrieh-payment',       'Api\RequestController@getSettleFetriehPayment')->name('settle-fetrieh-payment');
    Route::get('/request/display-kaffareh-description', 'Api\RequestController@getDisplayKaffarehDescription')->name('display-kaffareh-description');
    Route::get('/request/calculate-kaffareh',           'Api\RequestController@getCalculateKaffareh')->name('calculate-kaffareh');
//    Route::get('/request/settle-kaffareh-payment',       'Api\RequestController@getSettleKaffarehPayment')->name('settle-kaffareh-payment');
    Route::get('/request/check-payment-otp',            'Api\RequestController@getCheckOTP')->name('check-payment-otp');

    //Charge User Score
    Route::get('/get-new-auto-charge',      'Api\PointsController@getNewAutoChargeFromPayment');
    Route::get('/set-charged-users-score',  'Api\PointsController@setChargedUsersScore');

    //User Score
    Route::post('/get-user-point',  'Api\PointsController@getUserPoint');
    Route::get('/test',  'Api\RequestController@getTest');
});