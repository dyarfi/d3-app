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
    // Blogs Controller routes
    Route::get('blogcategories', ['as'=>'admin.blogcategories.index','uses'=>'App\Modules\Blog\Controller\BlogCategories@index']);
    Route::get('blogcategories/create', ['as'=>'admin.blogcategories.create','uses'=>'App\Modules\Blog\Controller\BlogCategories@create']);
    Route::post('blogcategories/create', ['as'=>'admin.blogcategories.store','uses'=>'App\Modules\Blog\Controller\BlogCategories@store']);
    Route::post('blogcategories/change', ['as'=>'admin.blogcategories.change','uses'=>'App\Modules\Blog\Controller\BlogCategories@change']);
    // Put the method with the parameter below the static method
    Route::get('blogcategories/{id}/show', ['as'=>'admin.blogcategories.show', 'uses'=>'App\Modules\Blog\Controller\BlogCategories@show']);
    Route::get('blogcategories/{id}', ['as'=>'admin.blogcategories.edit','uses'=>'App\Modules\Blog\Controller\BlogCategories@edit']);
    Route::post('blogcategories/{id}', ['as'=>'admin.blogcategories.update','uses'=>'App\Modules\Blog\Controller\BlogCategories@update']);
    Route::get('blogcategories/{id}/trash', ['as'=>'admin.blogcategories.trash','uses'=>'App\Modules\Blog\Controller\BlogCategories@trash']);
    Route::get('blogcategories/{id}/restored', ['as'=>'admin.blogcategories.restored','uses'=>'App\Modules\Blog\Controller\BlogCategories@restored']);
    Route::get('blogcategories/{id}/delete', ['as'=>'admin.blogcategories.delete','uses'=>'App\Modules\Blog\Controller\BlogCategories@delete']);

    // Blogs Controller routes
    Route::get('blog', ['as'=>'admin.blogs.index','uses'=>'App\Modules\Blog\Controller\Blogs@index']);
    Route::get('blog/create', ['as'=>'admin.blogs.create','uses'=>'App\Modules\Blog\Controller\Blogs@create']);
    Route::post('blog/create', ['as'=>'admin.blogs.store','uses'=>'App\Modules\Blog\Controller\Blogs@store']);
    Route::post('blog/change', ['as'=>'admin.blogs.change','uses'=>'App\Modules\Blog\Controller\Blogs@change']);
    // Put the method with the parameter below the static method
    Route::get('blog/{id}/show', ['as'=>'admin.blogs.show', 'uses'=>'App\Modules\Blog\Controller\Blogs@show']);
    Route::get('blog/{id}', ['as'=>'admin.blogs.edit','uses'=>'App\Modules\Blog\Controller\Blogs@edit']);
    Route::post('blog/{id}', ['as'=>'admin.blogs.update','uses'=>'App\Modules\Blog\Controller\Blogs@update']);
    Route::get('blog/{id}/trash', ['as'=>'admin.blogs.trash','uses'=>'App\Modules\Blog\Controller\Blogs@trash']);
    Route::get('blog/{id}/restored', ['as'=>'admin.blogs.restored','uses'=>'App\Modules\Blog\Controller\Blogs@restored']);
    Route::get('blog/{id}/delete', ['as'=>'admin.blogs.delete','uses'=>'App\Modules\Blog\Controller\Blogs@delete']);
    // Put other methods
    Route::get('blog/tags/all', ['as'=>'admin.blogs.tags','uses'=>'App\Modules\Blog\Controller\Blogs@tags']);
    Route::get('blog/tags/{id}/show', ['as'=>'admin.blogs.tags.show','uses'=>'App\Modules\Blog\Controller\Blogs@tagsShow']);

});
