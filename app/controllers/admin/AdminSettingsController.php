<?php

class AdminSettingsController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $settings;
	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Settings $settings) {
		parent::__construct();
		$this -> settings = $settings;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {
		// Title
		$title = Lang::get('admin/settings/title.settings_menagement');

		//load settings from database
		$settings = Settings::all();
		// Show the page
		return View::make('admin/settings/index', compact('title', 'settings'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postIndex() {
		// Declare the rules for the form validation
		$rules = array('email' => 'required|email', 'searchcode' => 'required', 'title' => 'required|min:3', 'copyright' => 'required|min:3', 'dateformat' => 'required', 'timeformat' => 'required', 'useravatwidth' => 'required|integer', 'useravatheight' => 'required|integer', 'shortmsg' => 'required|integer', 'pageitem' => 'required|integer');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Update the blog post data
			$email = Input::get('email');
			$title = Input::get('title');
			$copyright = Input::get('copyright');
			$dateformat = Input::get('dateformat');
			$timeformat = Input::get('timeformat');
			$useravatwidth = Input::get('useravatwidth');
			$useravatheight = Input::get('useravatheight');
			$shortmsg = Input::get('shortmsg');
			$pageitem = Input::get('pageitem');
			$analytics = Input::get('analytics');
			$metadesc = Input::get('metadesc');
			$metakey = Input::get('metakey');
			$metaauthor = Input::get('metaauthor');
			$offline = Input::get('offline');
			$offlinemessage = Input::get('offlinemessage');
			$searchcode = Input::get('searchcode');

			//Save settings to database
			$settings = Settings::all();
			foreach ($settings as $v) {

				switch ($v->varname) {
					case 'email' :
						$v -> value = $email;
						break;
					case 'title' :
						$v -> value = $title;
						break;
					case 'copyright' :
						$v -> value = $copyright;
						break;
					case 'dateformat' :
						$v -> value = $dateformat;
						break;
					case 'timeformat' :
						$v -> value = $timeformat;
						break;
					case 'useravatwidth' :
						$v -> value = $useravatwidth;
						break;
					case 'useravatheight' :
						$v -> value = $useravatheight;
						break;
					case 'shortmsg' :
						$v -> value = $shortmsg;
						break;
					case 'pageitem' :
						$v -> value = $pageitem;
						break;
					case 'analytics' :
						$v -> value = $analytics;
						break;
					case 'metadesc' :
						$v -> value = $metadesc;
						break;
					case 'metakey' :
						$v -> value = $metakey;
						break;
					case 'metaauthor' :
						$v -> value = $metaauthor;
						break;
					case 'offline' :
						$v -> value = $offline;
						break;
					case 'offlinemessage' :
						$v -> value = $offlinemessage;
						break;
					case 'searchcode':
						$v -> value = $searchcode;
				}
				Settings::where('varname', '=', $v -> varname) -> update(array('value' => $v -> value));
			}

			// Redirect to the settings page
			return Redirect::to('admin/settings/') -> with('success', Lang::get('admin/settings/messages.success'));
		}

		// Form validation failed
		return Redirect::to('admin/settings/') -> withInput() -> withErrors($validator);
	}

}
