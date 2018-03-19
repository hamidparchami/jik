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
    Route::get('/request/display-error', 'Api\RequestController@getDisplayError')->name('display-error');
    Route::get('/request/display-menu', 'Api\RequestController@getDisplayMenu')->name('display-menu');
    
    Route::get('/category/contents/{id}', 'Api\ContentCategoryController@getCategoryContents')->where('id', '[0-9]+');
    Route::get('/category/customer-categories/{customer_id}', 'Api\ContentCategoryController@getCustomerCategories');
    Route::get('/content/view/{id}', 'Api\ContentController@getContent');
    Route::get('/test', 'Api\RequestController@getTest');
});