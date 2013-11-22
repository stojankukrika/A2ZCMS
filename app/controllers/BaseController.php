<?php

class BaseController extends Controller {

	/**
	 * User Model
	 * @var User
	 */
	protected $user;
	/**
	 * Initializer.
	 *
	 * @access   public
	 * @return \BaseController
	 */

	public function __construct() {
		$user = new User;
		$this -> user = $user;
		$this -> beforeFilter('csrf', array('on' => 'post'));
		$this -> beforeFilter('detectLang');
		// Redirect to /install if the db isn't setup.
		if (Config::get("a2zcms.installed") !== true) {
			header('Location: install');
			exit ;
		}
		$settings = Settings::all();
		
		$offline = 0;
		foreach ($settings as $v) {
			if ($v -> varname == 'offline') {
				$offline = $v -> value;
				View::share('key', 'value');
			}
			if ($v -> varname == 'metadesc') {
				View::share('metadesc',  $v -> value);
			}
			if ($v -> varname == 'metakey') {
				View::share('metakey', $v -> value);
			}
			if ($v -> varname == 'metaauthor') {
				View::share('metaauthor',  $v -> value);
			}
			if ($v -> varname == 'title') {
				View::share('title',  $v -> value);
			}
			if ($v -> varname == 'copyright') {
				View::share('copyright',  $v -> value);
			}
			if ($v -> varname == 'analytics') {
				View::share('analytics',  $v -> value);
			}	
			if ($v -> varname == 'dateformat') {
				View::share('dateformat',  $v -> value);
			}
			if ($v -> varname == 'timeformat') {
				View::share('timeformat',  $v -> value);
			}	
			if ($v -> varname == 'searchcode') {
				View::share('searchcode',  $v -> value);
			}					
			
		}
		if($offline==1)
		{
			header('Location: '. Config::get("app.url").'offline');
			exit ;
		}
		$user = Auth::user();
		if(!empty($user)){
			$unreadmessages = Messages::where('user_id_to','=',$user->id)->where('read','=','0')->count();
			View::share('unreadmessages',  $unreadmessages);
		}
		$top_navigation = $this->main_menu('top');
		if(!empty($top_navigation)){
			View::share('top_menu',  $top_navigation);
		}
		
		$footer_navigation = $this->main_menu('footer');
		if(!empty($footer_navigation)){
			View::share('footer_menu',  $footer_navigation);
		}
		
		$side_navigation = $this->main_menu('side');
		if(!empty($side_navigation)){
			View::share('side_menu',  $side_navigation);
		}
			
		
	}
	/* Attempt to do login
	 *
	 */
	public function postLogin() {
		$input = array('email' => Input::get('email'), // May be the username too
		'username' => Input::get('email'), // May be the username too
		'password' => Input::get('password'), 'remember' => Input::get('remember'), );

		// If you wish to only allow login from confirmed users, call logAttempt
		// with the second parameter as true.
		// logAttempt will check if the 'email' perhaps is the username.
		// Check that the user is confirmed.
		if (Confide::logAttempt($input, true)) {
			$r = Session::get('loginRedirect');
			if (!empty($r)) {
				Session::forget('loginRedirect');
				return Redirect::to($r);
			}
			return Redirect::back();
		} else {
			// Check if there was too many login attempts
			if (Confide::isThrottled($input)) {
				$err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
			} elseif ($this -> user -> checkUserExists($input) && !$this -> user -> isConfirmed($input)) {
				$err_msg = Lang::get('confide::confide.alerts.not_confirmed');
			} else {
				$err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
			}

			return Redirect::back() -> withInput(Input::except('password')) -> with('error', $err_msg);
		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {
		if (!is_null($this -> layout)) {
			$this -> layout = View::make($this -> layout);
		}
	}

	public function main_menu($type) {
		$navigation ="";
		switch ($type) {
			case 'top':
				$navigation = NavigationGroup::join('navigation_links','navigation_groups.id', '=', 'navigation_links.navigation_group_id')
										->where('navigation_groups.showmenu','=','1') 
										-> select('navigation_links.id', 'navigation_links.title', 'navigation_links.parent', 'navigation_links.link_type', 'navigation_links.target', 'navigation_links.position','navigation_links.class') 
										-> get();
				break;
			case 'footer':
				$navigation =NavigationGroup::join('navigation_links','navigation_groups.id', '=', 'navigation_links.navigation_group_id')
										->where('navigation_groups.showfooter','=','1') 
										-> select('navigation_links.id', 'navigation_links.title', 'navigation_links.parent', 'navigation_links.link_type', 'navigation_links.target', 'navigation_links.position','navigation_links.class') 
										-> get();
				break;
			case 'side':
				$navigation = NavigationGroup::join('navigation_links','navigation_groups.id', '=', 'navigation_links.navigation_group_id')
										->where('navigation_groups.showsidebar','=','1') 
										-> select('navigation_links.id', 'navigation_links.title', 'navigation_links.parent', 'navigation_links.link_type', 'navigation_links.target', 'navigation_links.position','navigation_links.class') 
										-> get();
				break;
		}		
		
		$menu = array('items' => array(), 'parents' => array());
		// Builds the array lists with data from the menu table
		foreach ($navigation as $key => $items) {
			
			// Creates entry into items array with current menu item id ie. $menu['items'][1]
			$menu['items'][$items['id']] = $items;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$items['parent'] = (is_null($items['parent'])) ? 0 : $items['parent'];
			$menu['parents'][$items['parent']][] = $items['id'];
		}
		return $this -> buildMenu(0, $menu);
	}

	// Menu builder function, parentId 0 is the root
	public function buildMenu($parent, $menu) {
		$html = '';
		if (isset($menu['parents'][$parent])) {
			foreach ($menu['parents'][$parent] as $itemId) {
				if (!isset($menu['parents'][$itemId])) {
					$html .= "<li> <a class='".$menu['items'][$itemId]['class']."' href='".URL::to('page') ."/". $menu['items'][$itemId]['id'] . "'>" . $menu['items'][$itemId]['title'] . "</a></li>";
				}
				if (isset($menu['parents'][$itemId])) {
					$html .= "<li class='dropdown'> <a class='dropdown-toggle ".$menu['items'][$itemId]['class']."' href='".URL::to('page') ."/". $menu['items'][$itemId]['id'] . "'>" . $menu['items'][$itemId]['title'] . "</a>
						<ul class='dropdown-menu'>";
					$html .= $this -> buildMenu($itemId, $menu);
					$html .= " </ul></li>";
				}
			}
		}
		return $html;
	}
/*function for moduls and custom forms to shows in webpage*/
	public function createSiderContent($page_id=0)
	{
		
		if($page_id==0) {
			$page_id = Page::first()->id;
		}
		$page = Page::find($page_id);
		
		$page_functions = $this->readModulsForPage($page_id);
		
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
			
			if($item->params=="")
			{
				$content[] = array('content' =>$this->$function($page_id));
			}
			else {
				$content[] = array('content' =>$this->$function($ids,$grids,$sorts,$limits,$orders));
			}
		}
		return $pagecontent = array('sidebar_right' => $sidebar_right, 'sidebar_left'=>$sidebar_left, 'content'=>$content);	
	}
	public function readModulsForPage($page_id)
	{
		$pluginfunction_content = PluginFunction::leftJoin('plugins', 'plugins.id', '=', 'plugin_functions.plugin_id') 
									->leftJoin('page_plugin_functions','plugin_functions.id','=','page_plugin_functions.plugin_function_id')
									->whereRaw("(page_plugin_functions.page_id  = '".$page_id."' OR page_plugin_functions.page_id IS NULL)")
									->where('plugin_functions.type','=','content')
									->whereRaw('page_plugin_functions.deleted_at IS NULL')
									->orderBy('page_plugin_functions.order','ASC')
									->groupBy('plugin_functions.id')
									->get(array(
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL) and page_plugin_functions.deleted_at IS NULL and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="id" limit 1) AS ids')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL) and page_plugin_functions.deleted_at IS NULL and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="grid" limit 1) AS grids')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL) and page_plugin_functions.deleted_at IS NULL and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="sort" limit 1) AS sorts')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL) and page_plugin_functions.deleted_at IS NULL and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="limit" limit 1) AS limits')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE (page_plugin_functions.page_id  = '.$page_id.' OR page_plugin_functions.page_id IS NULL) and page_plugin_functions.deleted_at IS NULL and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="order" limit 1) AS orders')),
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
	public function login($params)
	{
		return View::make('site.partial_views.sidebar.login');
	}
	public function sideMenu($params)
	{
		return View::make('site.partial_views.sidebar.sideMenu');
	}
	public function search($params)
	{
		return View::make('site.partial_views.sidebar.search');
	}
	public function newGallerys($params)
	{
		$param = $this->splitParams($params);
		$newGallerys = Gallery::orderBy($param['order'],$param['sort'])->take($param['limit'])->select(array('id','title'))->get();
		return View::make('site.partial_views.sidebar.newGallerys', compact('newGallerys'));
	}
	public function newBlogs($params)
	{
		$param = $this->splitParams($params);
		$newBlogs = Blog::orderBy($param['order'],$param['sort'])->take($param['limit'])->select(array('id','title','slug'))->get();
		return View::make('site.partial_views.sidebar.newBlogs', compact('newBlogs'));
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
		$showGallery =array();
		$showImages =array();
			
		if($ids!="" && $grids==""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			$showGallery = Gallery::whereIn('id', $ids)->orderBy($orders,$sorts)->select(array('id','title','folderid'))->get();
			foreach ($ids as $value) {
				$showImages[$value] = GalleryImage::where('gallery_id', $value)->select(array('id','content'))->get();
			}
			
		}
		else if($limits!=0)
		{
			$showGallery = Gallery::orderBy($orders,$sorts)->take($limits)->select(array('id','title','folderid'))->get();
		}
		return View::make('site.partial_views.content.showGallery', compact('showGallery','showImages'));
	}

	public function showBlogs($ids,$grids,$sorts,$limits,$orders)
	{
		$showBlogs = array();
		$ids = rtrim($ids, ",");

		if($ids!="" && $grids==""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			
			$showBlogs = Blog::whereIn('id', $ids)->orderBy($orders,$sorts)->select(array('id','slug','title','content'))->get();
		}
		else if($limits!=0) {
			$showBlogs = Blog::orderBy($orders,$sorts)->take($limits)->select(array('id','slug','title','content'))->get();
		}
		return View::make('site.partial_views.content.showBlogs', compact('showBlogs'));
	}
	public function showCustomFormId($ids,$grids,$sorts,$limits,$orders)
 	{
 		
		$showCustomFormId ="";
		$showCustomFormFildId ="";
		$ids = rtrim($ids, ",");

		if($ids!=""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			$showCustomFormId = CustomForm::whereIn('id', $ids)->select(array('id','recievers','title','message'))->get();
			foreach ($ids as $id){
				$showCustomFormFildId[$id] = CustomFormField::where('custom_form_id',$id)->orderBy('order','ASC')->select(array('id','name','options','type','order','mandatory'))->get();
			}
		}
		return View::make('site.partial_views.content.showCustomFormId', compact('showCustomFormId','showCustomFormFildId'));
	 }
	  /*
	 * end site function
	 * */

}
