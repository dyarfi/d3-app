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
    // Tasks Controller routes
    Route::get('task', 'App\Modules\Task\Controller\Tasks@index')->name('admin.tasks.index');
    Route::get('task/create', 'App\Modules\Task\Controller\Tasks@create')->name('admin.tasks.create');
    Route::post('task/create', 'App\Modules\Task\Controller\Tasks@store')->name('admin.tasks.store');
    Route::post('task/change', 'App\Modules\Task\Controller\Tasks@change')->name('admin.tasks.change');
    // Put the method with the parameter below the static method         
    Route::get('task/{id}/show', 'App\Modules\Task\Controller\Tasks@show')->name('admin.tasks.show');
    Route::get('task/{id}', 'App\Modules\Task\Controller\Tasks@edit')->name('admin.tasks.edit');
    Route::post('task/{id}', 'App\Modules\Task\Controller\Tasks@update')->name('admin.tasks.update');
    Route::get('task/{id}/trash', 'App\Modules\Task\Controller\Tasks@trash')->name('admin.tasks.trash');
    Route::get('task/{id}/restored', 'App\Modules\Task\Controller\Tasks@restored')->name('admin.tasks.restored');
    Route::get('task/{id}/delete', 'App\Modules\Task\Controller\Tasks@delete')->name('admin.tasks.delete');

});