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
    // Clients Controller routes
    Route::get('client', ['as'=>'admin.clients.index','uses'=>'App\Modules\Portfolio\Controller\Clients@index']);
    Route::get('client/create', ['as'=>'admin.clients.create','uses'=>'App\Modules\Portfolio\Controller\Clients@create']);
    Route::post('client/create', ['as'=>'admin.clients.store','uses'=>'App\Modules\Portfolio\Controller\Clients@store']);
    Route::post('client/change', ['as'=>'admin.clients.change','uses'=>'App\Modules\Portfolio\Controller\Clients@change']);
    // Put the method with the parameter below the static method
    Route::get('client/{id}/show', ['as'=>'admin.clients.show', 'uses'=>'App\Modules\Portfolio\Controller\Clients@show']);
    Route::get('client/{id}', ['as'=>'admin.clients.edit','uses'=>'App\Modules\Portfolio\Controller\Clients@edit']);
    Route::post('client/{id}', ['as'=>'admin.clients.update','uses'=>'App\Modules\Portfolio\Controller\Clients@update']);
    Route::get('client/{id}/trash', ['as'=>'admin.clients.trash','uses'=>'App\Modules\Portfolio\Controller\Clients@trash']);
    Route::get('client/{id}/restored', ['as'=>'admin.clients.restored','uses'=>'App\Modules\Portfolio\Controller\Clients@restored']);
    Route::get('client/{id}/delete', ['as'=>'admin.clients.delete','uses'=>'App\Modules\Portfolio\Controller\Clients@delete']);

    // Portfolios Controller routes
    Route::get('portfolio', ['as'=>'admin.portfolios.index','uses'=>'App\Modules\Portfolio\Controller\Portfolios@index']);
    Route::get('portfolio/create', ['as'=>'admin.portfolios.create','uses'=>'App\Modules\Portfolio\Controller\Portfolios@create']);
    Route::post('portfolio/create', ['as'=>'admin.portfolios.store','uses'=>'App\Modules\Portfolio\Controller\Portfolios@store']);
    Route::post('portfolio/change', ['as'=>'admin.portfolios.change','uses'=>'App\Modules\Portfolio\Controller\Portfolios@change']);
    // Put the method with the parameter below the static method
    Route::get('portfolio/{id}/show', ['as'=>'admin.portfolios.show', 'uses'=>'App\Modules\Portfolio\Controller\Portfolios@show']);
    Route::get('portfolio/{id}', ['as'=>'admin.portfolios.edit','uses'=>'App\Modules\Portfolio\Controller\Portfolios@edit']);
    Route::post('portfolio/{id}', ['as'=>'admin.portfolios.update','uses'=>'App\Modules\Portfolio\Controller\Portfolios@update']);
    Route::get('portfolio/{id}/trash', ['as'=>'admin.portfolios.trash','uses'=>'App\Modules\Portfolio\Controller\Portfolios@trash']);
    Route::get('portfolio/{id}/restored', ['as'=>'admin.portfolios.restored','uses'=>'App\Modules\Portfolio\Controller\Portfolios@restored']);
    Route::get('portfolio/{id}/delete', ['as'=>'admin.portfolios.delete','uses'=>'App\Modules\Portfolio\Controller\Portfolios@delete']);
    // Put other methods
    Route::get('portfolio/tags/all', ['as'=>'admin.portfolios.tags','uses'=>'App\Modules\Portfolio\Controller\Portfolios@tags']);
    Route::get('portfolio/tags/{id}/show', ['as'=>'admin.portfolios.tags.show','uses'=>'App\Modules\Portfolio\Controller\Portfolios@tagsShow']);


    // Projects Controller routes
    Route::get('project', ['as'=>'admin.projects.index','uses'=>'App\Modules\Portfolio\Controller\Projects@index']);
    Route::get('project/create', ['as'=>'admin.projects.create','uses'=>'App\Modules\Portfolio\Controller\Projects@create']);
    Route::post('project/create', ['as'=>'admin.projects.store','uses'=>'App\Modules\Portfolio\Controller\Projects@store']);
    Route::post('project/change', ['as'=>'admin.projects.change','uses'=>'App\Modules\Portfolio\Controller\Projects@change']);
    // Put the method with the parameter below the static method
    Route::get('project/{id}/show', ['as'=>'admin.projects.show', 'uses'=>'App\Modules\Portfolio\Controller\Projects@show']);
    Route::get('project/{id}', ['as'=>'admin.projects.edit','uses'=>'App\Modules\Portfolio\Controller\Projects@edit']);
    Route::post('project/{id}', ['as'=>'admin.projects.update','uses'=>'App\Modules\Portfolio\Controller\Projects@update']);
    Route::get('project/{id}/trash', ['as'=>'admin.projects.trash','uses'=>'App\Modules\Portfolio\Controller\Projects@trash']);
    Route::get('project/{id}/restored', ['as'=>'admin.projects.restored','uses'=>'App\Modules\Portfolio\Controller\Projects@restored']);
    Route::get('project/{id}/delete', ['as'=>'admin.projects.delete','uses'=>'App\Modules\Portfolio\Controller\Projects@delete']);


});
