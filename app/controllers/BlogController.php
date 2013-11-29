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
	 * View a blog blog.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug) {
		$pageitem = 2;
        foreach ($this->settings as $v) {
                if ($v -> varname == 'pageitem') {
                        $pageitem = $v -> value;
                }
        }
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
		$blog_comments = $blog -> blogcomments() -> orderBy('created_at', 'ASC') -> paginate($pageitem);

		// Get current user and check permission
		$user = $this -> user -> currentUser();
		$canBlogComment = false;
		if (!empty($user)) {
			$canBlogComment = $user -> can('post_blog_comment');
		}
		
		$canBlogVote = false;
		if (!empty($user)) {
			$canBlogVote = $user -> can('post_blog_vote');
		}
	
		$page = Page::first();
		$pagecontent = BaseController::createSiderContent($page->id);
		// Show the page
		$data['sidebar_right'] = $pagecontent['sidebar_right'];
		$data['sidebar_left'] = $pagecontent['sidebar_left'];
		$data['page'] = $page;
		$data['canBlogComment'] = $canBlogComment;
		$data['canBlogVote'] = $canBlogVote;
		$data['blog_comments'] = $blog_comments;
		$data['blog'] = $blog;
		return View::make('site/blog/index', $data);
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
			return Redirect::to('blog/'.$slug . '#new_comment') -> with(Lang::get('site/blog.error'), Lang::get('site/blog.need_to_login'));
		}

		// Get this blog blog data
		$blog = $this -> blog -> where('slug', '=', $slug) -> first();
		$blog ->hits = $blog ->hits +1;
		$blog - save();
		// Declare the rules for the form validation
		$rules = array('blogcomment' => 'required|min:3');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Save the comment
			$blog_comment = new BlogComment;
			$blog_comment -> user_id = Auth::user() -> id;
			$blog_comment -> content = Input::get('blogcomment');

			// Was the comment saved with success?
			if ($blog -> blogcomments() -> save($blog_comment)) {
				// Redirect to this blog blog page
				return Redirect::to('blog/'.$slug . '#new_comment') -> with(Lang::get('site/blog.success'), Lang::get('site/blog.comment_added'));
			}

			// Redirect to this blog blog page
			return Redirect::to('blog/'.$slug . '#new_comment') -> with(Lang::get('site/blog.error'), Lang::get('site/blog.add_comment_error'));
		}

		// Redirect to this blog blog page
		return Redirect::to('blog/'.$slug) -> withInput() -> withErrors($validator);
	}

}
