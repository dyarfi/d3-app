<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// ******************* Admin Routes ********************* { //
/*
 *
 * Administrator panel routes
 *
 */
Route::group(['prefix' => config('setting.admin_url')], function()
{

     // banners Controller routes
    Route::get('banner', ['as'=>'admin.banners.index','uses'=>'App\Modules\Banner\Controller\banners@index']);
    Route::get('banner/create', ['as'=>'admin.banners.create','uses'=>'App\Modules\Banner\Controller\banners@create']);
    Route::post('banner/create', ['as'=>'admin.banners.store','uses'=>'App\Modules\Banner\Controller\banners@store']);
    Route::post('banner/change', ['as'=>'admin.banners.change','uses'=>'App\Modules\Banner\Controller\banners@change']);
    // Put the method with the parameter below the static method
    Route::get('banner/{id}/show', ['as'=>'admin.banners.show', 'uses'=>'App\Modules\Banner\Controller\banners@show']);
    Route::get('banner/{id}', ['as'=>'admin.banners.edit','uses'=>'App\Modules\Banner\Controller\banners@edit']);
    Route::post('banner/{id}', ['as'=>'admin.banners.update','uses'=>'App\Modules\Banner\Controller\banners@update']);
    Route::get('banner/{id}/trash', ['as'=>'admin.banners.trash','uses'=>'App\Modules\Banner\Controller\banners@trash']);
    Route::get('banner/{id}/restored', ['as'=>'admin.banners.restored','uses'=>'App\Modules\Banner\Controller\banners@restored']);
    Route::get('banner/{id}/delete', ['as'=>'admin.banners.delete','uses'=>'App\Modules\Banner\Controller\banners@delete']);

});