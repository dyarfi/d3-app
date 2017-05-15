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
    
    // Participants Controller routes
    Route::get('participant', ['as'=>'admin.participants.index','uses'=>'App\Modules\Participant\Controller\Participants@index']);
    Route::get('participant/create', ['as'=>'admin.participants.create','uses'=>'App\Modules\Participant\Controller\Participants@create']);
    Route::post('participant/create', ['as'=>'admin.participants.store','uses'=>'App\Modules\Participant\Controller\Participants@store']);
    Route::post('participant/change', ['as'=>'admin.participants.change','uses'=>'App\Modules\Participant\Controller\Participants@change']);    
    // Put the method with the parameter below the static method    
    Route::get('participant/{id}/show', ['as'=>'admin.participants.show', 'uses'=>'App\Modules\Participant\Controller\Participants@show']);
    Route::get('participant/{id}', ['as'=>'admin.participants.edit','uses'=>'App\Modules\Participant\Controller\Participants@edit']);
    Route::post('participant/{id}', ['as'=>'admin.participants.update','uses'=>'App\Modules\Participant\Controller\Participants@update']);
    Route::get('participant/{id}/trash', ['as'=>'admin.participants.trash','uses'=>'App\Modules\Participant\Controller\Participants@trash']);    
    Route::get('participant/{id}/restored', ['as'=>'admin.participants.restored','uses'=>'App\Modules\Participant\Controller\Participants@restored']);
    Route::get('participant/{id}/delete', ['as'=>'admin.participants.delete','uses'=>'App\Modules\Participant\Controller\Participants@delete']);

    // Participant Images Controller routes
    Route::get('images', ['as'=>'admin.images.index','uses'=>'App\Modules\Participant\Controller\Images@index']);
    Route::get('images/create', ['as'=>'admin.images.create','uses'=>'App\Modules\Participant\Controller\Images@create']);
    Route::post('images/create', ['as'=>'admin.images.store','uses'=>'App\Modules\Participant\Controller\Images@store']);
    Route::post('images/change', ['as'=>'admin.images.change','uses'=>'App\Modules\Participant\Controller\Images@change']);    
    // Put the method with the parameter below the static method    
    Route::get('images/{id}/show', ['as'=>'admin.images.show', 'uses'=>'App\Modules\Participant\Controller\Images@show']);
    Route::get('images/{id}', ['as'=>'admin.images.edit','uses'=>'App\Modules\Participant\Controller\Images@edit']);
    Route::post('images/{id}', ['as'=>'admin.images.update','uses'=>'App\Modules\Participant\Controller\Images@update']);
    Route::get('images/{id}/trash', ['as'=>'admin.images.trash','uses'=>'App\Modules\Participant\Controller\Images@trash']);    
    Route::get('images/{id}/restored', ['as'=>'admin.images.restored','uses'=>'App\Modules\Participant\Controller\Images@restored']);
    Route::get('images/{id}/delete', ['as'=>'admin.images.delete','uses'=>'App\Modules\Participant\Controller\Images@delete']);


});