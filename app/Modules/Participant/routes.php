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
    Route::get('participant/datatable', 'App\Modules\Participant\Controller\Participants@datatable')->name('admin.participants.datatable');
    // Participants Controller routes
    Route::get('participant', 'App\Modules\Participant\Controller\Participants@index')->name('admin.participants.index');
    Route::get('participant/export', 'App\Modules\Participant\Controller\Participants@export')->name('admin.participants.export');
    Route::get('participant/create', 'App\Modules\Participant\Controller\Participants@create')->name('admin.participants.create');
    Route::post('participant/create', 'App\Modules\Participant\Controller\Participants@store')->name('admin.participants.store');
    Route::post('participant/change', 'App\Modules\Participant\Controller\Participants@change')->name('admin.participants.change');
    // Put the method with the parameter below the static method
    Route::get('participant/{id}/show', 'App\Modules\Participant\Controller\Participants@show')->name('admin.participants.show');
    Route::get('participant/{id}', 'App\Modules\Participant\Controller\Participants@edit')->name('admin.participants.edit');
    Route::post('participant/{id}', 'App\Modules\Participant\Controller\Participants@update')->name('admin.participants.update');
    Route::get('participant/{id}/trash', 'App\Modules\Participant\Controller\Participants@trash')->name('admin.participants.trash');
    Route::get('participant/{id}/restored', 'App\Modules\Participant\Controller\Participants@restored')->name('admin.participants.restored');
    Route::get('participant/{id}/delete', 'App\Modules\Participant\Controller\Participants@delete')->name('admin.participants.delete');

    // Participant Images Controller routes
    Route::get('images', 'App\Modules\Participant\Controller\Images@index')->name('admin.images.index');
    Route::get('images/create', 'App\Modules\Participant\Controller\Images@create')->name('admin.images.create');
    Route::post('images/create', 'App\Modules\Participant\Controller\Images@store')->name('admin.images.store');
    Route::post('images/change', 'App\Modules\Participant\Controller\Images@change')->name('admin.images.change');
    // Put the method with the parameter below the static method
    Route::get('images/{id}/show', 'App\Modules\Participant\Controller\Images@show')->name('admin.images.show');
    Route::get('images/{id}', 'App\Modules\Participant\Controller\Images@edit')->name('admin.images.edit');
    Route::post('images/{id}', 'App\Modules\Participant\Controller\Images@update')->name('admin.images.update');
    Route::get('images/{id}/trash', 'App\Modules\Participant\Controller\Images@trash')->name('admin.images.trash');
    Route::get('images/{id}/restored', 'App\Modules\Participant\Controller\Images@restored')->name('admin.images.restored');
    Route::get('images/{id}/delete', 'App\Modules\Participant\Controller\Images@delete')->name('admin.images.delete');


});
