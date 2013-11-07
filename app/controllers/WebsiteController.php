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
		// Show the page
		return View::make('site/page/view_page', compact('page'));
	}
	public function getContactus()
	{
		return View::make('site/contact_us', compact('page'));
	}
	public function postContactus()
	{
		return View::make('site/contact_us', compact('page'));
	}
}
