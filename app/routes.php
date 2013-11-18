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
Route::model('page', 'Page');
Route::model('todolist', 'Todolist');
Route::model('grid', 'Grid');
Route::model('plugin', 'Plugin');
Route::model('role', 'Role');
Route::model('settings', 'Settings');
Route::model('customform', 'CustomForm');
Route::model('customformfields', 'CustomFormField');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth|detectLang'), function()
{

    # Blog Comment Management
    Route::get('blogcomments/{blog}/commentsforblog', 'AdminBlogCommentController@getCommentsForBlog')
        ->where('blog', '[0-9]+');
    Route::get('blogcomments/{blogcomment}/edit', 'AdminBlogCommentController@getEdit')
        ->where('blogcomment', '[0-9]+');
    Route::post('blogcomments/{blogcomment}/edit', 'AdminBlogCommentController@postEdit')
        ->where('blogcomment', '[0-9]+');
    Route::get('blogcomments/{blogcomment}/delete', 'AdminBlogCommentController@getDelete')
        ->where('blogcomment', '[0-9]+');
    Route::post('blogcomments/{blogcomment}/delete', 'AdminBlogCommentController@getDelete')
        ->where('blogcomment', '[0-9]+');
    Route::controller('blogcomments', 'AdminBlogCommentController');
	
	 # Blog Category Management
    Route::get('blogcategorys/{blogcategory}/edit', 'AdminBlogCategoryController@getEdit')
        ->where('blogcategory', '[0-9]+');
    Route::post('blogcategorys/{blogcategory}/edit', 'AdminBlogCategoryController@postEdit')
        ->where('blogcategory', '[0-9]+');
    Route::get('blogcategorys/{blogcategory}/delete', 'AdminBlogCategoryController@getDelete')
        ->where('blogcategory', '[0-9]+');
    Route::post('blogcategorys/{blogcategory}/delete', 'AdminBlogCategoryController@getDelete')
        ->where('blogcategory', '[0-9]+');
    Route::controller('blogcategorys', 'AdminBlogCategoryController');

    # Blog Management
    Route::get('blogs/{blogcategory}/blogsforcategory', 'AdminBlogController@getBlogsForCategory')
        ->where('blogcategory', '[0-9]+');
    Route::get('blogs/{blog}/edit', 'AdminBlogController@getEdit')
        ->where('blog', '[0-9]+');
    Route::post('blogs/{blog}/edit', 'AdminBlogController@postEdit')
        ->where('blog', '[0-9]+');
    Route::get('blogs/{blog}/delete', 'AdminBlogController@getDelete')
        ->where('blog', '[0-9]+');
    Route::post('blogs/{blog}/delete', 'AdminBlogController@getDelete')
        ->where('blog', '[0-9]+');
    Route::controller('blogs', 'AdminBlogController');
	
	  # Gallery Comment Management
    Route::get('galleryimagecomments/{gallery}/commentsforgallery', 'AdminGalleryImageCommentController@getCommentsforgallery')
        ->where('gallery', '[0-9]+');
    Route::get('galleryimagecomments/{galleryimagecomment}/edit', 'AdminGalleryImageCommentController@getEdit')
        ->where('galleryimagecomment', '[0-9]+');
    Route::post('galleryimagecomments/{galleryimagecomment}/edit', 'AdminGalleryImageCommentController@postEdit')
        ->where('galleryimagecomment', '[0-9]+');
    Route::get('galleryimagecomments/{galleryimagecomment}/delete', 'AdminGalleryImageCommentController@getDelete')
        ->where('galleryimagecomment', '[0-9]+');
    Route::post('galleryimagecomments/{galleryimagecomment}/delete', 'AdminGalleryImageCommentController@getDelete')
        ->where('galleryimagecomment', '[0-9]+');
    Route::controller('galleryimagecomments', 'AdminGalleryImageCommentController');
	
	 # Gallery Images Management
    Route::get('galleryimages/{galleryimage}/delete', 'AdminGalleryImageController@postDelete')
        ->where('galleryimage', '[0-9]+');
    Route::controller('galleryimages', 'AdminGalleryImageController');
	
    # Galleries Management
    Route::get('galleries/{gallerycategory}/imagesforgallery', 'AdminGalleryController@getImagesForGallery')
        ->where('gallerycategory', '[0-9]+');
    Route::get('galleries/{gallery}/edit', 'AdminGalleryController@getEdit')
        ->where('gallery', '[0-9]+');
    Route::post('galleries/{gallery}/edit', 'AdminGalleryController@postEdit')
        ->where('gallery', '[0-9]+');
    Route::get('galleries/{gallery}/delete', 'AdminGalleryController@getDelete')
        ->where('gallery', '[0-9]+');
    Route::post('galleries/{gallery}/delete', 'AdminGalleryController@getDelete')
        ->where('gallery', '[0-9]+');
	Route::get('galleries/{gallery}/upload', 'AdminGalleryController@getUpload')
        ->where('gallery', '[0-9]+');
    Route::post('galleries/{gallery}/upload', 'AdminGalleryController@postUpload')
        ->where('gallery', '[0-9]+');		
    Route::controller('galleries', 'AdminGalleryController');
	
		# Navigation Management
	Route::get('pages/{nav}/visible', 'AdminPageController@getVisible')
        ->where('nav', '[0-9]+');
    Route::get('pages/{nav}/edit', 'AdminPageController@getEdit')
        ->where('nav', '[0-9]+');
    Route::post('pages/{nav}/edit', 'AdminPageController@postEdit')
        ->where('nav', '[0-9]+');
    Route::get('pages/{nav}/delete', 'AdminPageController@getDelete')
        ->where('nav', '[0-9]+');
    Route::post('pages/{nav}/delete', 'AdminPageController@getDelete')
        ->where('nav', '[0-9]+');
    Route::controller('pages', 'AdminPageController');
    
    # Navigation Group Management
    Route::get('navigationgroups/{group}/edit', 'AdminNavigationGroupController@getEdit')
        ->where('group', '[0-9]+');
    Route::post('navigationgroups/{group}/edit', 'AdminNavigationGroupController@postEdit')
        ->where('group', '[0-9]+');
    Route::get('navigationgroups/{group}/delete', 'AdminNavigationGroupController@getDelete')
        ->where('group', '[0-9]+');
    Route::post('navigationgroups/{group}/delete', 'AdminNavigationGroupController@getDelete')
        ->where('group', '[0-9]+');
    Route::controller('navigationgroups', 'AdminNavigationGroupController');

    # Navigation Management
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
    Route::get('users/{role}/usersforrole', 'AdminUserController@getUsersForRole')
        ->where('role', '[0-9]+');
    Route::get('users/{user}/show', 'AdminUserController@getShow')
        ->where('user', '[0-9]+');
    Route::get('users/{user}/edit', 'AdminUserController@getEdit')
        ->where('user', '[0-9]+');
    Route::post('users/{user}/edit', 'AdminUserController@postEdit')
        ->where('user', '[0-9]+');
    Route::get('users/{user}/delete', 'AdminUserController@getDelete')
        ->where('user', '[0-9]+');
    Route::post('users/{user}/delete', 'AdminUserController@getDelete')
        ->where('user', '[0-9]+');
	#Profile
	Route::get('users/profile', 'AdminUserController@getProfileEdit');
    Route::post('users/profile', 'AdminUserController@postProfileEdit');	
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
    Route::post('roles/{role}/delete', 'AdminRoleController@getDelete')
        ->where('role', '[0-9]+');
    Route::controller('roles', 'AdminRoleController');

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

 	# Custom form Management   
    Route::get('customform/{cform}/edit', 'AdminCustomFormController@getEdit')
        ->where('cform', '[0-9]+');
    Route::post('customform/{cform}/edit', 'AdminCustomFormController@postEdit')
        ->where('cform', '[0-9]+');
    Route::get('customform/{cform}/delete', 'AdminCustomFormController@getDelete')
        ->where('cform', '[0-9]+');
    Route::post('customform/{cform}/delete', 'AdminCustomFormController@getDelete')
        ->where('cform', '[0-9]+');
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
	Route::post('user/{user}/edit', 'UserController@postEdit')
    		->where('user', '[0-9]+');
	//User messages
	Route::get('user/messages', 'UserMessagesController@getIndex');
	Route::get('user/messages/{messageid}/read', 'UserMessagesController@getRead')
	        ->where('messageid', '[0-9]+');
	Route::post('user/messages/sendmessage', 'UserMessagesController@postSendmessage');
	
});

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset')
    ->where('token', '[0-9a-z]+');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset')
    ->where('token', '[0-9a-z]+');

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
/*
# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us page
Route::get('contact-us', 'WebsiteController@getContactus');
Route::post('contact-us', 'WebsiteController@postContactus');
*/
# Posts - Second to last set, match slug
Route::get('blog/{postSlug}', 'BlogController@getView');
Route::post('blog/{postSlug}', 'BlogController@postView');

Route::get('gallery/{postSlug}', 'GalleryController@getView');
Route::post('gallery/{postSlug}', 'GalleryController@postView');

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
Route::get('/', 'WebsiteController@getView');

