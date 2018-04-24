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
    //Catalog resource
    Route::get('/catalog/list', 'Api\CatalogController@getCatalogList');
    //Category resource
    Route::get('/category/contents/{id}', 'Api\ContentCategoryController@getCategoryContents')->where('id', '[0-9]+');
    Route::get('/category/list-by-catalog/{catalog_id}', 'Api\ContentCategoryController@getCategoryListByCatalog')->where('catalog_id', '[0-9]+');
    Route::get('/category/user-favorite/{user_id}', 'Api\ContentCategoryController@getUserCategories');
    Route::put('/category/user-favorite/{user_id}/toggle/{category_id}', 'Api\ContentCategoryController@putUserCategory')->where('category_id', '[0-9]+');
    //Content resource
    Route::get('/content/list-by-category/{category_id}', 'Api\ContentController@getContentListByCategory')->where('category_id', '[0-9]+');
    Route::get('/content/view/{id}', 'Api\ContentController@getContentView');
    Route::get('/content/user-feed/{user_id}/catalog/{catalog_id}/{offset?}', 'Api\ContentController@getUserFeed');

});