<?php

class GalleryController extends BaseController {

	/**
	 * Gallery Model
	 * @var Gallery
	 */
	protected $gallery;

	/**
	 * User Model
	 * @var User
	 */
	protected $user;
	/**
	 * Settings Model
	 * @var Settings
	 */
	protected $settings;
	/**
	 * Inject the models.
	 * @param Blog $blog
	 * @param User $user
	 */
	protected $navigation;
	public function __construct(Gallery $gallery, User $user, Settings $settings) {
		parent::__construct();
		$this -> gallery = $gallery;
		$this -> user = $user;
		$settings = Settings::all();
		$this -> settings = $settings;

	}

	/**
	 * View a gallery.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($id) {

		$pageitem = 2;
        foreach ($this->settings as $v) {
                if ($v -> varname == 'pageitem') {
                        $pageitem = $v -> value;
                }
        }
		$gallery = $this -> gallery -> where('id', '=', $id) -> first();

		if (is_null($gallery)) {
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
		
		$gallery -> views = $gallery -> views +1;
		$gallery -> update();

		$gallery_images = $gallery -> galleryimages() -> orderBy('created_at', 'ASC') ->paginate($pageitem);

		// Get current user and check permission
		$user = $this -> user -> currentUser();
		$canGalleryComment = false;
		if (!empty($user)) {
			$canGalleryComment = $user -> can('post_gallery_comment');
		}
		$page = Page::first();
		$pagecontent = BaseController::createSiderContent($page->id);
		// Show the page
		$data['sidebar_right'] = $pagecontent['sidebar_right'];
		$data['sidebar_left'] = $pagecontent['sidebar_left'];
		$data['page'] = $page;
		$data['canGalleryComment'] = $canGalleryComment;
		$data['gallery_images'] = $gallery_images;
		$data['gallery'] = $gallery;
		return View::make('site/gallery/index', $data);
	}

	public function getGalleryImage($galid,$imgid)
	{
		$pageitem = 2;
        foreach ($this->settings as $v) {
                if ($v -> varname == 'pageitem') {
                        $pageitem = $v -> value;
                }
        }
		$gallery = $this -> gallery -> where('id', '=', $galid) -> first();
		$gallery_image = GalleryImage::find($imgid);

		// Check if the blog blog exists
		if (is_null($gallery) || is_null($gallery_image)) {
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
		$gallery_image -> views = $gallery_image -> views +1;
		$gallery_image -> update();
		
		$gallery_comments = $gallery_image -> imagecomments()-> orderBy('created_at', 'ASC') ->paginate($pageitem);
		
		// Get current user and check permission
		$user = $this -> user -> currentUser();
		$canGalleryComment = false;
		if (!empty($user)) {
			$canGalleryComment = $user -> can('post_gallery_comment');
		}
		$page = Page::first();
		$pagecontent = BaseController::createSiderContent($page->id);
		// Show the page
		$data['sidebar_right'] = $pagecontent['sidebar_right'];
		$data['sidebar_left'] = $pagecontent['sidebar_left'];
		$data['page'] = $page;
		$data['canGalleryComment'] = $canGalleryComment;
		$data['gallery_image'] = $gallery_image;
		$data['gallery'] = $gallery;
		$data['gallery_comments'] = $gallery_comments;
		return View::make('site/gallery/galleryimage', $data);
	}
	public function postGalleryImage($galid,$imgid)
	{
		$user = $this -> user -> currentUser();
		$canGalleryComment = $user -> can('post_gallery_comment');
		if (!$canGalleryComment) {
			return Redirect::to('galleryimage/'.$galid . '/'.$imgid.'#new_comment') -> with(Lang::get('site/gallery.error'), Lang::get('site/gallery.need_to_login'));
		}

		// Declare the rules for the form validation
		$rules = array('gallcomment' => 'required|min:3');
		
		$gallery = $this -> gallery -> where('id', '=', $galid) -> first();
		$gallery_image = GalleryImage::find($imgid);

		// Check if the blog blog exists
		if (is_null($gallery) || is_null($gallery_image)) {
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Save the comment
			$gallery_image_comment = new GalleryImageComment;
			$gallery_image_comment -> user_id = Auth::user() -> id;
			$gallery_image_comment -> content = Input::get('gallcomment');
			$gallery_image_comment -> gallery_id = $galid;
			$gallery_image_comment -> gallery_image_id = $imgid;
			
			// Was the comment saved with success?
			if ($gallery_image_comment -> save()) {
				// Redirect to this blog blog page
				return Redirect::to('galleryimage/'.$galid . '/'.$imgid. '#new_comment') -> with(Lang::get('site/gallery.success'), Lang::get('site/gallery.comment_added'));
			}

			// Redirect to this blog blog page
			return Redirect::to('galleryimage/'.$galid . '/'.$imgid. '#new_comment') -> with(Lang::get('site/gallery.error'), Lang::get('site/gallery.add_comment_error'));
		}

		// Redirect to this blog blog page
		return Redirect::to('galleryimage/'.$galid . '/'.$imgid) -> withInput() -> withErrors($validator);
	}

}
