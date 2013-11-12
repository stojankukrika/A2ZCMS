<?php

class AdminPagesController extends AdminController {

	/**
	 * Page Repository
	 *
	 * @var Page
	 */
	protected $page;

	//public $restful = true;

	public function __construct(Page $page) {
		parent::__construct();
		$this -> page = $page;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {

		$title = Lang::get('admin/pages/title.page_management');

		$pages = Page::all();

		return View::make('admin/pages/index', compact('title', 'pages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// Title
		$title = Lang::get('admin/pages/title.create_a_new_page');
		
		$pluginfunction_content = PluginFunction::leftJoin('plugins', 'plugins.id', '=', 'plugin_functions.plugin_id') 
		->where('type','=','content')
		->get(array('plugin_functions.id','plugin_functions.title','plugin_functions.params','plugins.function_id','plugins.function_grid'));
		$pluginfunction_slider = PluginFunction::where('type','=','sidebar')->get();
		
		foreach ($pluginfunction_content as $key => $value) {
			$function_id = $value['function_id'];
			$function_grid = $value['function_grid'];
			if($function_id!=NULL){
				$value['function_id'] = $this->$function_id();
			}
			if($function_grid!=NULL){
				$value['function_grid'] = $this->$function_grid();
			}
		}
		
		// Show the page
		return View::make('admin/pages/create_edit', compact('title','pluginfunction_content','pluginfunction_slider'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('name' => 'required|min:3', 'content' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Create a new blog post
			$this -> page -> name = Input::get('name');
			$this -> page -> slug = Str::slug(Input::get('name'));
			$this -> page -> content = Input::get('content');
			$this -> page -> status = Input::get('status');
			$this -> page -> meta_title = Input::get('meta_title');
			$this -> page -> meta_description = Input::get('meta_description');
			$this -> page -> meta_keywords = Input::get('meta_keywords');
			$this -> page -> page_css = Input::get('page_css');
			$this -> page -> page_javascript = Input::get('page_javascript');
			$this -> page -> sidebar = Input::get('sidebar');
			$this -> page -> showtitle = Input::get('showtitle');
			$this -> page -> showvote = Input::get('showvote');
			$this -> page -> password = Input::get('password');
			$this -> page -> showdate = Input::get('showdate');
			
			$this -> page -> save();
			
			$pagesidebar = (Input::has('pagesidebar'))?Input::get('pagesidebar'):"";
			$pagecontentorder = Input::get('pagecontentorder');
			$pagecontent = Input::get('pagecontent');
			$this->saveData($pagesidebar,$pagecontentorder, $pagecontent,$this -> page -> id);
		}

		// Form validation failed
		return Redirect::to('admin/pages/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $page
	 * @return Response
	 */
	public function getEdit($id) {
		if ($id) {
			// Title
			$title = Lang::get('admin/pages/title.page_update');
			
			$page = Page::find($id);
				
			$pluginfunction_content = PluginFunction::leftJoin('plugins', 'plugins.id', '=', 'plugin_functions.plugin_id') 
									->leftJoin('page_plugin_functions','plugin_functions.id','=','page_plugin_functions.plugin_function_id')
									->whereRaw("page_plugin_functions.page_id  = '".$page->id."'")
									->where('plugin_functions.type','=','content')
									->whereRaw('page_plugin_functions.deleted_at IS NULL')
									->orderBy('page_plugin_functions.order','ASC')
									->groupBy('page_plugin_functions.order')
									->get(array('plugin_functions.id',
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE page_plugin_functions.page_id  = '.$page->id.' and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="id" limit 1) AS ids')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE page_plugin_functions.page_id  = '.$page->id.' and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="grid" limit 1) AS grids')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE page_plugin_functions.page_id  = '.$page->id.' and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="sort" limit 1) AS sorts')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE page_plugin_functions.page_id  = '.$page->id.' and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="limit" limit 1) AS limits')),
									(DB::raw('(SELECT value AS value FROM page_plugin_functions WHERE page_plugin_functions.page_id  = '.$page->id.' and plugin_functions.id=page_plugin_functions.plugin_function_id AND param="order" limit 1) AS orders')),
									'plugin_functions.title','page_plugin_functions.order','plugins.function_id','plugin_functions.params','plugins.function_grid'));
		
			foreach ($pluginfunction_content as $key => $value) {
				$function_id = $value['function_id'];
				$function_grid = $value['function_grid'];
				if($function_id!=NULL){
					$value['function_id'] = $this->$function_id();
				}
				if($function_grid!=NULL){
					$value['function_grid'] = $this->$function_grid();
				}
			}

			$pluginfunction_slider = PluginFunction::leftJoin('page_plugin_functions','plugin_functions.id','=','page_plugin_functions.plugin_function_id')
								->whereRaw("(page_plugin_functions.page_id  = '".$page->id."' OR page_plugin_functions.page_id IS NULL)")
								->where('plugin_functions.type','=','sidebar')
								->whereRaw('page_plugin_functions.deleted_at IS NULL')
								->orderBy('page_plugin_functions.order','ASC')
								->groupBy('page_plugin_functions.order')
								->get(array('plugin_functions.id','plugin_functions.title','page_plugin_functions.order'));

			return View::make('admin/pages/create_edit', compact('page', 'title', 'pluginfunction_content','pluginfunction_slider'));
		} else {
			return Redirect::to('admin/pages') -> with('error', Lang::get('admin/users/messages.does_not_exist'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $page
	 * @return Response
	 */
	public function postEdit($id) {
		// Declare the rules for the form validation
		$rules = array('name' => 'required|min:3', 'content' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		$page = Page::find($id);

		$inputs = Input::all();

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Was the page updated?
			
			$page -> name = Input::get('name');
			$page -> slug = Str::slug(Input::get('name'));
			$page -> content = Input::get('content');
			$page -> status = Input::get('status');
			$page -> meta_title = Input::get('meta_title');
			$page -> meta_description = Input::get('meta_description');
			$page -> meta_keywords = Input::get('meta_keywords');
			$page -> page_css = Input::get('page_css');
			$page -> page_javascript = Input::get('page_javascript');
			$page -> sidebar = Input::get('sidebar');
			$page -> showtitle = Input::get('showtitle');
			$page -> showvote = Input::get('showvote');
			$page -> password = Input::get('password');
			$page -> showdate = Input::get('showdate');
			
			if ($page -> save()) {
				
				$old = PagePluginFunction::where('page_id','=',$page -> id);
				$old->delete();
				
				$pagesidebar = (Input::has('pagesidebar'))?Input::get('pagesidebar'):"";
				$pagecontentorder = Input::get('pagecontentorder');
				$pagecontent = Input::get('pagecontent');
				$this->saveData($pagesidebar,$pagecontentorder, $pagecontent,$page -> id);
				// Redirect to the page page
				return Redirect::to('admin/pages/' . $page -> id . '/edit') -> with('success', Lang::get('admin/pages/messages.update.success'));
			} else {
				// Redirect to the page page
				return Redirect::to('admin/pages/' . $page -> id . '/edit') -> with('error', Lang::get('admin/pages/messages.update.error'));
			}
		}

		// Form validation failed
		return Redirect::to('admin/pages/' . $page -> id . '/edit') -> withInput() -> withErrors($validator);
	}

	public function saveData($pagesidebar="",$pagecontentorder,$pagecontent,$page_id)
	{
		if($pagesidebar!=""){
				$order = 1;
				foreach ($pagesidebar as $value) {
					$params = PluginFunction::find($value)->params;
					if($params!=NULL){
						$params = explode(';', $params);
						foreach ($params as $param) {
							if($param!=""){
								$param = explode(':', $param);
								$pagepluginfunction = new PagePluginFunction;
								$pagepluginfunction -> plugin_function_id = $value;
								$pagepluginfunction -> order = $order;
								$pagepluginfunction -> param = $param['0'];
								if(strstr($param['1'], ',')){
									$pagepluginfunction -> type = 'array';
								}
								else if(is_int($param['1'])){
									$pagepluginfunction -> type = 'int';
								}
								else {
									$pagepluginfunction -> type = 'string';
								}
								$pagepluginfunction -> value = $param['1'];
								$pagepluginfunction -> page_id = $page_id;
								$pagepluginfunction -> save();
							}
						}
					}	
				else {
						$pagepluginfunction = new PagePluginFunction;
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order;
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> save();
					}				
					$order ++;
				}
			}
			$order2 = 1;
			$items = explode(',', $pagecontentorder);
				foreach ($items as $value) {
					$params = "";
					if(!empty($pagecontent[$value]['id'])){
						foreach ($pagecontent[$value]['id'] as $value2) {
							$params .= $value2.",";
						}
						$pagepluginfunction = new PagePluginFunction;
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'id';
						$pagepluginfunction -> type = 'array';
						$pagepluginfunction -> value = $params;
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> save();
												
					}
					if(!empty($pagecontent[$value]['grid'])){
						foreach ($pagecontent[$value]['grid'] as $value2) {
							$params .= $value2.",";
						}
						$pagepluginfunction = new PagePluginFunction;
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'grid';
						$pagepluginfunction -> type = 'array';
						$pagepluginfunction -> value = $params;
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> save();
					}
					if(isset($pagecontent[$value]['sort'])){
						$pagepluginfunction = new PagePluginFunction;
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'sort';
						$pagepluginfunction -> type = 'string';
						$pagepluginfunction -> value = $pagecontent[$value]['sort'];
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> save();
					}
					if(isset($pagecontent[$value]['order'])){
						$pagepluginfunction = new PagePluginFunction;
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'order';
						$pagepluginfunction -> type = 'string';
						$pagepluginfunction -> value = $pagecontent[$value]['order'];
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> save();
					}
					if(isset($pagecontent[$value]['limit'])){
						$pagepluginfunction = new PagePluginFunction;
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'limit';
						$pagepluginfunction -> type = 'int';
						$pagepluginfunction -> value = $pagecontent[$value]['limit'];
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> save();
					}
					if(empty($pagecontent[$value]['id']) && empty($pagecontent[$value]['grid']) && 
						!isset($pagecontent[$value]['sort']) && !isset($pagecontent[$value]['order']) &&
						!isset($pagecontent[$value]['limit']))
						{
							$pagepluginfunction = new PagePluginFunction;
							$pagepluginfunction -> plugin_function_id = $value;
							$pagepluginfunction -> order = $order2;
							$pagepluginfunction -> param = '';
							$pagepluginfunction -> type = '';
							$pagepluginfunction -> value = '';
							$pagepluginfunction -> page_id = $page_id;
							$pagepluginfunction -> save();
						}
					
					$order2 ++;
				}
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param $role
	 * @internal param $id
	 * @return Response
	 */
	public function getDelete($id) {
		//echo $pageId;exit;
		$page = Page::find($id);
		// Was the role deleted?
		if ($page -> delete()) {
			// Redirect to the role management page
			return Redirect::to('admin/pages') -> with('success', Lang::get('admin/pages/messages.delete.success'));
		}

		// There was a problem deleting the role
		return Redirect::to('admin/pages') -> with('error', Lang::get('admin/pages/messages.delete.error'));
	}

	public function getVisible($id)
	{
		//echo $pageId;exit;
		$page = Page::find($id);
		// Was the role deleted?
		$page -> status = ($page -> status + 1) % 2;
		$page -> save();	

		// There was a problem deleting the role
		return Redirect::to('admin/pages');
		
	}
	/**
	 * Show a list of all the pages formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$pages = Page::select(array('pages.id', 'pages.name', 'pages.status','pages.voteup','pages.votedown','hits'));

		return Datatables::of($pages) 
			-> edit_column('voteup', '{{ $voteup-$votedown }}') 
			-> edit_column('status', '{{($status)? "<i class=\"icon-eye-open\"></i>":"<i class=\"icon-eye-close\"></i>";}}') 
			-> add_column('actions', '<a href="{{{ URL::to(\'admin/pages/\' . $id . \'/visible\' ) }}}" class="btn btn-link btn-sm"><i class="icon-exchange "></i></a>
							<a href="{{{ URL::to(\'admin/pages/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-sm"><i class="icon-edit "></i></a>
                            <a href="{{{ URL::to(\'admin/pages/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>') 
            -> remove_column('id') 
			-> remove_column('votedown') 
            -> make();
	}
	
	/*function for plugins*/
	public function getBlogId(){
		return Blog::get(array('id','title'));
	}
	
	public function getBlogGroupId(){
		return BlogCategory::get(array('id','title'));
	}
	
	public function getGalleryId(){
		return Gallery::get(array('id','title'));
	}

}
