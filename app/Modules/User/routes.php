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
//exit;

Route::prefix(config('setting.admin_url'))->group( function()
{

    // Get no access pages
    Route::get('noaccess', 'App\Modules\BaseAdmin@unauthorize')->name('admin.noaccess');
    Route::get('noaccess', 'App\Modules\BaseAdmin@index')->name('admin.noaccess');

    // ******************* Shortcut for Developer Setup ******************** //

    // Get main administrator lgin
    Route::get('setup/first/migrate', 'App\Modules\BaseAdmin@setup')->name('first.migrate');
    Route::post('setup/first/migrate', 'App\Modules\BaseAdmin@setup')->name('first.migrate.post');

    // ******************* Admin\AuthAdminController ********************* { //

    // Get main administrator login
    Route::get('/', 'App\Modules\Admin\AuthAdminController@index');

    // ByPass to admin auth controller in middleware | Login
    Route::get('login', 'App\Modules\Admin\AuthAdminController@login')->name('admin.login');
    Route::post('login', 'App\Modules\Admin\AuthAdminController@processLogin')->name('admin.login');

    // ByPass to admin auth controller in middleware | Logout
    Route::get('logout', 'App\Modules\Admin\AuthAdminController@logout')->name('admin.logout');

    // ByPass to admin auth controller in middleware | Register
    Route::get('register', 'App\Modules\Admin\AuthAdminController@register')->name('admin.register');
    Route::post('register', 'App\Modules\Admin\AuthAdminController@processRegistration')->name('admin.register');

    // Get users team invitation process
    Route::get('invitation/{id}/{action}', 'App\Modules\Admin\AuthAdminController@invitation')->name('admin.invitation');

    //Route::get('invitation', 'App\Modules\Admin\AuthAdminController@invitation')->name('admin.invitation');

    // } ****************** Admin\AuthAdminController ****************** //

    // Users Controller
    Route::get('account', 'App\Modules\User\Controller\Users@profile')->name('admin.account');
    // Get admin panel controllers routes
    Route::get('profile', 'App\Modules\User\Controller\Users@profile')->name('admin.profile');

    // Get admin panel controllers routes
    Route::get('dashboard', 'App\Modules\User\Controller\Users@dashboard')->name('admin.dashboard');

    Route::get('user', 'App\Modules\User\Controller\Users@index')->name('admin.users.index');
    Route::get('user/export', 'App\Modules\User\Controller\Users@export')->name('admin.users.export');
    Route::get('user/create', 'App\Modules\User\Controller\Users@create')->name('admin.users.create');
    Route::post('user/create', 'App\Modules\User\Controller\Users@store')->name('admin.users.store');
    Route::post('user/change', 'App\Modules\User\Controller\Users@change')->name('admin.users.change');
    Route::get('user/{id}/show', 'App\Modules\User\Controller\Users@show')->name('admin.users.show');
    Route::get('user/{id}', 'App\Modules\User\Controller\Users@edit')->name('admin.users.edit');
    Route::post('user/{id}', 'App\Modules\User\Controller\Users@update')->name('admin.users.update');
    Route::get('user/{id}/trash', 'App\Modules\User\Controller\Users@trash')->name('admin.users.trash');
    Route::get('user/{id}/restored', 'App\Modules\User\Controller\Users@restored')->name('admin.users.restored');
    Route::get('user/{id}/delete', 'App\Modules\User\Controller\Users@delete')->name('admin.users.delete');
    Route::get('user/crop/{id}', 'App\Modules\User\Controller\Users@crop')->name('admin.users.crop');

    // Roles Controller routes
    Route::get('role', 'App\Modules\User\Controller\Roles@index')->name('admin.roles.index');
    Route::get('role/create', 'App\Modules\User\Controller\Roles@create')->name('admin.roles.create');
    Route::post('role/create', 'App\Modules\User\Controller\Roles@store')->name('admin.roles.store');
    Route::get('role/{id}/show', 'App\Modules\User\Controller\Roles@show')->name('admin.roles.show');
    Route::get('role/{id}', 'App\Modules\User\Controller\Roles@edit')->name('admin.roles.edit');
    Route::post('role/{id}', 'App\Modules\User\Controller\Roles@update')->name('admin.roles.update');
    Route::get('role/{id}/trash', 'App\Modules\User\Controller\Roles@trash')->name('admin.roles.trash');
    Route::get('role/{id}/restored', 'App\Modules\User\Controller\Roles@restored')->name('admin.roles.restored');
    Route::get('role/{id}/delete', 'App\Modules\User\Controller\Roles@delete')->name('admin.roles.delete');

    // Teams Controller routes
    Route::get('team', 'App\Modules\User\Controller\Teams@index')->name('admin.teams.index');
    // Send invitation to the team
    Route::get('team/invitation', 'App\Modules\User\Controller\Teams@invitation')->name('admin.teams.invitation');
    Route::post('team/invite', 'App\Modules\User\Controller\Teams@invite')->name('admin.teams.invite');
    Route::get('team/create', 'App\Modules\User\Controller\Teams@create')->name('admin.teams.create');
    Route::post('team/create', 'App\Modules\User\Controller\Teams@store')->name('admin.teams.store');
    Route::get('team/{id}/show', 'App\Modules\User\Controller\Teams@show')->name('admin.teams.show');
    Route::get('team/{id}', 'App\Modules\User\Controller\Teams@edit')->name('admin.teams.edit');
    Route::post('team/{id}', 'App\Modules\User\Controller\Teams@update')->name('admin.teams.update');
    Route::get('team/{id}/trash', 'App\Modules\User\Controller\Teams@trash')->name('admin.teams.trash');
    Route::get('team/{id}/restored', 'App\Modules\User\Controller\Teams@restored')->name('admin.teams.restored');
    Route::get('team/{id}/delete', 'App\Modules\User\Controller\Teams@delete')->name('admin.teams.delete');

     // Permissions Controller routes
    Route::get('permission', 'App\Modules\User\Controller\Permissions@index')->name('admin.permissions.index');
    Route::get('permission/create', 'App\Modules\User\Controller\Permissions@create')->name('admin.permissions.create');
    Route::post('permission/create', 'App\Modules\User\Controller\Permissions@store')->name('admin.permissions.store');
    Route::get('permission/{id}', 'App\Modules\User\Controller\Permissions@edit')->name('admin.permissions.edit');
    Route::post('permission/{id}', 'App\Modules\User\Controller\Permissions@update')->name('admin.permissions.update');
    Route::get('permission/{id}/delete', 'App\Modules\User\Controller\Permissions@delete')->name('admin.permissions.delete');
    // Ajax Controller
    Route::post('permission/{id}/change', 'App\Modules\User\Controller\Permissions@change')->name('admin.permissions.change');

    Route::get('log', 'App\Modules\User\Controller\Logs@index')->name('admin.logs.index');
    Route::get('log/export', 'App\Modules\User\Controller\Logs@export')->name('admin.logs.export');
    Route::get('log/{id}/show', 'App\Modules\User\Controller\Logs@show')->name('admin.logs.show');
    Route::get('log/{id}/trash', 'App\Modules\User\Controller\Logs@trash')->name('admin.logs.trash');
    Route::get('log/{id}/delete', 'App\Modules\User\Controller\Logs@delete')->name('admin.logs.delete');

    // Settings Controller routes
    Route::get('setting', 'App\Modules\User\Controller\Settings@index')->name('admin.settings.index');
    // Ajax Controller
    Route::post('setting/change', 'App\Modules\User\Controller\Settings@change')->name('admin.settings.change');
    Route::get('setting/create', 'App\Modules\User\Controller\Settings@create')->name('admin.settings.create');
    Route::post('setting/create', 'App\Modules\User\Controller\Settings@store')->name('admin.settings.store');
    Route::get('setting/{id}/show', 'App\Modules\User\Controller\Settings@show')->name('admin.settings.show');
    Route::get('setting/{id}', 'App\Modules\User\Controller\Settings@edit')->name('admin.settings.edit');
    Route::post('setting/{id}', 'App\Modules\User\Controller\Settings@update')->name('admin.settings.update');
    Route::get('setting/{id}/trash', 'App\Modules\User\Controller\Settings@trash')->name('admin.settings.trash');
    Route::get('setting/{id}/restored', 'App\Modules\User\Controller\Settings@restored')->name('admin.settings.restored');
    Route::get('setting/{id}/delete', 'App\Modules\User\Controller\Settings@delete')->name('admin.settings.delete');

});
