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
     * Inject the models.
     * @param Blog $blog
     * @param User $user
     */
    public function __construct(Blog $blog, User $user)
    {
        parent::__construct();

        $this->blog = $blog;
        $this->user = $user;
    }
    
	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get all the blog posts
		$blogs = $this->blog->orderBy('created_at', 'DESC')->paginate(10);

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
	public function getView($slug)
	{
		// Get this blog blog data
		$blog = $this->blog->where('slug', '=', $slug)->first();

		// Check if the blog blog exists
		if (is_null($blog))
		{
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}

		// Get this blog comments
		$comments = $blog->comments()->orderBy('created_at', 'ASC')->get();

        // Get current user and check permission
        $user = $this->user->currentUser();
        $canComment = false;
        if(!empty($user)) {
            $canComment = $user->can('post_comment');
        }

		// Show the page
		return View::make('site/blog/view_post', compact('blog', 'comments', 'canComment'));
	}

	/**
	 * View a blog blog.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{

        $user = $this->user->currentUser();
        $canComment = $user->can('post_comment');
		if ( ! $canComment)
		{
			return Redirect::to($slug . '#comments')->with('error', 'You need to be logged in to blog comments!');
		}

		// Get this blog blog data
		$blog = $this->blog->where('slug', '=', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Save the comment
			$comment = new Comment;
			$comment->user_id = Auth::user()->id;
			$comment->content = Input::get('comment');

			// Was the comment saved with success?
			if($blog->comments()->save($comment))
			{
				// Redirect to this blog blog page
				return Redirect::to($slug . '#comments')->with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog blog page
			return Redirect::to($slug . '#comments')->with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog blog page
		return Redirect::to($slug)->withInput()->withErrors($validator);
	}
}