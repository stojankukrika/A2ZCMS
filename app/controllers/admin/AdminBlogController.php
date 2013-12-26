<?php

class AdminBlogController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $blog;

	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Blog $blog) {
		parent::__construct();
		$this -> blog = $blog;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {
		// Title
		$title = Lang::get('admin/blogs/title.blog_management');

		// Grab all the blog posts
		$blogs = $this -> blog;

		// Show the page
		return View::make('admin/blogs/index', compact('blogs', 'title'));
	}

	/**
	 * Show a list of all the blogs for the selected blog category.
	 *
	 * @return View
	 */
	public function getBlogsForCategory($id) {
		$blog_category = BlogCategory::find($id);
		// Title
		$title = Lang::get('admin/blogs/title.blog_management_for_category');

		// Show the page
		return View::make('admin/blogs/blogsforcategory', compact('title', 'blog_category'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// Title
		$title = Lang::get('admin/blogs/title.create_a_new_blog');

		// Blog category
		$blog_category = BlogCategory::all();
		
		$catselect = '';
		// Show the page
		return View::make('admin/blogs/create_edit', compact('title', 'blog_category','catselect'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3', 'content' => 'required|min:3', 'blogcategory_id' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Create a new blog post
			$user = Auth::user();

			// Update the blog post data
			$this -> blog -> title = Input::get('title');
			$this -> blog -> slug = Str::slug(Input::get('title'));
			$this -> blog -> content = Input::get('content');
			$this -> blog -> start_publish = (Input::get('start_publish') == '') ? date('Y-m-d') : Input::get('start_publish');
			$this -> blog -> end_publish = (Input::get('end_publish') == '') ? null : Input::get('end_publish');
			$this -> blog -> resource_link = Input::get('resource_link');
			$this -> blog -> user_id = $user -> id;
			if(Input::hasFile('image'))
			{
				$file = Input::file('image');
				$destinationPath = public_path() . '\blog\\/';
				$filename = $file->getClientOriginalName();				
				$extension = $file -> getClientOriginalExtension();
				$name = sha1($filename . time()) . '.' . $extension;		
			
				Input::file('image')->move($destinationPath, $name);
				Thumbnail::generate_image_thumbnail($destinationPath. $name, $destinationPath .'thumbs\\/' . $name);
				
				$this -> blog -> image = $name;
			}
			$this -> blog -> save();
			foreach (Input::get('blogcategory_id') as $item)
			{
				$blog_cat = new BlogBlogCategory;
				$blog_cat -> blog_id = $this -> blog->id;
				$blog_cat -> blog_category_id = $item;
				$blog_cat -> save();
			}
		}

		// Form validation failed
		return Redirect::to('admin/blogs/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function getEdit($id) {
		// Title
		$title = Lang::get('admin/blogs/title.blog_update');

		$blog = Blog::find($id);		
		$blog_category = BlogCategory::all();
		
		$catselect = BlogBlogCategory::where('blog_id','=',$id)->select(array('blog_category_id'))->get();

		// Show the page
		return View::make('admin/blogs/create_edit', compact('blog', 'title', 'blog_category','catselect'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function postEdit($id) {

		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3', 'content' => 'required|min:3');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
		
			$blog = Blog::find($id);
			$user = Auth::user();
			
			$blog -> title = Input::get('title');
			$blog -> slug = Str::slug(Input::get('title'));
			$blog -> content = Input::get('content');
			$blog -> start_publish = (Input::get('start_publish') == '') ? date('Y-m-d') : Input::get('start_publish');
			$blog -> end_publish = (Input::get('end_publish') == '') ? null : Input::get('end_publish');
			$blog -> resource_link = Input::get('resource_link');
			$blog -> user_id = $user -> id;
			if(Input::hasFile('image'))
			{
				$file = Input::file('image');
				$destinationPath = public_path() . '\blog\\/';
				$filename = $file->getClientOriginalName();				
				$extension = $file -> getClientOriginalExtension();
				$name = sha1($filename . time()) . '.' . $extension;		
			
				Input::file('image')->move($destinationPath, $name);
				Thumbnail::generate_image_thumbnail($destinationPath. $name, $destinationPath .'thumbs\\/' . $name);
				
				$blog -> image = $name;
			}
			$blog -> save();
			BlogBlogCategory::where('blog_id', $blog->id)->delete();
			foreach (Input::get('blogcategory_id') as $item)
			{
				$blog_cat = new BlogBlogCategory;
				$blog_cat -> blog_id = $blog ->id;
				$blog_cat -> blog_category_id = $item;
				$blog_cat -> save();
			}
		}

		// Form validation failed
		return Redirect::to('admin/blogs/' . $id->id . '/edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function getDelete($id) {
			
		$blog = Blog::find($id);
		// Was the role deleted?
		if ($blog -> delete()) {

			// Redirect to the blog posts management page
			return Redirect::to('admin/blogs') -> with('success', Lang::get('admin/blogs/messages.delete.success'));
		}
		// There was a problem deleting the blog post
		return Redirect::to('admin/blogs') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$blogs = Blog::select(array('blogs.id', 'blogs.title', 'blogs.id as blog_comments', 'blogs.created_at'));

		return Datatables::of($blogs) 
			-> edit_column('blog_comments', '<a href="{{{ URL::to(\'admin/blogcomments/\' . $id . \'/commentsforblog\' ) }}}" class="btn btn-link  btn-sm" >{{ BlogComment::where(\'blog_id\', \'=\', $id)->count() }}</a>') 
			-> add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-sm iframe" ><i class="icon-edit "></i></a>
                <a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
            ') 
            -> remove_column('id') -> make();
	}

}
