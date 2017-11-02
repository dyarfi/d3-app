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
    Route::get('client/datatable', ['as'=>'admin.clients.datatable','uses'=>'App\Modules\Portfolio\Controller\Clients@datatable']);
    // Clients Controller routes
    Route::get('client', ['as'=>'admin.clients.index','uses'=>'App\Modules\Portfolio\Controller\Clients@index']);
    Route::get('client/export', ['as'=>'admin.clients.export','uses'=>'App\Modules\Portfolio\Controller\Clients@export']);
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
    
    // Portfolios DataTables routes
    Route::get('portfolio/datatable', 'App\Modules\Portfolio\Controller\Portfolios@datatable')->name('admin.portfolios.datatable');
    // Portfolios Main Controller routes
    Route::get('portfolio', 'App\Modules\Portfolio\Controller\Portfolios@index')->name('admin.portfolios.index');

    Route::get('portfolio/export', 'App\Modules\Portfolio\Controller\Portfolios@export')->name('admin.portfolios.export');
    Route::get('portfolio/create', 'App\Modules\Portfolio\Controller\Portfolios@create')->name('admin.portfolios.create');
    Route::post('portfolio/create', 'App\Modules\Portfolio\Controller\Portfolios@store')->name('admin.portfolios.store');
    Route::post('portfolio/change', 'App\Modules\Portfolio\Controller\Portfolios@change')->name('admin.portfolios.change');

    // Put the method with the parameter below the static method
    Route::get('portfolio/{id}/show', 'App\Modules\Portfolio\Controller\Portfolios@show')->name('admin.portfolios.show');
    Route::get('portfolio/{id}', 'App\Modules\Portfolio\Controller\Portfolios@edit')->name('admin.portfolios.edit');
    Route::post('portfolio/{id}', 'App\Modules\Portfolio\Controller\Portfolios@update')->name('admin.portfolios.update');
    Route::get('portfolio/{id}/trash', 'App\Modules\Portfolio\Controller\Portfolios@trash')->name('admin.portfolios.trash');
    Route::get('portfolio/{id}/restored', 'App\Modules\Portfolio\Controller\Portfolios@restored')->name('admin.portfolios.restored');
    Route::get('portfolio/{id}/delete', 'App\Modules\Portfolio\Controller\Portfolios@delete')->name('admin.portfolios.delete');
    // Put other methods
    Route::get('portfolio/tags/all', 'App\Modules\Portfolio\Controller\Portfolios@tags')->name('admin.portfolios.tags');
    Route::get('portfolio/tags/{id}/show', 'App\Modules\Portfolio\Controller\Portfolios@tagsShow')->name('admin.portfolios.tags.show');
    Route::post('portfolio/media:list/{id}', 'App\Modules\Portfolio\Controller\Portfolios@mediaList')->name('admin.portfolios.medialist');
        
    // Portfolios DataTables routes
    Route::get('project/datatable', 'App\Modules\Portfolio\Controller\Projects@datatable')->name('admin.projects.datatable');
    // Portfolios Main Controller routes
    Route::get('project', 'App\Modules\Portfolio\Controller\Projects@index')->name('admin.projects.index');
    Route::get('project/export', 'App\Modules\Portfolio\Controller\Projects@export')->name('admin.projects.export');
    Route::get('project/create', 'App\Modules\Portfolio\Controller\Projects@create')->name('admin.projects.create');
    Route::post('project/create', 'App\Modules\Portfolio\Controller\Projects@store')->name('admin.projects.store');
    Route::post('project/change', 'App\Modules\Portfolio\Controller\Projects@change')->name('admin.projects.change');
    // Put the method with the parameter below the static method
    Route::get('project/{id}/show', 'App\Modules\Portfolio\Controller\Projects@show')->name('admin.projects.show');
    Route::get('project/{id}', 'App\Modules\Portfolio\Controller\Projects@edit')->name('admin.projects.edit');
    Route::post('project/{id}', 'App\Modules\Portfolio\Controller\Projects@update')->name('admin.projects.update');
    Route::get('project/{id}/trash','App\Modules\Portfolio\Controller\Projects@trash')->name('admin.projects.trash');
    Route::get('project/{id}/restored', 'App\Modules\Portfolio\Controller\Projects@restored')->name('admin.projects.restored');
    Route::get('project/{id}/delete', 'App\Modules\Portfolio\Controller\Projects@delete')->name('admin.projects.delete');


});
