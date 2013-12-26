<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
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
Route::model('page', 'Page');
Route::model('todolist', 'Todolist');
Route::model('grid', 'Grid');
Route::model('plugin', 'Plugin');
Route::model('role', 'Role');
Route::model('settings', 'Settings');
Route::model('customform', 'CustomForm');
Route::model('customformfields', 'CustomFormField');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('id', '[0-9]+');
Route::pattern('id2', '[0-9]+');
Route::pattern('id3', '[0-9]+');
Route::pattern('token', '[0-9a-z-]+');


/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth|detectLang'), function()
{

    # Blog Comment Management
    Route::get('blogcomments/{id}/commentsforblog', 'AdminBlogCommentController@getCommentsForBlog');
    Route::get('blogcomments/{id}/edit', 'AdminBlogCommentController@getEdit');
    Route::post('blogcomments/{id}/edit', 'AdminBlogCommentController@postEdit');
    Route::get('blogcomments/{id}/delete', 'AdminBlogCommentController@getDelete');
    Route::post('blogcomments/{id}/delete', 'AdminBlogCommentController@getDelete');
    Route::controller('blogcomments', 'AdminBlogCommentController');
	
	 # Blog Category Management
    Route::get('blogcategorys/{id}/edit', 'AdminBlogCategoryController@getEdit');
    Route::post('blogcategorys/{id}/edit', 'AdminBlogCategoryController@postEdit');
    Route::get('blogcategorys/{id}/delete', 'AdminBlogCategoryController@getDelete');
    Route::post('blogcategorys/{id}/delete', 'AdminBlogCategoryController@getDelete');
    Route::controller('blogcategorys', 'AdminBlogCategoryController');

    # Blog Management
    Route::get('blogs/{id}/edit', 'AdminBlogController@getEdit');
    Route::post('blogs/{id}/edit', 'AdminBlogController@postEdit');
    Route::get('blogs/{id}/delete', 'AdminBlogController@getDelete');
    Route::post('blogs/{id}/delete', 'AdminBlogController@getDelete');
    Route::controller('blogs', 'AdminBlogController');
	
	 # Gallery Comment Management
    Route::get('galleryimagecomments/{id}/commentsforgallery', 'AdminGalleryImageCommentController@getCommentsforgallery');
    Route::get('galleryimagecomments/{id}/edit', 'AdminGalleryImageCommentController@getEdit');
    Route::post('galleryimagecomments/{id}/edit', 'AdminGalleryImageCommentController@postEdit');
    Route::get('galleryimagecomments/{id}/delete', 'AdminGalleryImageCommentController@getDelete');
    Route::post('galleryimagecomments/{id}/delete', 'AdminGalleryImageCommentController@getDelete');
    Route::controller('galleryimagecomments', 'AdminGalleryImageCommentController');
	
	 # Gallery Images Management
    Route::get('galleryimages/{id}/delete', 'AdminGalleryImageController@postDelete');
    Route::controller('galleryimages', 'AdminGalleryImageController');
	
    # Galleries Management
    Route::get('galleries/{id}/imagesforgallery', 'AdminGalleryController@getImagesForGallery');
    Route::get('galleries/{id}/edit', 'AdminGalleryController@getEdit');
    Route::post('galleries/{id}/edit', 'AdminGalleryController@postEdit');
    Route::get('galleries/{id}/delete', 'AdminGalleryController@getDelete');
    Route::post('galleries/{id}/delete', 'AdminGalleryController@getDelete');
	Route::get('galleries/{id}/upload', 'AdminGalleryController@getUpload');
    Route::post('galleries/{id}/upload', 'AdminGalleryController@postUpload');		
    Route::controller('galleries', 'AdminGalleryController');
	
	# Navigation Management
	Route::get('pages/{id}/visible', 'AdminPageController@getVisible');
    Route::get('pages/{id}/edit', 'AdminPageController@getEdit');
    Route::post('pages/{id}/edit', 'AdminPageController@postEdit');
    Route::get('pages/{id}/delete', 'AdminPageController@getDelete');
    Route::post('pages/{id}/delete', 'AdminPageController@getDelete');
    Route::controller('pages', 'AdminPageController');
    
    # Navigation Group Management
    Route::get('navigationgroups/{id}/edit', 'AdminNavigationGroupController@getEdit');
    Route::post('navigationgroups/{id}/edit', 'AdminNavigationGroupController@postEdit');
    Route::get('navigationgroups/{id}/delete', 'AdminNavigationGroupController@getDelete');
    Route::post('navigationgroups/{id}/delete', 'AdminNavigationGroupController@getDelete');
    Route::controller('navigationgroups', 'AdminNavigationGroupController');

    # Navigation Management
    Route::get('navigation/{id}/edit', 'AdminNavigationController@getEdit');
    Route::post('navigation/{id}/edit', 'AdminNavigationController@postEdit');
    Route::get('navigation/{id}/delete', 'AdminNavigationController@getDelete');
    Route::post('navigation/{id}/delete', 'AdminNavigationController@getDelete');
    Route::controller('navigation', 'AdminNavigationController');

    # User Management    
    Route::get('users/{id}/usersforrole', 'AdminUserController@getUsersForRole');
	Route::get('users/{id}/usershistory', 'AdminUserController@getHistory');
    Route::get('users/{id}/edit', 'AdminUserController@getEdit');
    Route::post('users/{id}/edit', 'AdminUserController@postEdit');
    Route::get('users/{id}/delete', 'AdminUserController@getDelete');
    Route::post('users/{id}/delete', 'AdminUserController@getDelete');
	#Profile
	Route::get('users/profile', 'AdminUserController@getProfileEdit');
    Route::post('users/profile', 'AdminUserController@postProfileEdit');	
    Route::controller('users', 'AdminUserController');

    # User Role Management
    Route::get('roles/{id}/edit', 'AdminRoleController@getEdit');
    Route::post('roles/{id}/edit', 'AdminRoleController@postEdit');
    Route::get('roles/{id}/delete', 'AdminRoleController@getDelete');
    Route::post('roles/{id}/delete', 'AdminRoleController@getDelete');
    Route::controller('roles', 'AdminRoleController');

	# To-do list
	Route::get('todolists/{id}/change', 'AdminTodolistController@getChange');
    Route::get('todolists/{id}/edit', 'AdminTodolistController@getEdit');
    Route::post('todolists/{id}/edit', 'AdminTodolistController@postEdit');
    Route::get('todolists/{id}/delete', 'AdminTodolistController@getDelete');
    Route::post('todolists/{id}/delete', 'AdminTodolistController@getDelete');
    Route::controller('todolists', 'AdminTodolistController');

 	# Custom form Management   
    Route::get('customform/{id}/edit', 'AdminCustomFormController@getEdit');
    Route::post('customform/{id}/edit', 'AdminCustomFormController@postEdit');
    Route::get('customform/{id}/delete', 'AdminCustomFormController@getDelete');
    Route::post('customform/{id}/delete', 'AdminCustomFormController@getDelete');
	Route::get('customform/{id}/deleteitem', 'AdminCustomFormController@postDeleteItem');
    Route::post('customform/{id}/deleteitem', 'AdminCustomFormController@postDeleteItem');
    Route::controller('customform', 'AdminCustomFormController');

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

 Route::group(array('before' => 'auth'), function()
{
    //:: User Account Routes ::
	Route::post('user/{id}/edit', 'UserController@postEdit');
	//User messages
	Route::get('user/messages', 'UserMessagesController@getIndex');
	Route::get('user/messages/{id}/read', 'UserMessagesController@getRead');
	Route::post('user/messages/sendmessage', 'UserMessagesController@postSendmessage');
	
});

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

//:: User Account Routes ::
Route::post('login', 'BaseController@postLogin');

//:: User Account Routes ::
Route::get('user/forgot', 'UserController@getForgot');
Route::post('user/forgot', 'UserController@postForgot');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

// Install application
Route::controller('install', 'InstallController');

//:: Application Routes ::

# Posts - Second to last set, match slug
Route::get('blog/{id}', 'BlogController@getView');
Route::post('blog/{id}', 'BlogController@postView');

Route::get('gallery/{id}', 'GalleryController@getView');
Route::get('galleryimage/{id}/{id2}', 'GalleryController@getGalleryImage');
Route::post('galleryimage/{id}/{id2}', 'GalleryController@postGalleryImage');

Route::get('page/{id}', 'WebsiteController@getView');
Route::post('page/{id}', 'WebsiteController@postView');
Route::get('contentvote', 'WebsiteController@contentvote');

Route::get('customform/{id}', 'CustomFormController@postView');
Route::post('customform/{id}', 'CustomFormController@postView');

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
Route::get('/', 'WebsiteController@getView');

