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
    // Blogs DataTables routes
    Route::get('blogcategories/datatable', 'App\Modules\Blog\Controller\BlogCategories@datatable')->name('admin.blogcategories.datatable');
    // Blogs Controller routes
    Route::get('blogcategories', 'App\Modules\Blog\Controller\BlogCategories@index')->name('admin.blogcategories.index');
    Route::get('blogcategories/export', 'App\Modules\Blog\Controller\BlogCategories@export')->name('admin.blogcategories.export');
    Route::get('blogcategories/create', 'App\Modules\Blog\Controller\BlogCategories@create')->name('admin.blogcategories.create');
    Route::post('blogcategories/create', 'App\Modules\Blog\Controller\BlogCategories@store')->name('admin.blogcategories.store');
    Route::post('blogcategories/change', 'App\Modules\Blog\Controller\BlogCategories@change')->name('admin.blogcategories.change');
    // Put the method with the parameter below the static method
    Route::get('blogcategories/{id}/show', 'App\Modules\Blog\Controller\BlogCategories@show')->name('admin.blogcategories.show');
    Route::get('blogcategories/{id}', 'App\Modules\Blog\Controller\BlogCategories@edit')->name('admin.blogcategories.edit');
    Route::post('blogcategories/{id}', 'App\Modules\Blog\Controller\BlogCategories@update')->name('admin.blogcategories.update');
    Route::get('blogcategories/{id}/trash', 'App\Modules\Blog\Controller\BlogCategories@trash')->name('admin.blogcategories.trash');
    Route::get('blogcategories/{id}/restored', 'App\Modules\Blog\Controller\BlogCategories@restored')->name('admin.blogcategories.restored');
    Route::get('blogcategories/{id}/delete', 'App\Modules\Blog\Controller\BlogCategories@delete')->name('admin.blogcategories.delete');
    // Blogs DataTables routes
    Route::get('blog/datatable', 'App\Modules\Blog\Controller\Blogs@datatable')->name('admin.blogs.datatable');
    // Blogs Controller routes
    Route::get('blog', 'App\Modules\Blog\Controller\Blogs@index')->name('admin.blogs.index');
    Route::get('blog/export', 'App\Modules\Blog\Controller\Blogs@export')->name('admin.blogs.export');
    Route::get('blog/create', 'App\Modules\Blog\Controller\Blogs@create')->name('admin.blogs.create');
    Route::post('blog/create', 'App\Modules\Blog\Controller\Blogs@store')->name('admin.blogs.store');
    Route::post('blog/change', 'App\Modules\Blog\Controller\Blogs@change')->name('admin.blogs.change');
    // Put the method with the parameter below the static method
    Route::get('blog/{id}/show', 'App\Modules\Blog\Controller\Blogs@show')->name('admin.blogs.show');
    Route::get('blog/{id}', 'App\Modules\Blog\Controller\Blogs@edit')->name('admin.blogs.edit');
    Route::post('blog/{id}', 'App\Modules\Blog\Controller\Blogs@update')->name('admin.blogs.update');
    Route::get('blog/{id}/trash', 'App\Modules\Blog\Controller\Blogs@trash')->name('admin.blogs.trash');
    Route::get('blog/{id}/restored', 'App\Modules\Blog\Controller\Blogs@restored')->name('admin.blogs.restored');
    Route::get('blog/{id}/delete', 'App\Modules\Blog\Controller\Blogs@delete')->name('admin.blogs.delete');
    // Put other methods
    Route::get('blog/tags/all', 'App\Modules\Blog\Controller\Blogs@tags')->name('admin.blogs.tags');
    Route::get('blog/tags/{id}/show', 'App\Modules\Blog\Controller\Blogs@tagsShow')->name('admin.blogs.tags.show');

});
