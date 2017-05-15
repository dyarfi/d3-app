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
    
     // Careers Controller routes
    Route::get('career', ['as'=>'admin.careers.index','uses'=>'App\Modules\Career\Controller\Careers@index']);
    Route::get('career/create', ['as'=>'admin.careers.create','uses'=>'App\Modules\Career\Controller\Careers@create']);
    Route::post('career/create', ['as'=>'admin.careers.store','uses'=>'App\Modules\Career\Controller\Careers@store']);
    Route::post('career/change', ['as'=>'admin.careers.change','uses'=>'App\Modules\Career\Controller\Careers@change']);    
    // Put the method with the parameter below the static method     
    Route::get('career/{id}/show', ['as'=>'admin.careers.show', 'uses'=>'App\Modules\Career\Controller\Careers@show']);
    Route::get('career/{id}', ['as'=>'admin.careers.edit','uses'=>'App\Modules\Career\Controller\Careers@edit']);
    Route::post('career/{id}', ['as'=>'admin.careers.update','uses'=>'App\Modules\Career\Controller\Careers@update']);
    Route::get('career/{id}/trash', ['as'=>'admin.careers.trash','uses'=>'App\Modules\Career\Controller\Careers@trash']);    
    Route::get('career/{id}/restored', ['as'=>'admin.careers.restored','uses'=>'App\Modules\Career\Controller\Careers@restored']);
    Route::get('career/{id}/delete', ['as'=>'admin.careers.delete','uses'=>'App\Modules\Career\Controller\Careers@delete']);

    // Careers Division Controller routes
    Route::get('division', ['as'=>'admin.divisions.index','uses'=>'App\Modules\Career\Controller\Divisions@index']);
    Route::get('division/create', ['as'=>'admin.divisions.create','uses'=>'App\Modules\Career\Controller\Divisions@create']);
    Route::post('division/create', ['as'=>'admin.divisions.store','uses'=>'App\Modules\Career\Controller\Divisions@store']);
    Route::post('division/change', ['as'=>'admin.divisions.change','uses'=>'App\Modules\Career\Controller\Divisions@change']);
    // Put the method with the parameter below the static method         
    Route::get('division/{id}/show', ['as'=>'admin.divisions.show', 'uses'=>'App\Modules\Career\Controller\Divisions@show']);
    Route::get('division/{id}', ['as'=>'admin.divisions.edit','uses'=>'App\Modules\Career\Controller\Divisions@edit']);
    Route::post('division/{id}', ['as'=>'admin.divisions.update','uses'=>'App\Modules\Career\Controller\Divisions@update']);
    Route::get('division/{id}/trash', ['as'=>'admin.divisions.trash','uses'=>'App\Modules\Career\Controller\Divisions@trash']);    
    Route::get('division/{id}/restored', ['as'=>'admin.divisions.restored','uses'=>'App\Modules\Career\Controller\Divisions@restored']);
    Route::get('division/{id}/delete', ['as'=>'admin.divisions.delete','uses'=>'App\Modules\Career\Controller\Divisions@delete']);
    
    // Careers Applicants Controller routes
    Route::get('applicant', ['as'=>'admin.applicants.index','uses'=>'App\Modules\Career\Controller\Applicants@index']);
    Route::get('applicant/create', ['as'=>'admin.applicants.create','uses'=>'App\Modules\Career\Controller\Applicants@create']);
    Route::post('applicant/create', ['as'=>'admin.applicants.store','uses'=>'App\Modules\Career\Controller\Applicants@store']);
    Route::post('applicant/change', ['as'=>'admin.applicants.change','uses'=>'App\Modules\Career\Controller\Applicants@change']);
    // Put the method with the parameter below the static method         
    Route::get('applicant/{id}/show', ['as'=>'admin.applicants.show', 'uses'=>'App\Modules\Career\Controller\Applicants@show']);
    Route::get('applicant/{id}', ['as'=>'admin.applicants.edit','uses'=>'App\Modules\Career\Controller\Applicants@edit']);
    Route::post('applicant/{id}', ['as'=>'admin.applicants.update','uses'=>'App\Modules\Career\Controller\Applicants@update']);
    Route::get('applicant/{id}/trash', ['as'=>'admin.applicants.trash','uses'=>'App\Modules\Career\Controller\Applicants@trash']);    
    Route::get('applicant/{id}/restored', ['as'=>'admin.applicants.restored','uses'=>'App\Modules\Career\Controller\Applicants@restored']);
    Route::get('applicant/{id}/delete', ['as'=>'admin.applicants.delete','uses'=>'App\Modules\Career\Controller\Applicants@delete']);
    
});