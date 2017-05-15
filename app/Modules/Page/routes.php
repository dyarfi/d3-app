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
   
    // Pages Controller routes
    Route::get('page', ['as'=>'admin.pages.index','uses'=>'App\Modules\Page\Controller\Pages@index']);
    Route::get('page/create', ['as'=>'admin.pages.create','uses'=>'App\Modules\Page\Controller\Pages@create']);
    Route::post('page/create', ['as'=>'admin.pages.store','uses'=>'App\Modules\Page\Controller\Pages@store']);
    Route::post('page/change', ['as'=>'admin.pages.change','uses'=>'App\Modules\Page\Controller\Pages@change']);    
    // Put the method with the parameter below the static method     
    Route::get('page/{id}/show', ['as'=>'admin.pages.show', 'uses'=>'App\Modules\Page\Controller\Pages@show']);
    Route::get('page/{id}', ['as'=>'admin.pages.edit','uses'=>'App\Modules\Page\Controller\Pages@edit']);
    Route::post('page/{id}', ['as'=>'admin.pages.update','uses'=>'App\Modules\Page\Controller\Pages@update']);
    Route::get('page/{id}/trash', ['as'=>'admin.pages.trash','uses'=>'App\Modules\Page\Controller\Pages@trash']);    
    Route::get('page/{id}/restored', ['as'=>'admin.pages.restored','uses'=>'App\Modules\Page\Controller\Pages@restored']);
    Route::get('page/{id}/delete', ['as'=>'admin.pages.delete','uses'=>'App\Modules\Page\Controller\Pages@delete']);

    // Menus Controller routes
    Route::get('menu', ['as'=>'admin.menus.index','uses'=>'App\Modules\Page\Controller\Menus@index']);
    Route::get('menu/create', ['as'=>'admin.menus.create','uses'=>'App\Modules\Page\Controller\Menus@create']);
    Route::post('menu/create', ['as'=>'admin.menus.store','uses'=>'App\Modules\Page\Controller\Menus@store']);
    Route::post('menu/change', ['as'=>'admin.menus.change','uses'=>'App\Modules\Page\Controller\Menus@change']);
    // Put the method with the parameter below the static method 
    Route::get('menu/{id}/show', ['as'=>'admin.menus.show', 'uses'=>'App\Modules\Page\Controller\Menus@show']);
    Route::get('menu/{id}', ['as'=>'admin.menus.edit','uses'=>'App\Modules\Page\Controller\Menus@edit']);
    Route::post('menu/{id}', ['as'=>'admin.menus.update','uses'=>'App\Modules\Page\Controller\Menus@update']);
    Route::get('menu/{id}/trash', ['as'=>'admin.menus.trash','uses'=>'App\Modules\Page\Controller\Menus@trash']);    
    Route::get('menu/{id}/restored', ['as'=>'admin.menus.restored','uses'=>'App\Modules\Page\Controller\Menus@restored']);
    Route::get('menu/{id}/delete', ['as'=>'admin.menus.delete','uses'=>'App\Modules\Page\Controller\Menus@delete']);
    
});