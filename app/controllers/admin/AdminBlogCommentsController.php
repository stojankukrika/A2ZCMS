<?php

class AdminBlogCommentsController extends AdminController {

    /**
     * Comment Model
     * @var Comment
     */
    protected $blog_comment;

    /**
     * Inject the models.
     * @param Comment $comment
     */
    public function __construct(BlogComment $blog_comment)
    {
        parent::__construct();
        $this->blog_comment = $blog_comment;
    }

    /**
     * Show a list of all the comment blogs.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/blogcomments/title.comment_management');

        // Grab all the comment posts
        $blog_comment = $this->blog_comment;

        // Show the page
        return View::make('admin/blogcomments/index', compact('blog_comment', 'title'));
    }
	 /**
     * Show a list of all the comment for the selected blog.
     *
     * @return View
     */
    public function getCommentsForBlog($blog)
    {
        // Title
        $title = Lang::get('admin/blogcomments/title.comment_management_for_blog');

		// Show the page
        return View::make('admin/blogcomments/commentsforblog', compact('title','blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $comment
     * @return Response
     */
	public function getEdit($blog_comment)
	{
        // Title
        $title = Lang::get('admin/blogcomments/title.comment_update');

        // Show the page
        return View::make('admin/blogcomments/edit', compact('blog_comment', 'title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $comment
     * @return Response
     */
	public function postEdit($blog_comment)
	{
        // Declare the rules for the form validation
        $rules = array(
            'content' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the comment post data
            $blog_comment->content = Input::get('content');

            // Was the comment post updated?
            if($blog_comment->save())
            {
                // Redirect to the new comment post page
                return Redirect::to('admin/blogcomments/' . $blog_comment->id . '/edit')->with('success', Lang::get('admin/blogcomments/messages.update.success'));
            }

            // Redirect to the comments post management page
            return Redirect::to('admin/blogcomments/' . $blog_comment->id . '/edit')->with('error', Lang::get('admin/blogcomments/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/blogcomments/' . $blog_comment->id . '/edit')->withInput()->withErrors($validator);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $comment
     * @return Response
     */
	public function getDelete($blog_comment)
	{
        // Title
        $title = Lang::get('admin/blogcomments/title.comment_delete');

        // Show the page
        return View::make('admin/blogcomments/delete', compact('blog_comment', 'title'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $blog_comment
     * @return Response
     */
	public function postDelete($blog_comment)
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
            $id = $blog_comment->id;
            $blog_comment->delete();

            // Was the comment post deleted?
            $blog_comment = BlogComment::find($id);
            if(empty($blog_comment))
            {
                // Redirect to the comment posts management page
                return Redirect::to('admin/blogcomments')->with('success', Lang::get('admin/blogcomments/messages.delete.success'));
            }
        }
        // There was a problem deleting the comment post
        return Redirect::to('admin/blogcomments')->with('error', Lang::get('admin/blogcomments/messages.delete.error'));
	}

    /**
     * Show a list of all the comments formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $comments = BlogComment::join('blogs', 'blogs.id', '=', 'blog_comments.blog_id')
                        ->join('users', 'users.id', '=','blog_comments.user_id' )
                        ->select(array('blog_comments.id as id', 'blogs.id as blogid','users.id as userid', 'blog_comments.content', 'blogs.title as post_name', 'users.username as poster_name', 'blog_comments.created_at'));

        return Datatables::of($comments)

        ->edit_column('content', '<a href="{{{ URL::to(\'admin/blogcomments/\'. $id .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')

        ->edit_column('post_name', '<a href="{{{ URL::to(\'admin/blogs/\'. $blogid .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')

        ->edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="iframe cboxElement">{{{ $poster_name }}}</a>')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/blogcomments/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-xs">{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogcomments/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')
        ->remove_column('blogid')
        ->remove_column('userid')

        ->make();
    }
 	/**
     * Show a list of all the blog comments for selected blog formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getDataforblog($blog_id)
    {	
       $comments = BlogComment::join('blogs', 'blogs.id', '=', 'blog_comments.blog_id')
                        ->join('users', 'users.id', '=','blog_comments.user_id' )
						->where('blogs.id','=',$blog_id)
                        ->select(array('blog_comments.id as id', 'blogs.id as postid','users.id as userid', 
                        'blog_comments.content','users.username as poster_name', 
                        'blog_comments.created_at'));

        return Datatables::of($comments)

        ->edit_column('content', '<a href="{{{ URL::to(\'admin/blogcomments/\'. $id .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')

        ->edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="iframe cboxElement">{{{ $poster_name }}}</a>')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/blogcomments/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-xs">{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogcomments/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')
        ->remove_column('postid')
        ->remove_column('userid')

        ->make();
    }
	
}
