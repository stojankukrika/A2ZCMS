<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminBlogCommentController@getEdit')
        ->where('comment', '[0-9]+');
    Route::post('comments/{comment}/edit', 'AdminBlogCommentController@postEdit')
        ->where('comment', '[0-9]+');
    Route::get('comments/{comment}/delete', 'AdminBlogCommentController@getDelete')
        ->where('comment', '[0-9]+');
    Route::post('comments/{comment}/delete', 'AdminBlogCommentController@postDelete')
        ->where('comment', '[0-9]+');
    Route::controller('comments', 'AdminBlogCommentController');

    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogController@getShow')
        ->where('post', '[0-9]+');
    Route::get('blogs/{post}/edit', 'AdminBlogController@getEdit')
        ->where('post', '[0-9]+');
    Route::post('blogs/{post}/edit', 'AdminBlogController@postEdit')
        ->where('post', '[0-9]+');
    Route::get('blogs/{post}/delete', 'AdminBlogController@getDelete')
        ->where('post', '[0-9]+');
    Route::post('blogs/{post}/delete', 'AdminBlogController@postDelete')
        ->where('post', '[0-9]+');
    Route::controller('blogs', 'AdminBlogController');

    # User Management
    Route::get('users/{user}/show', 'AdminUserController@getShow')
        ->where('user', '[0-9]+');
    Route::get('users/{user}/edit', 'AdminUserController@getEdit')
        ->where('user', '[0-9]+');
    Route::post('users/{user}/edit', 'AdminUserController@postEdit')
        ->where('user', '[0-9]+');
    Route::get('users/{user}/delete', 'AdminUserController@getDelete')
        ->where('user', '[0-9]+');
    Route::post('users/{user}/delete', 'AdminUserController@postDelete')
        ->where('user', '[0-9]+');
    Route::controller('users', 'AdminUserController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRoleController@getShow')
        ->where('role', '[0-9]+');
    Route::get('roles/{role}/edit', 'AdminRoleController@getEdit')
        ->where('role', '[0-9]+');
    Route::post('roles/{role}/edit', 'AdminRoleController@postEdit')
        ->where('role', '[0-9]+');
    Route::get('roles/{role}/delete', 'AdminRoleController@getDelete')
        ->where('role', '[0-9]+');
    Route::post('roles/{role}/delete', 'AdminRoleController@postDelete')
        ->where('role', '[0-9]+');
    Route::controller('roles', 'AdminRoleController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset')
    ->where('token', '[0-9a-z]+');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset')
    ->where('token', '[0-9a-z]+');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit')
    ->where('user', '[0-9]+');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

Route::get('/', function()
{
	return View::make('hello');
});

# Index Page - Last route, no matches
//Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));

