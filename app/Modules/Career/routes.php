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
    
     // Careers Controller routes
    Route::get('career', 'App\Modules\Career\Controller\Careers@index')->name('admin.careers.index');
    Route::get('career/create', 'App\Modules\Career\Controller\Careers@create')->name('admin.careers.create');
    Route::post('career/create', 'App\Modules\Career\Controller\Careers@store')->name('admin.careers.store');
    Route::post('career/change', 'App\Modules\Career\Controller\Careers@change')->name('admin.careers.change');
    // Put the method with the parameter below the static method     
    Route::get('career/{id}/show', 'App\Modules\Career\Controller\Careers@show')->name('admin.careers.show');
    Route::get('career/{id}', 'App\Modules\Career\Controller\Careers@edit')->name('admin.careers.edit');
    Route::post('career/{id}', 'App\Modules\Career\Controller\Careers@update')->name('admin.careers.update');
    Route::get('career/{id}/trash', 'App\Modules\Career\Controller\Careers@trash')->name('admin.careers.trash');
    Route::get('career/{id}/restored', 'App\Modules\Career\Controller\Careers@restored')->name('admin.careers.restored');
    Route::get('career/{id}/delete', 'App\Modules\Career\Controller\Careers@delete')->name('admin.careers.delete');

    // Careers Division Controller routes
    Route::get('division', 'App\Modules\Career\Controller\Divisions@index')->name('admin.divisions.index');
    Route::get('division/create', 'App\Modules\Career\Controller\Divisions@create')->name('admin.divisions.create');
    Route::post('division/create', 'App\Modules\Career\Controller\Divisions@store')->name('admin.divisions.store');
    Route::post('division/change', 'App\Modules\Career\Controller\Divisions@change')->name('admin.divisions.change');
    // Put the method with the parameter below the static method         
    Route::get('division/{id}/show', 'App\Modules\Career\Controller\Divisions@show')->name('admin.divisions.show');
    Route::get('division/{id}', 'App\Modules\Career\Controller\Divisions@edit')->name('admin.divisions.edit');
    Route::post('division/{id}', 'App\Modules\Career\Controller\Divisions@update')->name('admin.divisions.update');
    Route::get('division/{id}/trash', 'App\Modules\Career\Controller\Divisions@trash')->name('admin.divisions.trash');
    Route::get('division/{id}/restored', 'App\Modules\Career\Controller\Divisions@restored')->name('admin.divisions.restored');
    Route::get('division/{id}/delete', 'App\Modules\Career\Controller\Divisions@delete')->name('admin.divisions.delete');
    
    // Careers Applicants Controller routes
    Route::get('applicant', 'App\Modules\Career\Controller\Applicants@index')->name('admin.applicants.index');
    Route::get('applicant/create', 'App\Modules\Career\Controller\Applicants@create')->name('admin.applicants.create');
    Route::post('applicant/create', 'App\Modules\Career\Controller\Applicants@store')->name('admin.applicants.store');
    Route::post('applicant/change', 'App\Modules\Career\Controller\Applicants@change')->name('admin.applicants.change');
    // Put the method with the parameter below the static method         
    Route::get('applicant/{id}/show', 'App\Modules\Career\Controller\Applicants@show')->name('admin.applicants.show');
    Route::get('applicant/{id}', 'App\Modules\Career\Controller\Applicants@edit')->name('admin.applicants.edit');
    Route::post('applicant/{id}', 'App\Modules\Career\Controller\Applicants@update')->name('admin.applicants.update');
    Route::get('applicant/{id}/trash', 'App\Modules\Career\Controller\Applicants@trash')->name('admin.applicants.trash');
    Route::get('applicant/{id}/restored', 'App\Modules\Career\Controller\Applicants@restored')->name('admin.applicants.restored');
    Route::get('applicant/{id}/delete', 'App\Modules\Career\Controller\Applicants@delete')->name('admin.applicants.delete');
    
});