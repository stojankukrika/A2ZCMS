<?php

class AdminGalleriesController extends AdminController {

     /**
     * Post Model
     * @var Post
     */
    protected $gallery;

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Gallery $gallery)
    {
        parent::__construct();
        $this->gallery = $gallery;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/galleries/title.gallery_management');

        // Grab all the blog posts
        $galleries = $this->gallery;

        // Show the page
        return View::make('admin/galleries/index', compact('galleries', 'title'));
    }
   


    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/galleries/title.create_a_new_gallery');
		
        // Show the page
        return View::make('admin/galleries/create_edit', compact('title'));
	}


    public function post_create()
    {
          // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3|max:60'
        );
		
	     // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
        	 // Create a new blog post
            $user = Auth::user();
		   $this->gallery->title            = Input::get('title');
		   $this->gallery->start_publish    = (Input::get('start_publish')=='')?date('Y-m-d'):Input::get('start_publish');
		   $this->gallery->end_publish 	  = (Input::get('end_publish')=='')?null:Input::get('end_publish');
		   $this->gallery->user_id          = $user->id;
			
			 // Was the gallery created?
            if($this->gallery->save())
            {
            	File::mkdir(path('public').'images/'.$this->gallery->id);
        		File::mkdir(path('public').'images/'.$this->gallery->id.'/thumbs');

        // Redirect to the new gallery post page
                return Redirect::to('admin/galleries/' . $this->gallery->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
            }

            // Redirect to the gallery create page
            return Redirect::to('admin/galleries/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/galleries/create')->withInput()->withErrors($validator);
	}

/*
    public function get_edit($galleryID)
    {
        $gallery = Galleries::get($galleryID);

        if ($gallery != null) {
            return View::make('admin/galleries.edit')
                ->with('gallery', $gallery);
        } else {
            return "Error";
        }
    }

    public function post_edit($galleryID)
    {
        $validation = Validator::make(Input::get(), array('galleryName' => 'required|max:60'));
        
        if ($validation->fails()) {
            return Redirect::to('admin/galleries');
        }

        Galleries::edit($galleryID, Input::get('galleryName'));

        return Redirect::to('admin/galleries');
    }

    public function get_delete($galleryID)
    {
        $gallery = Galleries::get($galleryID);

        if ($gallery != null) {
            return View::make('admin/galleries.delete')
                ->with('gallery', $gallery);
        } else {
            return "Error";
        } 
    }

    public function post_delete($galleryID)
    {
        Galleries::delete($galleryID);
        File::rmdir(path('public').'images/'.$galleryID);

        return Redirect::to('admin/galleries');
    }

    public function get_upload($galleryID)
    {
        $gallery = Galleries::get($galleryID);

        if ($gallery != null) {
            return View::make('admin/galleries.upload')
                ->with('gallery', $gallery);
        } else {
            return "Error";
        }
    }

    public function post_upload($galleryID)
    {
        $path = path('public').'images/'.$galleryID;
        Fineuploader::init($path);
        $name = Fineuploader::getName();
        $fuResponse = Fineuploader::upload($name);

        if (isset($fuResponse['success']) && ($fuResponse['success'] == true)) {
            $file = Fineuploader::getUploadName();
            
            Bundle::start('resizer');
            $success = Resizer::open($file)
                ->resize(300, 300, 'landscape')
                ->save($path.'/thumbs/'.$name , 90 );
            
            Images::create($galleryID, $name);
        }

        return Response::json($fuResponse);
    }*/

     /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
     public function getData()
    {
         $blogcategorys = Gallery::select(array('gallery.id', 'gallery.title', 'gallery.id as images_count','gallery.id as comments_count','gallery.created_at'));

        return Datatables::of($blogcategorys)

        ->edit_column('images_count', '<a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/imagesforgallery\' ) }}}" class="btn btn-link btn-xs" >{{ DB::table(\'gallery_images\')->where(\'gallery_id\', \'=\', $id)->count() }}</a>')
        ->edit_column('comments_count', '<a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/commentsforgallery\' ) }}}" class="btn btn-link btn-xs" >{{ DB::table(\'gallery_comments\')->where(\'gallery_id\', \'=\', $id)->count() }}</a>')
       
        ->add_column('actions', '<a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/galleries/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')
        
        ->remove_column('id')
        
        ->make();
    }
	
}
