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
    // Tasks Controller routes
    Route::get('task', ['as'=>'admin.tasks.index','uses'=>'App\Modules\Task\Controller\Tasks@index']);
    Route::get('task/create', ['as'=>'admin.tasks.create','uses'=>'App\Modules\Task\Controller\Tasks@create']);
    Route::post('task/create', ['as'=>'admin.tasks.store','uses'=>'App\Modules\Task\Controller\Tasks@store']);
    Route::post('task/change', ['as'=>'admin.tasks.change','uses'=>'App\Modules\Task\Controller\Tasks@change']);    
    // Put the method with the parameter below the static method         
    Route::get('task/{id}/show', ['as'=>'admin.tasks.show', 'uses'=>'App\Modules\Task\Controller\Tasks@show']);
    Route::get('task/{id}', ['as'=>'admin.tasks.edit','uses'=>'App\Modules\Task\Controller\Tasks@edit']);
    Route::post('task/{id}', ['as'=>'admin.tasks.update','uses'=>'App\Modules\Task\Controller\Tasks@update']);
    Route::get('task/{id}/trash', ['as'=>'admin.tasks.trash','uses'=>'App\Modules\Task\Controller\Tasks@trash']);    
    Route::get('task/{id}/restored', ['as'=>'admin.tasks.restored','uses'=>'App\Modules\Task\Controller\Tasks@restored']);
    Route::get('task/{id}/delete', ['as'=>'admin.tasks.delete','uses'=>'App\Modules\Task\Controller\Tasks@delete']);

});