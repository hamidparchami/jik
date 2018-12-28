<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*if (!App::environment('local')) {
    URL::forceSchema('https');
}*/

Route::get('/', 'SiteController@index');

Auth::routes();

//Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'user.role', 'user.account_status']], function () {
    Route::get('/', function (){
        return redirect('/admin/home');
    });

    Route::get('/home', 'HomeController@index');
    //User
    Route::get('/user/manage', 'Admin\UserController@index');
    Route::get('/user/edit/id/{id}', 'Admin\UserController@getEdit');
    Route::post('/user/edit/id/{id}', 'Admin\UserController@postEdit');
    Route::get('/user/change-password', 'Admin\UserController@getChangePassword');
    Route::post('/user/change-password', 'Admin\UserController@postChangePassword');
    //Role
    Route::get('/role/manage', 'Admin\RoleController@index');
    Route::get('/role/create', 'Admin\RoleController@getCreate');
    Route::post('/role/create', 'Admin\RoleController@postCreate');
    Route::get('/role/edit/id/{id}', 'Admin\RoleController@getEdit');
    Route::post('/role/edit/id/{id}', 'Admin\RoleController@postEdit');
    Route::get('/role/delete/id/{id}', 'Admin\RoleController@getDelete');
    //Url
    Route::get('/url/manage', 'Admin\UrlController@index');
    Route::get('/url/create', 'Admin\UrlController@getCreate');
    Route::post('/url/create', 'Admin\UrlController@postCreate');
    Route::get('/url/edit/id/{id}', 'Admin\UrlController@getEdit');
    Route::post('/url/edit/id/{id}', 'Admin\UrlController@postEdit');
    Route::get('/url/delete/id/{id}', 'Admin\UrlController@getDelete');
    Route::get('/url/create-url', 'Admin\UrlController@createUrl');
    //Content Category
    Route::get('/content-category/manage', 'Admin\ContentCategoryController@index');
    Route::get('/content-category/create', 'Admin\ContentCategoryController@getCreate');
    Route::post('/content-category/create', 'Admin\ContentCategoryController@postCreate');
    Route::get('/content-category/edit/id/{id}', 'Admin\ContentCategoryController@getEdit');
    Route::post('/content-category/edit/id/{id}', 'Admin\ContentCategoryController@postEdit');
    Route::get('/content-category/delete/id/{id}', 'Admin\ContentCategoryController@getDelete');
    //Content
    Route::get('/content/manage', 'Admin\ContentController@index');
    Route::get('/content/create', 'Admin\ContentController@getCreate');
    Route::post('/content/create', 'Admin\ContentController@postCreate');
    Route::get('/content/edit/id/{id}', 'Admin\ContentController@getEdit');
    Route::post('/content/edit/id/{id}', 'Admin\ContentController@postEdit');
    Route::get('/content/delete/id/{id}', 'Admin\ContentController@getDelete');
    Route::get('/content/last-content-order/category_id/{category_id}/content_id/{content_id}', 'Admin\ContentController@getLastContentOrder');
    Route::get('/content/send-to-admin/id/{id}/username/{username}', 'Admin\ContentController@getSendContentToAdmin');
    //Catalog
    Route::get('/catalog/manage/{parent_id?}', 'Admin\CatalogController@index');
    Route::get('/catalog/create/{parent_id?}', 'Admin\CatalogController@getCreate');
    Route::post('/catalog/create/{parent_id?}', 'Admin\CatalogController@postCreate');
    Route::get('/catalog/edit/id/{id}/{parent_id?}', 'Admin\CatalogController@getEdit');
    Route::post('/catalog/edit/id/{id}/{parent_id?}', 'Admin\CatalogController@postEdit');
    Route::get('/catalog/delete/id/{id}/{parent_id?}', 'Admin\CatalogController@getDelete');
    //Service
    Route::get('/service/manage', 'Admin\ServiceController@index');
    Route::get('/service/create', 'Admin\ServiceController@getCreate');
    Route::post('/service/create', 'Admin\ServiceController@postCreate');
    Route::get('/service/edit/id/{id}', 'Admin\ServiceController@getEdit');
    Route::post('/service/edit/id/{id}', 'Admin\ServiceController@postEdit');
    Route::get('/service/delete/id/{id}', 'Admin\ServiceController@getDelete');
    //Service Awards
    Route::get('/service/award/service_id/{service_id}', 'Admin\ServiceAwardController@index');
    Route::get('/service/award/create/service_id/{service_id}', 'Admin\ServiceAwardController@getCreate');
    Route::post('/service/award/create/service_id/{service_id}', 'Admin\ServiceAwardController@postCreate');
    Route::get('/service/award/edit/service_id/{service_id}/award_id/{id}', 'Admin\ServiceAwardController@getEdit');
    Route::post('/service/award/edit/service_id/{service_id}/award_id/{id}', 'Admin\ServiceAwardController@postEdit');
    Route::get('/service/award/delete/service_id/{service_id}/award_id/{id}', 'Admin\ServiceAwardController@getDelete');
    //Award winners
    Route::get('/service/award/winner/service_id/{service_id}/award_id/{award_id}', 'Admin\ServiceAwardController@getWinner');
    Route::post('/service/award/winner/service_id/{service_id}/award_id/{award_id}', 'Admin\ServiceAwardController@postWinner');
    //Award Types
    Route::get('/award/manage', 'Admin\AwardController@index');
    Route::get('/award/create', 'Admin\AwardController@getCreate');
    Route::post('/award/create', 'Admin\AwardController@postCreate');
    Route::get('/award/edit/id/{id}', 'Admin\AwardController@getEdit');
    Route::post('/award/edit/id/{id}', 'Admin\AwardController@postEdit');
    //Slider
    Route::get('/slider/manage', 'Admin\SliderController@index');
    Route::get('/slider/create', 'Admin\SliderController@getCreate');
    Route::post('/slider/create', 'Admin\SliderController@postCreate');
    Route::get('/slider/edit/id/{id}', 'Admin\SliderController@getEdit');
    Route::post('/slider/edit/id/{id}', 'Admin\SliderController@postEdit');
    Route::get('/slider/delete/id/{id}', 'Admin\SliderController@getDelete');
    //Article Category
    Route::get('/article-category/manage', 'Admin\ArticleCategoryController@index');
    Route::get('/article-category/create', 'Admin\ArticleCategoryController@getCreate');
    Route::post('/article-category/create', 'Admin\ArticleCategoryController@postCreate');
    Route::get('/article-category/edit/id/{id}', 'Admin\ArticleCategoryController@getEdit');
    Route::post('/article-category/edit/id/{id}', 'Admin\ArticleCategoryController@postEdit');
    Route::get('/article-category/delete/id/{id}', 'Admin\ArticleCategoryController@getDelete');
    //Article
    Route::get('/article/manage', 'Admin\ArticleController@index');
    Route::get('/article/create', 'Admin\ArticleController@getCreate');
    Route::post('/article/create', 'Admin\ArticleController@postCreate');
    Route::get('/article/edit/id/{id}', 'Admin\ArticleController@getEdit');
    Route::post('/article/edit/id/{id}', 'Admin\ArticleController@postEdit');
    Route::get('/article/delete/id/{id}', 'Admin\ArticleController@getDelete');
    //VariableValue
    Route::get('/variable-value/manage', 'Admin\VariableValueController@index');
    Route::get('/variable-value/create', 'Admin\VariableValueController@getCreate');
    Route::post('/variable-value/create', 'Admin\VariableValueController@postCreate');
    Route::get('/variable-value/edit/id/{id}', 'Admin\VariableValueController@getEdit');
    Route::post('/variable-value/edit/id/{id}', 'Admin\VariableValueController@postEdit');
    Route::get('/variable-value/delete/id/{id}', 'Admin\VariableValueController@getDelete');
});


