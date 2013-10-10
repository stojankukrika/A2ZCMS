<?php

class AdminBlogCategorysController extends AdminController {

    /**
     * BlogCategory Model
     * @var BlogCategory
     */
    protected $blog_category;

    /**
     * Inject the models.
     * @param BlogCategory $blog_category
     */
    public function __construct(BlogCategory $blog_category)
    {
        parent::__construct();
        $this->blog_category = $blog_category;
    }

    /**
     * Show a list of all the blog_category posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/blogcategorys/title.category_management');

        // Grab all the blog_category posts
        $blogcategorys = $this->blog_category;

        // Show the page
        return View::make('admin/blogcategorys/index', compact('blogcategorys', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $blog_category
     * @return Response
     */
	public function getEdit($blog_category)
	{
        // Title
        $title = Lang::get('admin/blogcategorys/title.category_update');

        // Show the page
        return View::make('admin/blogcategorys/edit', compact('blog_category', 'title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $blog_category
     * @return Response
     */
	public function postEdit($blog_category)
	{
        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog_category post data
            $blog_category->title = Input::get('title');

            // Was the blog_category post updated?
            if($blog_category->save())
            {
                // Redirect to the new blog_category post page
                return Redirect::to('admin/blogcategorys/' . $blog_category->id . '/edit')->with('success', Lang::get('admin/blogcategorys/messages.update.success'));
            }

            // Redirect to the comments post management page
            return Redirect::to('admin/blogcategorys/' . $blog_category->id . '/edit')->with('error', Lang::get('admin/blogcategorys/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/blogcategorys/' . $blog_category->id . '/edit')->withInput()->withErrors($validator);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $comment
     * @return Response
     */
	public function getDelete($blog_category)
	{
        // Title
        $title = Lang::get('admin/blogcategorys/title.category_delete');

        // Show the page
        return View::make('admin/blogcategorys/delete', compact('blog_category', 'title'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $comment
     * @return Response
     */
	public function postDelete($blog_category)
	{
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            $id = $blog_category->id;
            $blog_category->delete();

            // Was the comment post deleted?
            $blog_category = BlogCategory::find($id);
            if(empty($blog_category))
            {
                // Redirect to the comment posts management page
                return Redirect::to('admin/blogcategorys')->with('success', Lang::get('admin/blogcategorys/messages.delete.success'));
            }
        }
        // There was a problem deleting the comment post
        return Redirect::to('admin/blogcategorys')->with('error', Lang::get('admin/blogcategorys/messages.delete.error'));
	}

    /**
     * Show a list of all the comments formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
         $blogcategorys = BlogCategory::select(array('blog_categorys.id', 'blog_categorys.title', 'blog_categorys.id as blog_count','blog_categorys.created_at'));

        return Datatables::of($blogcategorys)

        ->edit_column('blog_count', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/blogsforcategory\' ) }}}" class="btn btn-default btn-xs" >{{ DB::table(\'blogs\')->where(\'blogcategory_id\', \'=\', $id)->count() }}</a>')
        
        ->add_column('actions', '<a href="{{{ URL::to(\'admin/blogcategorys/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogcategorys/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')
        
        ->remove_column('id')
        
        ->make();
    }

}
