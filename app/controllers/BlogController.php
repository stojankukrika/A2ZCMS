<?php

class BlogController extends BaseController {

	/**
	 * Blog Model
	 * @var Blog
	 */
	protected $blog;

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
	public function __construct(Blog $blog, User $user, Settings $settings) {
		parent::__construct();
		$this -> blog = $blog;
		$this -> user = $user;
		$settings = Settings::all();
		$this -> settings = $settings;

	}

	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {
		$pageitem = 2;
		foreach ($this->settings as $v) {
			if ($v -> varname == 'pageitem') {
				$pageitem = $v -> value;
			}
		}
		// Get all the blog posts
		$blogs = $this -> blog -> orderBy('created_at', 'DESC') -> paginate($pageitem);
		
		// Show the page
		return View::make('site/blog/index', compact('blogs'));
	}

	/**
	 * View a blog blog.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug) {
		// Get this blog blog data
		$blog = $this -> blog -> where('slug', '=', $slug) -> first();

		// Check if the blog blog exists
		if (is_null($blog)) {
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}

		// Get this blog comments
		$blog_comments = $blog -> blogcomments() -> orderBy('created_at', 'ASC') -> get();

		// Get current user and check permission
		$user = $this -> user -> currentUser();
		$canBlogComment = false;
		if (!empty($user)) {
			$canBlogComment = $user -> can('post_blog_comment');
		}
		// Show the page
		return View::make('site/blog/view_post', compact('blog', 'blog_comments', 'canBlogComment'));
	}

	/**
	 * View a blog blog.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug) {

		$user = $this -> user -> currentUser();
		$canBlogComment = $user -> can('post_blog_comment');
		if (!$canBlogComment) {
			return Redirect::to($slug . '#blogcomments') -> with('error', 'You need to be logged in to blog comments!');
		}

		// Get this blog blog data
		$blog = $this -> blog -> where('slug', '=', $slug) -> first();

		// Declare the rules for the form validation
		$rules = array('comment' => 'required|min:3');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Save the comment
			$blog_comment = new BlogComment;
			$blog_comment -> user_id = Auth::user() -> id;
			$blog_comment -> content = Input::get('comment');

			// Was the comment saved with success?
			if ($blog -> blogcomments() -> save($blog_comment)) {
				// Redirect to this blog blog page
				return Redirect::to($slug . '#blogcomments') -> with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog blog page
			return Redirect::to($slug . '#blogcomments') -> with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog blog page
		return Redirect::to($slug) -> withInput() -> withErrors($validator);
	}

}
