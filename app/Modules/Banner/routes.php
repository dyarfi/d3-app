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
    // Portfolios DataTables routes
    Route::get('banner/datatable', 'App\Modules\Banner\Controller\Banners@datatable')->name('admin.banners.datatable');
    // banners Controller routes
    Route::get('banner', 'App\Modules\Banner\Controller\Banners@index')->name('admin.banners.index');
    Route::get('banner/export', 'App\Modules\Banner\Controller\Banners@export')->name('admin.banners.export');
    Route::get('banner/create', 'App\Modules\Banner\Controller\Banners@create')->name('admin.banners.create');
    Route::post('banner/create', 'App\Modules\Banner\Controller\Banners@store')->name('admin.banners.store');
    Route::post('banner/change', 'App\Modules\Banner\Controller\Banners@change')->name('admin.banners.change');
    // Put the method with the parameter below the static method
    Route::get('banner/{id}/show', 'App\Modules\Banner\Controller\Banners@show')->name('admin.banners.show');
    Route::get('banner/{id}', 'App\Modules\Banner\Controller\Banners@edit')->name('admin.banners.edit');
    Route::post('banner/{id}', 'App\Modules\Banner\Controller\Banners@update')->name('admin.banners.update');
    Route::get('banner/{id}/trash', 'App\Modules\Banner\Controller\Banners@trash')->name('admin.banners.trash');
    Route::get('banner/{id}/restored', 'App\Modules\Banner\Controller\Banners@restored')->name('admin.banners.restored');
    Route::get('banner/{id}/delete', 'App\Modules\Banner\Controller\Banners@delete')->name('admin.banners.delete');

});
