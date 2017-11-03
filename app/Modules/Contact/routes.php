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
    Route::get('contact/datatable', 'App\Modules\Contact\Controller\Contacts@datatable')->name('admin.contacts.datatable');

    // Contacts Controller routes
    Route::get('contact', 'App\Modules\Contact\Controller\Contacts@index')->name('admin.contacts.index');
    Route::get('contact/export', 'App\Modules\Contact\Controller\Contacts@export')->name('admin.contacts.export');
    Route::get('contact/create', 'App\Modules\Contact\Controller\Contacts@create')->name('admin.contacts.create');
    Route::post('contact/create', 'App\Modules\Contact\Controller\Contacts@store')->name('admin.contacts.store');
    Route::post('contact/change', 'App\Modules\Contact\Controller\Contacts@change')->name('admin.contacts.change');
    // Put the method with the parameter below the static method
    Route::get('contact/{id}/show', 'App\Modules\Contact\Controller\Contacts@show')->name('admin.contacts.show');
    Route::get('contact/{id}', 'App\Modules\Contact\Controller\Contacts@edit')->name('admin.contacts.edit');
    Route::post('contact/{id}', 'App\Modules\Contact\Controller\Contacts@update')->name('admin.contacts.update');
    Route::get('contact/{id}/trash', 'App\Modules\Contact\Controller\Contacts@trash')->name('admin.contacts.trash');
    Route::get('contact/{id}/restored', 'App\Modules\Contact\Controller\Contacts@restored')->name('admin.contacts.restored');
    Route::get('contact/{id}/delete', 'App\Modules\Contact\Controller\Contacts@delete')->name('admin.contacts.delete');

});
