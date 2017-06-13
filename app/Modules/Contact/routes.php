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
    // Portfolios DataTables routes
    Route::get('contact/datatable', ['as'=>'admin.contacts.datatable','uses'=>'App\Modules\Contact\Controller\Contacts@datatable']);

    // Contacts Controller routes
    Route::get('contact', ['as'=>'admin.contacts.index','uses'=>'App\Modules\Contact\Controller\Contacts@index']);
    Route::get('contact/export', ['as'=>'admin.contacts.export','uses'=>'App\Modules\Contact\Controller\Contacts@export']);
    Route::get('contact/create', ['as'=>'admin.contacts.create','uses'=>'App\Modules\Contact\Controller\Contacts@create']);
    Route::post('contact/create', ['as'=>'admin.contacts.store','uses'=>'App\Modules\Contact\Controller\Contacts@store']);
    Route::post('contact/change', ['as'=>'admin.contacts.change','uses'=>'App\Modules\Contact\Controller\Contacts@change']);
    // Put the method with the parameter below the static method
    Route::get('contact/{id}/show', ['as'=>'admin.contacts.show', 'uses'=>'App\Modules\Contact\Controller\Contacts@show']);
    Route::get('contact/{id}', ['as'=>'admin.contacts.edit','uses'=>'App\Modules\Contact\Controller\Contacts@edit']);
    Route::post('contact/{id}', ['as'=>'admin.contacts.update','uses'=>'App\Modules\Contact\Controller\Contacts@update']);
    Route::get('contact/{id}/trash', ['as'=>'admin.contacts.trash','uses'=>'App\Modules\Contact\Controller\Contacts@trash']);
    Route::get('contact/{id}/restored', ['as'=>'admin.contacts.restored','uses'=>'App\Modules\Contact\Controller\Contacts@restored']);
    Route::get('contact/{id}/delete', ['as'=>'admin.contacts.delete','uses'=>'App\Modules\Contact\Controller\Contacts@delete']);

});
