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

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function () {
    //Request resource
    Route::post('/request/reception', 'Api\RequestController@postReceiveRequests');
    Route::get('/request/display-error', 'Api\RequestController@getDisplayError')->name('display-error');
    Route::get('/request/display-menu', 'Api\RequestController@getDisplayMenu')->name('display-menu');
    //Catalog resource
    Route::get('/catalog/list', 'Api\CatalogController@getCatalogList');
    //Category resource
    Route::get('/category/contents/{id}/offset/{offset}', 'Api\ContentCategoryController@getCategoryContents')->where('id', '[0-9]+');
    Route::get('/category/list-by-catalog/{catalog_id}/offset/{offset}', 'Api\ContentCategoryController@getCategoryListByCatalog')->where('catalog_id', '[0-9]+');
    Route::get('/category/user-favorite/{accountId?}/catalog/{catalogId}', 'Api\ContentCategoryController@getUserCategories');
    Route::put('/category/user-favorite/{account_id}/toggle/{category_id}', 'Api\ContentCategoryController@putUserCategory')->where('category_id', '[0-9]+');
    Route::post('/category/visit-log', 'Api\ContentCategoryController@postCategoryVisitLog');
    //Content resource
    Route::get('/content/list-by-category/{category_id}', 'Api\ContentController@getContentListByCategory')->where('category_id', '[0-9]+');
    Route::get('/content/view/{id}', 'Api\ContentController@getView');
    Route::get('/content/user-feed/{account_id}/catalog/{catalog_id}/offset/{offset?}', 'Api\ContentController@getUserFeed');
    Route::post('/content/view/add-count', 'Api\ContentController@postAddViewCount');
//    Route::get('/content/view/customer-log', 'Api\ContentController@postCustomerViewLog');
    Route::post('/content/like', 'Api\ContentController@postLike');
    //OTP
    Route::post('/customer/generate-otp', 'Api\CustomerController@postGenerateOtp');
    Route::put('/customer/verify-otp', 'Api\CustomerController@putVerifyOTP');
    Route::post('/customer/start-trial', 'Api\CustomerController@postStartTrial');
    Route::post('/customer/request-subscription-otp', 'Api\CustomerController@postRequestSubscriptionOtp');
    Route::put('/customer/request-subscription-otp-verification', 'Api\CustomerController@postRequestSubscriptionOtpVerification');
    //Aggregator
    Route::post('/aggregator/mo', 'Api\AggregatorController@postMo');
    Route::post('/aggregator/renewal', 'Api\AggregatorController@postRenewal');
    Route::post('/aggregator/notification', 'Api\AggregatorController@postNotification');
});