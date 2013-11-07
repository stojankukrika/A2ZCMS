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
Route::model('blogcomment', 'BlogComment');
Route::model('blogcategory', 'BlogCategory');
Route::model('blog', 'Blog');
Route::model('galleryimages', 'GalleryImages');
Route::model('galleryimageslikes', 'GalleryImagesLikes');
Route::model('galleryimagecomment', 'GalleryImageComment');
Route::model('gallery', 'Gallery');
Route::model('todolist', 'Todolist');
Route::model('role', 'Role');
Route::model('settings', 'Settings');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Blog Comment Management
    Route::get('blogcomments/{blog}/commentsforblog', 'AdminBlogCommentsController@getCommentsForBlog')
        ->where('blog', '[0-9]+');
    Route::get('blogcomments/{blogcomment}/edit', 'AdminBlogCommentsController@getEdit')
        ->where('blogcomment', '[0-9]+');
    Route::post('blogcomments/{blogcomment}/edit', 'AdminBlogCommentsController@postEdit')
        ->where('blogcomment', '[0-9]+');
    Route::get('blogcomments/{blogcomment}/delete', 'AdminBlogCommentsController@getDelete')
        ->where('blogcomment', '[0-9]+');
    Route::post('blogcomments/{blogcomment}/delete', 'AdminBlogCommentsController@getDelete')
        ->where('blogcomment', '[0-9]+');
    Route::controller('blogcomments', 'AdminBlogCommentsController');
	
	 # Blog Category Management
    Route::get('blogcategorys/{blogcategory}/edit', 'AdminBlogCategorysController@getEdit')
        ->where('blogcategory', '[0-9]+');
    Route::post('blogcategorys/{blogcategory}/edit', 'AdminBlogCategorysController@postEdit')
        ->where('blogcategory', '[0-9]+');
    Route::get('blogcategorys/{blogcategory}/delete', 'AdminBlogCategorysController@getDelete')
        ->where('blogcategory', '[0-9]+');
    Route::post('blogcategorys/{blogcategory}/delete', 'AdminBlogCategorysController@getDelete')
        ->where('blogcategory', '[0-9]+');
    Route::controller('blogcategorys', 'AdminBlogCategorysController');

    # Blog Management
     Route::get('blogs/{blogcategory}/blogsforcategory', 'AdminBlogsController@getBlogsForCategory')
        ->where('blogcategory', '[0-9]+');
    Route::get('blogs/{blog}/show', 'AdminBlogsController@getShow')
        ->where('blog', '[0-9]+');
    Route::get('blogs/{blog}/edit', 'AdminBlogsController@getEdit')
        ->where('blog', '[0-9]+');
    Route::post('blogs/{blog}/edit', 'AdminBlogsController@postEdit')
        ->where('blog', '[0-9]+');
    Route::get('blogs/{blog}/delete', 'AdminBlogsController@getDelete')
        ->where('blog', '[0-9]+');
    Route::post('blogs/{blog}/delete', 'AdminBlogsController@getDelete')
        ->where('blog', '[0-9]+');
    Route::controller('blogs', 'AdminBlogsController');
	
	  # Gallery Comment Management
    Route::get('galleryimagecomments/{gallery}/commentsforgallery', 'AdminGalleryImageCommentsController@getCommentsforgallery')
        ->where('gallery', '[0-9]+');
    Route::get('galleryimagecomments/{galleryimagecomment}/edit', 'AdminGalleryImageCommentsController@getEdit')
        ->where('galleryimagecomment', '[0-9]+');
    Route::post('galleryimagecomments/{galleryimagecomment}/edit', 'AdminGalleryImageCommentsController@postEdit')
        ->where('galleryimagecomment', '[0-9]+');
    Route::get('galleryimagecomments/{galleryimagecomment}/delete', 'AdminGalleryImageCommentsController@getDelete')
        ->where('galleryimagecomment', '[0-9]+');
    Route::post('galleryimagecomments/{galleryimagecomment}/delete', 'AdminGalleryImageCommentsController@getDelete')
        ->where('galleryimagecomment', '[0-9]+');
    Route::controller('galleryimagecomments', 'AdminGalleryImageCommentsController');
	
	 # Gallery Images Management
    Route::get('galleryimages/{galleryimage}/delete', 'AdminGalleryImagesController@postDelete')
        ->where('galleryimage', '[0-9]+');
    Route::controller('galleryimages', 'AdminGalleryImagesController');
	
    # Galleries Management
    Route::get('galleries/{gallerycategory}/imagesforgallery', 'AdminGalleriesController@getImagesForGallery')
        ->where('gallerycategory', '[0-9]+');
     Route::get('galleries/{gallery}/show', 'AdminGalleriesController@getShow')
        ->where('gallery', '[0-9]+');
    Route::get('galleries/{gallery}/edit', 'AdminGalleriesController@getEdit')
        ->where('gallery', '[0-9]+');
    Route::post('galleries/{gallery}/edit', 'AdminGalleriesController@postEdit')
        ->where('gallery', '[0-9]+');
    Route::get('galleries/{gallery}/delete', 'AdminGalleriesController@getDelete')
        ->where('gallery', '[0-9]+');
    Route::post('galleries/{gallery}/delete', 'AdminGalleriesController@getDelete')
        ->where('gallery', '[0-9]+');
	Route::get('galleries/{gallery}/upload', 'AdminGalleriesController@getUpload')
        ->where('gallery', '[0-9]+');
    Route::post('galleries/{gallery}/upload', 'AdminGalleriesController@postUpload')
        ->where('gallery', '[0-9]+');		
    Route::controller('galleries', 'AdminGalleriesController');
	
		# Navigation Management
	Route::get('pages/{nav}/visible', 'AdminPagesController@getVisible')
        ->where('nav', '[0-9]+');
    Route::get('pages/{nav}/show', 'AdminPagesController@getShow')
        ->where('nav', '[0-9]+');
    Route::get('pages/{nav}/edit', 'AdminPagesController@getEdit')
        ->where('nav', '[0-9]+');
    Route::post('pages/{nav}/edit', 'AdminPagesController@postEdit')
        ->where('nav', '[0-9]+');
    Route::get('pages/{nav}/delete', 'AdminPagesController@getDelete')
        ->where('nav', '[0-9]+');
    Route::post('pages/{nav}/delete', 'AdminPagesController@getDelete')
        ->where('nav', '[0-9]+');
    Route::controller('pages', 'AdminPagesController');
    
    # Navigation Group Management
    Route::get('navigationgroups/{group}/show', 'AdminNavigationGroupsController@getShow')
        ->where('group', '[0-9]+');
    Route::get('navigationgroups/{group}/edit', 'AdminNavigationGroupsController@getEdit')
        ->where('group', '[0-9]+');
    Route::post('navigationgroups/{group}/edit', 'AdminNavigationGroupsController@postEdit')
        ->where('group', '[0-9]+');
    Route::get('navigationgroups/{group}/delete', 'AdminNavigationGroupsController@getDelete')
        ->where('group', '[0-9]+');
    Route::post('navigationgroups/{group}/delete', 'AdminNavigationGroupsController@getDelete')
        ->where('group', '[0-9]+');
    Route::controller('navigationgroups', 'AdminNavigationGroupsController');

    # Navigation Management
    Route::get('navigation/{nav}/show', 'AdminNavigationController@getShow')
        ->where('nav', '[0-9]+');
    Route::get('navigation/{nav}/edit', 'AdminNavigationController@getEdit')
        ->where('nav', '[0-9]+');
    Route::post('navigation/{nav}/edit', 'AdminNavigationController@postEdit')
        ->where('nav', '[0-9]+');
    Route::get('navigation/{nav}/delete', 'AdminNavigationController@getDelete')
        ->where('nav', '[0-9]+');
    Route::post('navigation/{nav}/delete', 'AdminNavigationController@getDelete')
        ->where('nav', '[0-9]+');
    Route::controller('navigation', 'AdminNavigationController');

    # User Management    
    Route::get('users/{role}/usersforrole', 'AdminUsersController@getUsersForRole')
        ->where('role', '[0-9]+');
    Route::get('users/{user}/show', 'AdminUsersController@getShow')
        ->where('user', '[0-9]+');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit')
        ->where('user', '[0-9]+');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit')
        ->where('user', '[0-9]+');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete')
        ->where('user', '[0-9]+');
    Route::post('users/{user}/delete', 'AdminUsersController@getDelete')
        ->where('user', '[0-9]+');
	#Profile
	Route::get('users/profile', 'AdminUsersController@getProfileEdit');
    Route::post('users/profile', 'AdminUsersController@postProfileEdit');
	
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow')
        ->where('role', '[0-9]+');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit')
        ->where('role', '[0-9]+');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit')
        ->where('role', '[0-9]+');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete')
        ->where('role', '[0-9]+');
    Route::post('roles/{role}/delete', 'AdminRolesController@getDelete')
        ->where('role', '[0-9]+');
    Route::controller('roles', 'AdminRolesController');

	# To-do list
	Route::get('todolists/{todo}/change', 'AdminTodolistController@getChange')
        ->where('todo', '[0-9]+');
    Route::get('todolists/{todo}/edit', 'AdminTodolistController@getEdit')
        ->where('todo', '[0-9]+');
    Route::post('todolists/{todo}/edit', 'AdminTodolistController@postEdit')
        ->where('todo', '[0-9]+');
    Route::get('todolists/{todo}/delete', 'AdminTodolistController@getDelete')
        ->where('todo', '[0-9]+');
    Route::post('todolists/{todo}/delete', 'AdminTodolistController@getDelete')
        ->where('todo', '[0-9]+');
    Route::controller('todolists', 'AdminTodolistController');

	# Settings
    Route::get('settings', 'AdminSettingsController@getIndex');
    Route::post('settings', 'AdminSettingsController@postIndex');
	
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

//:: User Account Routes ::
Route::post('login', 'BaseController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

// Install application
Route::controller('install', 'InstallController');

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
Route::get('blog/{postSlug}', 'BlogController@getView');
Route::post('blog/{postSlug}', 'BlogController@postView');

Route::get('page/{postSlug}', 'WebsiteController@getView');
Route::post('page/{postSlug}', 'WebsiteController@postView');

# Offline Static Page
Route::get('offline', function()
{
		$settings = Settings::all();
		$offlinemessage = '';
		foreach ($settings as $v) {
			if ($v -> varname == 'offlinemessage') {
				$offlinemessage = $v -> value;
			}
		}
    // Return offline page
    return View::make('site/offline', compact('offlinemessage'));
});

# Index Page - Last route, no matches
Route::get('/', array('uses' => 'BlogController@getIndex'));

