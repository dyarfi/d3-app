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
Route::prefix(config('setting.admin_url'))->group( function()
{
   
    // Pages Controller routes
    Route::get('page', 'App\Modules\Page\Controller\Pages@index')->name('admin.pages.index');
    Route::get('page/create', 'App\Modules\Page\Controller\Pages@create')->name('admin.pages.create');
    Route::post('page/create', 'App\Modules\Page\Controller\Pages@store')->name('admin.pages.store');
    Route::post('page/change', 'App\Modules\Page\Controller\Pages@change')->name('admin.pages.change'); 
    // Put the method with the parameter below the static method     
    Route::get('page/{id}/show', 'App\Modules\Page\Controller\Pages@show')->name('admin.pages.show');
    Route::get('page/{id}', 'App\Modules\Page\Controller\Pages@edit')->name('admin.pages.edit');
    Route::post('page/{id}', 'App\Modules\Page\Controller\Pages@update')->name('admin.pages.update');
    Route::get('page/{id}/trash', 'App\Modules\Page\Controller\Pages@trash')->name('admin.pages.trash');
    Route::get('page/{id}/restored', 'App\Modules\Page\Controller\Pages@restored')->name('admin.pages.restored');
    Route::get('page/{id}/delete', 'App\Modules\Page\Controller\Pages@delete')->name('admin.pages.delete');

    // Menus Controller routes
    Route::get('menu', 'App\Modules\Page\Controller\Menus@index')->name('admin.menus.index');
    Route::get('menu/create', 'App\Modules\Page\Controller\Menus@create')->name('admin.menus.create');
    Route::post('menu/create', 'App\Modules\Page\Controller\Menus@store')->name('admin.menus.store');
    Route::post('menu/change', 'App\Modules\Page\Controller\Menus@change')->name('admin.menus.change');
    // Put the method with the parameter below the static method 
    Route::get('menu/{id}/show', 'App\Modules\Page\Controller\Menus@show')->name('admin.menus.show');
    Route::get('menu/{id}', 'App\Modules\Page\Controller\Menus@edit')->name('admin.menus.edit');
    Route::post('menu/{id}', 'App\Modules\Page\Controller\Menus@update')->name('admin.menus.update');
    Route::get('menu/{id}/trash', 'App\Modules\Page\Controller\Menus@trash')->name('admin.menus.trash');
    Route::get('menu/{id}/restored', 'App\Modules\Page\Controller\Menus@restored')->name('admin.menus.restored');
    Route::get('menu/{id}/delete', 'App\Modules\Page\Controller\Menus@delete')->name('admin.menus.delete');
    
});