//Catalog
Route::get('catalog/list', 'SiteController@getCatalogList');
Route::get('catalog/{id}', 'SiteController@getCatalogView');

//Service
Route::get('service/landing/{id}', 'ServiceController@getViewServiceLanding');
Route::get('service/{id}', 'ServiceController@getServiceInformation');
Route::get('service/{id}/delivered-awards', 'ServiceController@getServiceDeliveredAwards');
Route::get('service/{id}/awards', 'ServiceController@getServiceAwards');
Route::get('service/{id}/information', 'ServiceController@getServiceInformation');
Route::post('service/register', 'ServiceController@postRegister');
Route::post('service/verify-number', 'ServiceController@postVerifyNumber');

//Service Awards
Route::get('service/award/{award_id}/page', 'ServiceController@getServiceAwardStaticPage');

//Route::get('/general/generate-piqo-guid', 'SiteController@generatePIQOGUID');
Route::get('/all-awards', 'SiteController@getAllAwards');
Route::get('/all-delivered-awards', 'SiteController@getAllDeliveredAwards');
Route::post('/general/submit-piqo-payment-result', 'SiteController@getSubmitPiqoPaymentResult');

Route::get('/article/{id}', 'SiteController@getArticle');
Route::get('/content/{id}', 'SiteController@getContent');
Route::get('/l/{id}', 'SiteController@getShortUrl');
Route::get('/file-get-contents', 'SiteController@getFileGetContents');
Route::get('/download', 'SiteController@getDownloadLandingPage');