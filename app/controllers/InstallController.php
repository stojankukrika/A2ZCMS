<?php

class InstallController extends BaseController {

	/**
	 * Create a new API User controller.
	 *
	 * @param UserRepositoryInterface $users
	 *
	 * @internal param UserRepositoryInterface $user
	 * @return InstallController
	 */
	public function __construct() {
		// If the config is marked as installed then bail with a 404.
		if (Config::get("a2zcms.installed") === true) {
			return App::abort(404, 'Page not found');
		}
	}

	/**
	 * Get the install index.
	 *
	 * @return Response
	 */
	public function getIndex() {
		return View::make('install.installer.step1');
	}

	/**
	 * Run the migrations
	 *
	 * @return Response
	 */
	public function postIndex() {
		return Redirect::to('install/step2');
	}

	/**
	 * Get the user form.
	 *
	 * @return Response
	 */
	public function getStep2() {
		return View::make('install.installer.step2');
	}

	/**
	 * Add the user and show success!
	 *
	 * @return Response
	 */
	public function postStep2() {

		$form = Validator::make($input = Input::all(), array('hostname' => array('required'), 'username' => array('required'), 'database' => array('required'), ));

		if ($form -> passes()) {

			$search = array_map(function($key) {
				return '{{' . $key . '}}';

			}, array_keys($input));

			$replace = array_values($input);

			$stub = File::get(__DIR__ . '\..\config\database_temp.php');

			$stub = str_replace($search, $replace, $stub);

			File::put(__DIR__ . '\..\config\/' . App::environment() . '\database.php', $stub);

			/*delete temp file*/

			//File::delete($stub);
			$url = URL::to('/');
			$this -> setA2ZApp($url);

			Artisan::call('key:generate', array('--env' => App::environment()));

			Artisan::call('migrate', array('--env' => App::environment()));

			return Redirect::to('install/step3');
		} else {
			return Redirect::to('install/step2') -> withErrors($form);
		}
	}

	/**
	 * Update the configs based on passed data
	 *
	 * @param string $url
	 *
	 * @return
	 */
	protected function setA2ZApp($url) {
		$content = str_replace('##url##', $url, File::get(__DIR__ . '\..\config\app_temp.php'));
		return File::put(__DIR__ . '\..\config\/' . App::environment() . '\app.php', $content);
	}

	/**
	 * Get the user form.
	 *
	 * @return Response
	 */
	public function getStep3() {
		return View::make('install.installer.step3');
	}

	/**
	 * Add the user and show success!
	 *
	 * @return Response
	 */
	public function postStep3() {

		$rules = array('first_name' => 'required', 'last_name' => 'required', 'username' => 'required', 'email' => 'required', 'password' => 'required', );

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		if (!$validator -> passes()) {
			returnRedirect::back() -> withInput() -> withErrors($validator);
		}

		$user_id = DB::table('users') -> insertGetId(array('name' => Input::get('first_name'), 
								'surname' => Input::get('last_name'), 'username' => Input::get('username'), 
							'email' => Input::get('email'), 'password' => Hash::make(Input::get('password')), 							'confirmation_code' => md5(microtime() . Config::get('app.key')), 
							'created_at' => new DateTime, 'updated_at' => new DateTime, 
							'confirmed' => '1', 'active' => '1'));

		$adminRole = new Role;
		$adminRole -> name = 'admin';
		$adminRole -> save();

		DB::table('assigned_roles') -> insert(array('user_id' => $user_id, 'role_id' => $adminRole -> id));

		Artisan::call('db:seed');

		$settings = Settings::all();
		foreach ($settings as $v) {
			switch ($v->varname) {
				case 'email' :
					$v -> value = Input::get('email');
					break;
			}
			Settings::where('varname', '=', $v -> varname) -> update(array('value' => $v -> value));
		}

		return Redirect::to('install/step4');
	}

	/**
	 * Get the config form.
	 */
	public function getStep4() {
		return View::make('install.installer.step4');
	}

	/**
	 * Save the config files
	 */
	public function postStep4() {
		$this -> setA2ZConfig(Input::get('title', 'Site Name'), Input::get('theme', 'a2z-default'),
								Input::get('per_page', 5));
		return View::make('install.installer.complete');
	}

	/**
	 * Update the configs based on passed data
	 *
	 * @param string $title
	 * @param string $theme
	 * @param int    $per_page
	 *
	 * @return
	 */
	protected function setA2ZConfig($title, $theme, $per_page) {
		$content = str_replace(array('##theme##', "'##installed##'"), array($theme, 'true'), 
		File::get(__DIR__ . '\..\config\a2zcms_temp.php'));

		$settings = Settings::all();
		foreach ($settings as $v) {

			switch ($v->varname) {
				case 'title' :
					$v -> value = $title;
					break;
				case 'pageitem' :
					$v -> value = $per_page;
					break;
				case 'sitetheme' :
					$v -> value = $theme;
					break;
			}
			Settings::where('varname', '=', $v -> varname) -> update(array('value' => $v -> value));
		}

		return File::put(__DIR__ . '\..\config\a2zcms.php', $content);
	}

}
