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
		
		// Check if the blog page exists
		if (is_null($page)) {
			// If we ended up in here, it means that a page didn't exist.
			// So, this means that it is time for 404 error page.
			return App::abort(404);
		}
		$pagecontent = BaseController::createSiderContent($navigation_link->page_id);
		// Show the page
		$data['sidebar_right'] = $pagecontent['sidebar_right'];
		$data['sidebar_left'] = $pagecontent['sidebar_left'];
		$data['content'] = $pagecontent['content'];
		$data['page'] = $page;
		return View::make('site/page/view_page', $data);
	}
	 
	 
}
