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

			if ($this -> page -> id) {
				// Redirect to the new page
				return Redirect::to('admin/pages/' . $this -> page -> id . '/edit') -> with('success', Lang::get('admin/pages/messages.create.success'));
			} else {
				// Get validation errors (see Ardent package)
				$error = $this -> page -> errors() -> all();

				return Redirect::to('admin/pages/create') -> with('error', $error);
			}
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
			// mode
			$mode = 'edit';
			$page = Page::find($id);
			return View::make('admin/pages/create_edit', compact('page', 'title', 'mode'));
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
			if ($page -> update($inputs)) {
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
