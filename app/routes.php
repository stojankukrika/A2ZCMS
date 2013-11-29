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
Route::pattern('blog', '[0-9]+');
Route::pattern('blogcomment', '[0-9]+');
Route::pattern('blogcategory', '[0-9]+');
Route::pattern('gallery', '[0-9]+');
Route::pattern('galleryimagecomment', '[0-9]+');
Route::pattern('galleryimage', '[0-9]+');
Route::pattern('nav', '[0-9]+');
Route::pattern('group', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('todo', '[0-9]+');
Route::pattern('cform', '[0-9]+');
Route::pattern('messageid', '[0-9]+');
Route::pattern('token', '[0-9a-z-]+');

Route::pattern('postSlug', '[0-9a-z-]+');
Route::pattern('postSlug1', '[0-9]+');
Route::pattern('postSlug2', '[0-9]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth|detectLang'), function()
{

    # Blog Comment Management
    Route::get('blogcomments/{blog}/commentsforblog', 'AdminBlogCommentController@getCommentsForBlog');
    Route::get('blogcomments/{blogcomment}/edit', 'AdminBlogCommentController@getEdit');
    Route::post('blogcomments/{blogcomment}/edit', 'AdminBlogCommentController@postEdit');
    Route::get('blogcomments/{blogcomment}/delete', 'AdminBlogCommentController@getDelete');
    Route::post('blogcomments/{blogcomment}/delete', 'AdminBlogCommentController@getDelete');
    Route::controller('blogcomments', 'AdminBlogCommentController');
	
	 # Blog Category Management
    Route::get('blogcategorys/{blogcategory}/edit', 'AdminBlogCategoryController@getEdit');
    Route::post('blogcategorys/{blogcategory}/edit', 'AdminBlogCategoryController@postEdit');
    Route::get('blogcategorys/{blogcategory}/delete', 'AdminBlogCategoryController@getDelete');
    Route::post('blogcategorys/{blogcategory}/delete', 'AdminBlogCategoryController@getDelete');
    Route::controller('blogcategorys', 'AdminBlogCategoryController');

    # Blog Management
    Route::get('blogs/{blog}/edit', 'AdminBlogController@getEdit');
    Route::post('blogs/{blog}/edit', 'AdminBlogController@postEdit');
    Route::get('blogs/{blog}/delete', 'AdminBlogController@getDelete');
    Route::post('blogs/{blog}/delete', 'AdminBlogController@getDelete');
    Route::controller('blogs', 'AdminBlogController');
	
	 # Gallery Comment Management
    Route::get('galleryimagecomments/{gallery}/commentsforgallery', 'AdminGalleryImageCommentController@getCommentsforgallery');
    Route::get('galleryimagecomments/{galleryimagecomment}/edit', 'AdminGalleryImageCommentController@getEdit');
    Route::post('galleryimagecomments/{galleryimagecomment}/edit', 'AdminGalleryImageCommentController@postEdit');
    Route::get('galleryimagecomments/{galleryimagecomment}/delete', 'AdminGalleryImageCommentController@getDelete');
    Route::post('galleryimagecomments/{galleryimagecomment}/delete', 'AdminGalleryImageCommentController@getDelete');
    Route::controller('galleryimagecomments', 'AdminGalleryImageCommentController');
	
	 # Gallery Images Management
    Route::get('galleryimages/{galleryimage}/delete', 'AdminGalleryImageController@postDelete');
    Route::controller('galleryimages', 'AdminGalleryImageController');
	
    # Galleries Management
    Route::get('galleries/{gallerycategory}/imagesforgallery', 'AdminGalleryController@getImagesForGallery');
    Route::get('galleries/{gallery}/edit', 'AdminGalleryController@getEdit');
    Route::post('galleries/{gallery}/edit', 'AdminGalleryController@postEdit');
    Route::get('galleries/{gallery}/delete', 'AdminGalleryController@getDelete');
    Route::post('galleries/{gallery}/delete', 'AdminGalleryController@getDelete');
	Route::get('galleries/{gallery}/upload', 'AdminGalleryController@getUpload');
    Route::post('galleries/{gallery}/upload', 'AdminGalleryController@postUpload');		
    Route::controller('galleries', 'AdminGalleryController');
	
	# Navigation Management
	Route::get('pages/{nav}/visible', 'AdminPageController@getVisible');
    Route::get('pages/{nav}/edit', 'AdminPageController@getEdit');
    Route::post('pages/{nav}/edit', 'AdminPageController@postEdit');
    Route::get('pages/{nav}/delete', 'AdminPageController@getDelete');
    Route::post('pages/{nav}/delete', 'AdminPageController@getDelete');
    Route::controller('pages', 'AdminPageController');
    
    # Navigation Group Management
    Route::get('navigationgroups/{group}/edit', 'AdminNavigationGroupController@getEdit');
    Route::post('navigationgroups/{group}/edit', 'AdminNavigationGroupController@postEdit');
    Route::get('navigationgroups/{group}/delete', 'AdminNavigationGroupController@getDelete');
    Route::post('navigationgroups/{group}/delete', 'AdminNavigationGroupController@getDelete');
    Route::controller('navigationgroups', 'AdminNavigationGroupController');

    # Navigation Management
    Route::get('navigation/{nav}/edit', 'AdminNavigationController@getEdit');
    Route::post('navigation/{nav}/edit', 'AdminNavigationController@postEdit');
    Route::get('navigation/{nav}/delete', 'AdminNavigationController@getDelete');
    Route::post('navigation/{nav}/delete', 'AdminNavigationController@getDelete');
    Route::controller('navigation', 'AdminNavigationController');

    # User Management    
    Route::get('users/{role}/usersforrole', 'AdminUserController@getUsersForRole');
    Route::get('users/{user}/edit', 'AdminUserController@getEdit');
    Route::post('users/{user}/edit', 'AdminUserController@postEdit');
    Route::get('users/{user}/delete', 'AdminUserController@getDelete');
    Route::post('users/{user}/delete', 'AdminUserController@getDelete');
	#Profile
	Route::get('users/profile', 'AdminUserController@getProfileEdit');
    Route::post('users/profile', 'AdminUserController@postProfileEdit');	
    Route::controller('users', 'AdminUserController');

    # User Role Management
    Route::get('roles/{role}/edit', 'AdminRoleController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRoleController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRoleController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRoleController@getDelete');
    Route::controller('roles', 'AdminRoleController');

	# To-do list
	Route::get('todolists/{todo}/change', 'AdminTodolistController@getChange');
    Route::get('todolists/{todo}/edit', 'AdminTodolistController@getEdit');
    Route::post('todolists/{todo}/edit', 'AdminTodolistController@postEdit');
    Route::get('todolists/{todo}/delete', 'AdminTodolistController@getDelete');
    Route::post('todolists/{todo}/delete', 'AdminTodolistController@getDelete');
    Route::controller('todolists', 'AdminTodolistController');

 	# Custom form Management   
    Route::get('customform/{cform}/edit', 'AdminCustomFormController@getEdit');
    Route::post('customform/{cform}/edit', 'AdminCustomFormController@postEdit');
    Route::get('customform/{cform}/delete', 'AdminCustomFormController@getDelete');
    Route::post('customform/{cform}/delete', 'AdminCustomFormController@getDelete');
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
	Route::post('user/{user}/edit', 'UserController@postEdit');
	//User messages
	Route::get('user/messages', 'UserMessagesController@getIndex');
	Route::get('user/messages/{messageid}/read', 'UserMessagesController@getRead');
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
Route::get('blog/{postSlug}', 'BlogController@getView');
Route::post('blog/{postSlug}', 'BlogController@postView');

Route::get('gallery/{postSlug1}', 'GalleryController@getView');
Route::get('galleryimage/{postSlug1}/{postSlug2}', 'GalleryController@getGalleryImage');
Route::post('galleryimage/{postSlug1}/{postSlug2}', 'GalleryController@postGalleryImage');

Route::get('page/{postSlug1}', 'WebsiteController@getView');
Route::post('page/{postSlug1}', 'WebsiteController@postView');
Route::get('contentvote', 'WebsiteController@contentvote');

Route::get('customform/{postSlug1}', 'CustomFormController@postView');
Route::post('customform/{postSlug1}', 'CustomFormController@postView');

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

