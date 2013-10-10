<?php

class AdminSettingsController extends AdminController {

	 /**
     * Post Model
     * @var Post
     */
    protected $settings;
	protected $guarded = array('id', 'created_at','updated_at');

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Settings $settings)
    {
        parent::__construct();
        $this->settings = $settings;
    } 
	  /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/settings/title.settings_menagement');

        // Grab all the blog posts
        $settings = $this->settings;

        // Show the page
        return View::make('admin/settings/index', compact('settings', 'title'));
    }
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
        // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3',
            'blogcategory_id' => 'required'
        );
		
	     // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Create a new blog post
            $user = Auth::user();

            // Update the blog post data
            $this->blog->title            = Input::get('title');
			$this->blog->blogcategory_id  = Input::get('blogcategory_id');
            $this->blog->slug             = Str::slug(Input::get('title'));
            $this->blog->content          = Input::get('content');
            $this->blog->meta_title       = Input::get('meta-title');
            $this->blog->meta_description = Input::get('meta-description');
            $this->blog->meta_keywords    = Input::get('meta-keywords');			
			$this->blog->start_publish    = (Input::get('start_publish')=='')?date('Y-m-d'):Input::get('start_publish');
            $this->blog->end_publish 	  = (Input::get('end_publish')=='')?null:Input::get('end_publish');
            $this->blog->resource_link    = Input::get('resource_link');
            $this->blog->user_id          = $user->id;

            // Was the blog post created?
            if($this->blog->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/blogs/' . $this->blog->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/blogs/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/blogs/create')->withInput()->withErrors($validator);
	}

}
