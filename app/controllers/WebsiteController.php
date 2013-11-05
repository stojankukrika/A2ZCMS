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
	protected $navigation;
		
	public function __construct(Page $page, Settings $settings) {
		parent::__construct();
		$this -> page = $page;
		$this -> navigation = parent::main_menu();
		$settings = Settings::all();
		$this -> settings = $settings;

	}	

	public function getView($slug) {
		// Get this webpage data
		$navigation_link = Navigation::where('id', '=', $slug) -> first();
		$page = $this -> page -> where('id', '=', $navigation_link->page_id) -> first();

		// Check if the blog page exists
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
}
