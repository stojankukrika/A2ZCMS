<?php

class AdminGalleryImagesController extends AdminController {

 /**
     * Comment Model
     * @var Comment
     */
    protected $gallery_image;

    /**
     * Inject the models.
     * @param Comment $comment
     */
    public function __construct(GalleryImage $gallery_image)
    {
        parent::__construct();
        $this->gallery_image = $gallery_image;
    }
	  /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/galleryimages/title.gallery_management');

      // Gallery category
		$galleries = Gallery::all();
		
		$options = array();
		
		$options[0]=Lang::get('admin/galleryimages/title.gallery_choose');
		
		foreach ($galleries as $gallery)
		{
		     $options[$gallery->id] = $gallery->title;
		}
		
        // Show the page
        return View::make('admin/galleryimages/index', compact('options', 'galleries','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $blog
     * @return Response
     */
    public function getDelete($gallery_image)
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
        	$id = $gallery_image->id;
			$gallery = Gallery::find($id);
			
			File::delete(base_path().'\public\images\/'.$gallery->folderid.'\/'.$gallery_image->content);
        	File::delete(base_path().'\public\images\/'.$gallery->folderid.'\/thumbs\/'.$gallery_image->content);
				
			
			$gallery_image->delete();

            // Was the blog post deleted?
            $gallery_image = GalleryImage::find($id);
            if(empty($gallery_image))
            {            	
                // Redirect to the blog posts management page
                return Redirect::to('admin/galleryimages')->with('success', Lang::get('admin/galleries/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/galleryimages')->with('error', Lang::get('admin/galleries/messages.delete.error'));
    }
	
    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getImageforgallery($galleryid)
	{
        $images = GalleryImage::join('gallery', 'gallery.id', '=', 'gallery_images.gallery_id')
        ->select(array('gallery_images.id', 'gallery_images.content','gallery.folderid', 
        'gallery_images.views','gallery_images.likes','gallery_images.created_at'))
		->where('gallery_id','=',$galleryid);

        return Datatables::of($images)
		       ->make();
	}
}
