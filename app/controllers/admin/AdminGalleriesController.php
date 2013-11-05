<?php

class AdminGalleriesController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $gallery;
	protected $gallery_image;

	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Gallery $gallery, GalleryImage $gallery_image) {
		parent::__construct();
		$this -> gallery = $gallery;
		$this -> gallery_image = $gallery_image;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {
		// Title
		$title = Lang::get('admin/galleries/title.gallery_management');

		// Grab all the blog posts
		$galleries = $this -> gallery;

		// Show the page
		return View::make('admin/galleries/index', compact('galleries', 'title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// Title
		$title = Lang::get('admin/galleries/title.create_a_new_gallery');

		// Show the page
		return View::make('admin/galleries/create_edit', compact('title'));
	}

	public function post_create() {
		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3|max:250');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {

			// Create a new blog post
			$user = Auth::user();
			$this -> gallery -> title = Input::get('title');
			$this -> gallery -> start_publish = (Input::get('start_publish') == '') ? date('Y-m-d') : Input::get('start_publish');
			$this -> gallery -> end_publish = (Input::get('end_publish') == '') ? null : Input::get('end_publish');
			$this -> gallery -> user_id = $user -> id;
			$this -> gallery -> folderid = sha1($this -> gallery -> title . $this -> gallery -> start_publish);
			// Was the gallery created?
			if ($this -> gallery -> save()) {
				File::makeDirectory(base_path() . '\public\images\/' . $this -> gallery -> folderid);
				File::makeDirectory(base_path() . '\public\images\/' . $this -> gallery -> folderid . '\/thumbs');

				// Redirect to the new gallery post page
				return Redirect::to('admin/galleries/' . $this -> gallery -> id . '/edit') -> with('success', Lang::get('admin/blogs/messages.create.success'));
			}

			// Redirect to the gallery create page
			return Redirect::to('admin/galleries/create') -> with('error', Lang::get('admin/blogs/messages.create.error'));
		}

		// Form validation failed
		return Redirect::to('admin/galleries/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function getEdit($galleries) {
		// Title
		$title = Lang::get('admin/galleries/title.gallery_update');

		// Show the page
		return View::make('admin/galleries/create_edit', compact('galleries', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function postEdit($id) {

		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3|max:250');

		$validator = Validator::make(Input::all(), $rules);

		$gallery = Gallery::find($id);

		$inputs = Input::all();

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Was the page updated?
			if ($gallery -> update($inputs)) {
				// Redirect to the new blog post page
				return Redirect::to('admin/galleries/' . $galleries -> id . '/edit') -> with('success', Lang::get('admin/galleries/messages.update.success'));
			}

			// Redirect to the blogs post management page
			return Redirect::to('admin/galleries/' . $galleries -> id . '/edit') -> with('error', Lang::get('admin/galleries/messages.update.error'));
		}

		// Form validation failed
		return Redirect::to('admin/galleries/' . $galleries -> id . '/edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function getDelete($galleries) {
		// Title
		$title = Lang::get('admin/galleries/title.gallery_delete');

		// Show the page
		return View::make('admin/galleries/delete', compact('galleries', 'title'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function postDelete($id) {
		//echo $pageId;exit;
		$gallery = Gallery::find($id);
		// Was the role deleted?
		if ($gallery -> delete()) {
			// Redirect to the blog posts management page
			return Redirect::to('admin/galleries') -> with('success', Lang::get('admin/galleries/messages.delete.success'));
		}
		// There was a problem deleting the blog post
		return Redirect::to('admin/galleries') -> with('error', Lang::get('admin/galleries/messages.delete.error'));
	}

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$galleries = Gallery::select(array('gallery.id', 'gallery.title', 'gallery.id as images_count', 'gallery.id as comments_count', 'gallery.created_at'));

		return Datatables::of($galleries) -> edit_column('images_count', '<a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/imagesforgallery\' ) }}}" class="btn btn-link btn-sm" >{{ DB::table(\'gallery_images\')->where(\'gallery_id\', \'=\', $id)->where(\'deleted_at\', \'=\', NULL)->count() }}</a>') 
			-> edit_column('comments_count', '<a href="{{{ URL::to(\'admin/galleryimagecomments/\' . $id . \'/commentsforgallery\' ) }}}" class="btn btn-link btn-sm" >{{ DB::table(\'gallery_images_comments\')->where(\'gallery_id\', \'=\', $id)->where(\'deleted_at\', \'=\', NULL)->count() }}</a>') 
			-> add_column('actions', '<a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/upload\' ) }}}" class="btn btn-info btn-sm iframe" ><i class="icon-picture "></i></a>
        		<a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-sm iframe" ><i class="icon-edit "></i></a>
                <a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><i class="icon-trash "></i></a>
            ') -> remove_column('id') -> make();
	}

	/*
	 * Get upload pictures for gallery
	 * */
	public function getUpload($galleries) {
		// Title
		$title = Lang::get('admin/galleries/title.gallery_add_picture');

		$id = $galleries -> id;
		$galleries = Gallery::find($id);

		// Show the page
		return View::make('admin/galleries/upload', compact('galleries', 'title'));
	}

	/*
	 * Upload pictures for gallery
	 * */
	public function postUpload() {
		$rules = array('gid' => 'required|integer', 'qqfile' => 'required|image|max:3000', );
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {

			$id = Input::get('gid');

			$galleries = Gallery::find($id);

			$path = public_path() . '\images\\/' . $galleries -> folderid;
			Fineuploader::init($path);

			$name = Fineuploader::getName();

			$info = new SplFileInfo($name);
			$extension = $info -> getExtension();

			$name = sha1($name . $galleries -> folderid . time()) . '.' . $extension;

			$user = Auth::user();
			$this -> gallery_image -> gallery_id = $id;
			$this -> gallery_image -> content = $name;
			$this -> gallery_image -> user_id = $user -> id;
			$this -> gallery_image -> save();

			Fineuploader::upload($name);

			$path2 = public_path() . '\images\\/' . $galleries -> folderid . '\thumbs\/';
			Fineuploader::init($path2);
			$upload_success = Fineuploader::upload($name);

			Thumbnail::generate_image_thumbnail($path2 . $name, $path2 . $name);

			return Response::json($upload_success);
		} else {
			return Response::json('error', 400);
		}
	}

	public function getImagesForGallery($gallery_id) {
		// Title
		$title = Lang::get('admin/galleries/title.gallery_management_for_category');
		$galleries = Gallery::find($gallery_id);
		// Show the page
		return View::make('admin/galleries/imagesforgallery', compact('galleries', 'title'));
	}

}
