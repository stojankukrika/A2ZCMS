<?php

class WebsiteController extends BaseController {	
 
 	/**
	 * Page Model
	 * @var Page
	 */
	protected $page;
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
	public function __construct(Page $page, Settings $settings) {
		parent::__construct();
		$this -> page = $page;
		$settings = Settings::all();
		$this -> settings = $settings;

	}	

	public function getView($slug=0) {
		if($slug==0) $slug = 1;
		// Get this webpage data
		$navigation_link = Navigation::where('id', '=', $slug) -> first();
		$page = $this -> page -> where('id', '=', $navigation_link->page_id) -> first();
		
		$page_functions = $this->readModulsForPage($navigation_link->page_id);
		
		$function_content = $page_functions['pluginfunction_content'];
		$function_slider = $page_functions['pluginfunction_slider'];
		

		$sidebar_right = array(); 
		$sidebar_left = array(); 
		$content = array();		
		
		foreach ($function_slider as $item)
		{
			$function = $item->function;
			$params = $item->params;
			if($page->sidebar==1){
				$sidebar_right[] = array('content' =>$this->$function($params));
			}
			if($page->sidebar==2){
				$sidebar_left[] = array('content' =>$this->$function($params));
			}
		}
		
		foreach ($function_content as $item)
		{
			$function = $item->function;
			$ids = $item->ids;
			$grids = $item->grids;
			$sorts = $item->sorts;
			$limits = $item->limits;
			$orders = $item->orders;
			//echo 'f:'.$function.' i:'.$ids.' g:'.$grids.' s:'.$sorts.' l:'.$limits.' o:'.$orders.'<br>'.$item->params.'<br><br>';
			if($item->params=="")
			{
				$content[] = array('content' =>$this->$function($page->id));
			}
			else {
				$content[] = array('content' =>$this->$function($ids,$grids,$sorts,$limits,$orders));
			}
		}	
		// Check if the blog page exists
		if (is_null($page)) {
			// If we ended up in here, it means that a page didn't exist.
			// So, this means that it is time for 404 error page.
			return App::abort(404);
		}
		// Show the page
		return View::make('site/page/view_page', compact('page','sidebar_right','content','sidebar_left'));
	}
	
	
	/* public function getContactus()
	{
		return View::make('site/contact_us', compact('page'));
	}
	public function postContactus()
	{
		return View::make('site/contact_us', compact('page'));
	}*/
	
	public function readModulsForPage($page_id = 0)
	{
		if($page_id==0){
			$page_id = 1;
		}
		$pluginfunction_content = PluginFunction::leftJoin('plugins', 'plugins.id', '=', 'plugin_functions.plugin_id') 
									->leftJoin('page_plugin_functions','plugin_functions.id','=','page_plugin_functions.plugin_function_id')
									->whereRaw("page_plugin_functions.page_id  = '".$page_id."'")
									->where('plugin_functions.type','=','content')
									->whereRaw('page_plugin_functions.deleted_at IS NULL')
									->orderBy('page_plugin_functions.order','ASC')
									->groupBy('plugin_functions.id')
									->get(array(
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL)and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="id" limit 1) AS ids')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL)and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="grid" limit 1) AS grids')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL)and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="sort" limit 1) AS sorts')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL)and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="limit" limit 1) AS limits')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL)and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="order" limit 1) AS orders')),
									'plugin_functions.title','page_plugin_functions.order','plugins.function_id','plugin_functions.function','plugin_functions.params','plugins.function_grid'));

			$pluginfunction_slider = PluginFunction::leftJoin('page_plugin_functions','plugin_functions.id','=','page_plugin_functions.plugin_function_id')
								->whereRaw("page_plugin_functions.page_id  = '".$page_id."'")
								->where('plugin_functions.type','=','sidebar')
								->whereRaw('page_plugin_functions.deleted_at IS NULL')
								->orderBy('page_plugin_functions.order','ASC')
								->groupBy('plugin_functions.id')
								->get(array('plugin_functions.id','plugin_functions.title','plugin_functions.params','plugin_functions.function','page_plugin_functions.order'));
		
		return $arrayName = array('pluginfunction_content' => $pluginfunction_content, 'pluginfunction_slider' => $pluginfunction_slider);
	}
	
	/*
	 * sidebar function
	 * */
	public function login()
	{
		return View::make('site.partial_views.sidebar.login');
	}
	public function search()
	{
		return View::make('site.partial_views.sidebar.search');
	}
	public function newGallerys($params)
	{
		$param = $this->splitParams($params);
		$gallery = Gallery::orderBy($param['order'],$param['sort'])->take($param['limit'])->select(array('id','title'))->get();
		return View::make('site.partial_views.sidebar.newgallerys', compact('newGallerys'));
	}
	public function newBlogs($params)
	{
		$param = $this->splitParams($params);
		$blogs = Blog::orderBy($param['order'],$param['sort'])->take($param['limit'])->select(array('id','title'))->get();
		return View::make('site.partial_views.sidebar.newblogs', compact('newBlogs'));
	}
	
	private function splitParams($params)
	{
		$return = array();
		$params = explode(';', $params);
		foreach ($params as $param) {
			if($param!=""){
				$param = explode(':', $param);
				$return[$param[0]] = $param[1];
				}
			}
		return $return;	
	}
	 
	 /*
	 * content function
	 * */
	 
	public function content($page_id)
	{
		$page = Page::find($page_id);
		return View::make('site.partial_views.content.content', compact('page'));
	}
	public function showGallery($ids="",$grids="",$sorts,$limits,$orders)
	{
		$showGallery ="";
		$showImages ="";
		if($ids!="" && $grids==""){
			$showGallery = Gallery::whereIn('id', $ids)->orderBy($orders,$sorts)->select(array('id','title'))->get();
			$showImages = GalleryImage::whereIn('gallery_id', $ids)->select(array('id','content'))->get();
		}
		else {
			$showGallery = Gallery::orderBy($orders,$sorts)->take($limits)->select(array('id','title'))->get();
		}
		return View::make('site.partial_views.content.showGallery', compact('showGallery','showImages'));
	}
	public function showBlogs($ids,$grids,$sorts,$limits,$orders)
	{
		$showBlogs ="";
		//$ids = rtrim($ids, ",");
	
		if($ids!="" && $grids==""){
			$showBlogs = Blog::whereIn('id', array($ids))->orderBy($orders,$sorts)->select(array('id','slug','title','content'))->get();
		}
		else {
			$showBlogs = Blog::orderBy($orders,$sorts)->take($limits)->select(array('id','slug','title','content'))->get();
		}
		return View::make('site.partial_views.content.showBlogs', compact('showBlogs'));
	}
	public function showCustomFormId($ids,$grids,$sorts,$limits,$orders)
 	{

	 }
	  /*
	 * end site function
	 * */
}
