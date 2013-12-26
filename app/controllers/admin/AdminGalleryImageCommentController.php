<?php

class AdminGalleryImageCommentController extends AdminController {

	/**
	 * Comment Model
	 * @var Comment
	 */
	protected $gallery_comment;

	/**
	 * Inject the models.
	 * @param Comment $comment
	 */
	public function __construct(GalleryImageComment $gallery_comment) {
		parent::__construct();
		$this -> gallery_comment = $gallery_comment;
	}

	/**
	 * Show a list of all the comment images.
	 *
	 * @return View
	 */
	public function getIndex() {
		// Title
		$title = Lang::get('admin/galleryimagecomments/title.comment_management');

		// Grab all the comment posts
		$gallery_comment = $this -> gallery_comment;

		// Show the page
		return View::make('admin/galleryimagecomments/index', compact('gallery_comment', 'title'));
	}

	/**
	 * Show a list of all the comment for the selected gallery.
	 *
	 * @return View
	 */
	public function getCommentsforgallery($gallery) {
		// Title
		$title = Lang::get('admin/galleryimagecomments/title.comment_management_for_gallery');

		// Show the page
		return View::make('admin/galleryimagecomments/commentsforgallery', compact('title', 'gallery'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $comment
	 * @return Response
	 */
	public function getEdit($id) {
		
		$gallery_comment = GalleryImageComment::find($id);
		// Title
		$title = Lang::get('admin/galleryimagecomments/title.comment_update');

		// Show the page
		return View::make('admin/galleryimagecomments/edit', compact('gallery_comment', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $comment
	 * @return Response
	 */
	public function postEdit($id) {
		// Declare the rules for the form validation
		$rules = array('content' => 'required|min:3');

		$validator = Validator::make(Input::all(), $rules);

		$gallerycomment = GalleryImageComment::find($id);

		$inputs = Input::all();

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Was the page updated?
			if ($gallerycomment -> update($inputs)) {
				// Redirect to the new comment post page
				return Redirect::to('admin/galleryimagecomments/' . $gallerycomment -> id . '/edit') -> with('success', Lang::get('admin/galleryimagecomments/messages.update.success'));
			}

			// Redirect to the comments post management page
			return Redirect::to('admin/galleryimagecomments/' . $gallerycomment -> id . '/edit') -> with('error', Lang::get('admin/galleryimagecomments/messages.update.error'));
		}

		// Form validation failed
		return Redirect::to('admin/galleryimagecomments/' . $gallerycomment -> id . '/edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $comment
	 * @return Response
	 */
	public function getDelete($gallery_comment) {
		
			$id = $gallery_comment->id;
			$gallerycomment = GalleryImageComment::find($id);
			// Was the role deleted?
			if ($gallerycomment -> delete()) {
				// Redirect to the comment posts management page
				return Redirect::to('admin/galleryimagecomments') -> with('success', Lang::get('admin/galleryimagecomments/messages.delete.success'));
			}
		// There was a problem deleting the comment post
		return Redirect::to('admin/galleryimagecomments') -> with('error', Lang::get('admin/galleryimagecomments/messages.delete.error'));
	}


	/**
	 * Show a list of all the comments formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$comments = GalleryImageComment::join('gallery', 'gallery.id', '=', 'gallery_images_comments.gallery_id') -> join('users', 'users.id', '=', 'gallery_images_comments.user_id') -> select(array('gallery_images_comments.id as id', 'gallery_images_comments.content as post', 'gallery.title as gallerytitle', 'gallery.id as galleryid', 'users.id as userid', 'users.username as poster_name', 'gallery_images_comments.created_at'));

		return Datatables::of($comments) -> edit_column('gallerytitle', '<a href="{{{ URL::to(\'admin/galleries/\'. $galleryid .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($gallerytitle, 40, \'...\') }}}</a>') 
				-> edit_column('post', '<a href="{{{ URL::to(\'admin/galleries/\'. $galleryid .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($post, 40, \'...\') }}}</a>') 
				-> edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="iframe cboxElement">{{{ $poster_name }}}</a>') 
				-> add_column('actions', '<a href="{{{ URL::to(\'admin/galleryimagecomments/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-sm"><i class="icon-edit "></i></a>
                <a href="{{{ URL::to(\'admin/galleryimagecomments/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
            ') -> remove_column('id') -> remove_column('galleryid') -> remove_column('userid') -> make();
	}

	/**
	 * Show a list of all the blog comments for selected blog formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getDataforgallery($gallery_id) {
		$comments = GalleryImageComment::join('users', 'gallery_images_comments.user_id', '=', 'users.id') -> join('gallery', 'gallery_images_comments.gallery_id', '=', 'gallery.id') -> where('gallery_images_comments.gallery_id', '=', $gallery_id) -> where('gallery_images_comments.deleted_at', '=', NULL) -> select(array('gallery_images_comments.id as id', 'gallery_images_comments.gallery_id as gallery_id', 'gallery_images_comments.content as comment', 'gallery.title as content', 'users.id as userid', 'users.username as poster_name', 'gallery_images_comments.created_at'));

		return Datatables::of($comments) -> edit_column('content', '<a href="{{{ URL::to(\'admin/galleries/\'. $gallery_id .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>') 
				-> edit_column('comment', '<a href="{{{ URL::to(\'admin/galleryimagecomments/\'. $id .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($comment, 40, \'...\') }}}</a>') 
				-> edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="iframe cboxElement">{{{ $poster_name }}}</a>') 
				-> add_column('actions', '<a href="{{{ URL::to(\'admin/galleryimagecomments/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-sm"><i class="icon-edit "></i></a>
                <a href="{{{ URL::to(\'admin/galleryimagecomments/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
            ') -> remove_column('id') -> remove_column('gallery_id') -> remove_column('userid') -> make();
	}

}
