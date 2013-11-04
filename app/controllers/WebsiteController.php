<?php

class WebsiteController extends BaseController {	
 
 	/**
	 * Page Model
	 * @var Page
	 */
	protected $page;
		
	public function __construct(Page $page, Settings $settings) {
		parent::__construct();
		$this -> page = $page;
		$this -> navigation = parent::main_menu();
		$settings = Settings::all();
		$this -> settings = $settings;

	}	

	public function getView($slug) {
		// Get this webpage data
		$page = $this -> page -> where('id', '=', $slug) -> first();

		// Check if the blog blog exists
		if (is_null($page)) {
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
		$menu = $this -> navigation;
		// Show the page
		return View::make('site/page/view_page', compact('page', 'menu'));
	}
	public function getOffline()
	{
		$settings = Settings::all();
		$offline_msg = '<br>';
		foreach ($settings as $v) {
			if ($v -> varname == 'offline_msg') {
				$offline_msg = $v -> value;
			}
		}
		return View::make('site/offline')->with('offline_msg', $offline_msg);
	}
}
