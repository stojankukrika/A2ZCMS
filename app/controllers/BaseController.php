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
			header('Location: '. Config::get("app.url").'install');
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
		$navigation = $this->main_menu();
		if(!empty($navigation)){
			View::share('menu',  $navigation);
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

	public function main_menu() {
		$navigation = Navigation::select('id', 'title', 'parent', 'link_type', 'target', 'position') -> get();

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
					$html .= "<li> <a href='".URL::to('page') ."/". $menu['items'][$itemId]['id'] . "'>" . $menu['items'][$itemId]['title'] . "</a></li>";
				}
				if (isset($menu['parents'][$itemId])) {
					$html .= "<li class='dropdown'> <a class='dropdown-toggle' href='".URL::to('page') ."/". $menu['items'][$itemId]['id'] . "'>" . $menu['items'][$itemId]['title'] . "</a>
						<ul class='dropdown-menu'>";
					$html .= $this -> buildMenu($itemId, $menu);
					$html .= " </ul></li>";
				}
			}
		}
		return $html;
	}

}
