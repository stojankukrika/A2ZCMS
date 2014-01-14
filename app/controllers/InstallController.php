<?php

class InstallController extends BaseController {

	/**
	 * Create a new Install controller.
	 *
	*/
	public function __construct() {
		// If the config is marked as installed then bail with a 404.
		if (Config::get("a2zcms.installed") === true) {
			return Redirect::to('');
		}
	}
	 public $errors = array();
	 
	 /*folder that need to be a writable*/
	 public $writable_dirs = array(
        'avatar' => FALSE,
        'blog' => FALSE,
        'customform' => FALSE,
        'gallery' => FALSE,
        'page' => FALSE,
    );
    public $writable_subdirs = array(
        'blog/thumbs' => FALSE,
        'page/thumbs' => FALSE,
    );

	/**
	 * Get the install index.
	 *
	 * @return Response
	 */
	public function getIndex() {
		return View::make('install.installer.step1');
	}

	/**
	 * Run the chenck if user accept the licence
	 *
	 * @return Response
	 */
	public function postIndex() {
			$form = Validator::make($input = Input::all(), array('accept' => array('required')));

		if ($form -> passes()) {
			return Redirect::to('install/step2');
		} else {
			return Redirect::to('install/index') -> withErrors($form);
		}
	}
	
	/*
	 * Run validate if files and folders are on server and writable 
	 * */
	 
	private function validate()
    {
    	$cms_root = getcwd().'/';		
		
        if ( ! is_writable($cms_root . '../app/config/app.php'))
        {
            $this->errors[] =  $cms_root . '../app/config/app.php is not writable.';
        }

        if ( ! is_writable($cms_root . '../app/config/database.php'))
        {
            $this->errors[] =  $cms_root . '../app/config/database.php is not writable.';
        }
		if ( ! is_writable($cms_root . '../app/config/a2zcms.php'))
        {
            $this->errors[] =  $cms_root . '../app/config/a2zcms.php is not writable.';
        }
		$writable_dirs = array_merge($this->writable_dirs, $this->writable_subdirs);
        foreach ($writable_dirs as $path => $is_writable)
        {
            if(!is_writable($cms_root . $path))
            {
            	$this->errors[] = $cms_root . $path . ' is not writable.';
            }
        }

        if (phpversion() < '5.1.6')
        {
            $this->errors[] = 'You need to use PHP 5.1.6 or greater.';
        }

        if ( ! ini_get('file_uploads'))
        {
            $this->errors[] = 'File uploads need to be enabled in your PHP configuration.';
        }

        if ( ! extension_loaded('mysql'))
        {
            $this->errors[] = 'The PHP MySQL extension is required.';
        }

        if ( ! extension_loaded('gd'))
        {
            $this->errors[] = 'The PHP GD extension is required.';
        }

        if ( ! extension_loaded('curl'))
        {
            $this->errors[] = 'The PHP cURL extension is required.';
        }
        if (empty($this->errors))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	/**
	 * Get the user form to show info of files and folders
	 *
	 * @return Response
	 */
	public function getStep2() {
		clearstatcache();
		$cms_root = getcwd().'/';
		$writable_dirs = array_merge($this->writable_dirs, $this->writable_subdirs);
        foreach ($writable_dirs as $path => $is_writable)
        {
            $this->writable_dirs[$path] = is_writable($cms_root . $path);
        }
		
		$data['writable_dirs'] = $this->writable_dirs;
        $data['cms_root'] = $cms_root;
		return View::make('install.installer.step2',$data);
	}
	/**
	 * Run the validation of writable files and folders
	 *
	 * @return Response
	 */
	public function postStep2() {
		if ($this->validate()) {
			return Redirect::to('install/step3');
		} else {
			return Redirect::to('install/step2') -> withErrors($this->errors);
		}
		
	}

	/**
	 * Get the user form to enter database params.
	 *
	 * @return Response
	 */
	public function getStep3() {
		return View::make('install.installer.step3');
	}

	/**
	 * Add database settings and migrate database
	 *
	 * @return Response
	 */
	public function postStep3() {

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
			$this -> setA2ZApp($url.'/');

			Artisan::call('migrate', array('--env' => App::environment()));
			
			//triger for update user last_login affter user is login to system
			DB::unprepared("CREATE TRIGGER ".Input::get('prefix')."user_login_historys 
							AFTER INSERT ON ".Input::get('prefix')."user_login_historys
							 FOR EACH ROW UPDATE ".Input::get('prefix')."users set ".Input::get('prefix')."users.last_login = 
							(select ".Input::get('prefix')."user_login_historys.created_at 
							 from ".Input::get('prefix')."user_login_historys
							 where ".Input::get('prefix')."user_login_historys.id = NEW.id) 
							WHERE id = (select ".Input::get('prefix')."user_login_historys.user_id 
							 from ".Input::get('prefix')."user_login_historys
							 where ".Input::get('prefix')."user_login_historys.id = NEW.id)");
			
			
			return Redirect::to('install/step4');
		} else {
			return Redirect::to('install/step3') -> withErrors($form);
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
	 * Get the user form for creating admin user.
	 *
	 * @return Response
	 */
	public function getStep4() {
		return View::make('install.installer.step4');
	}

	/**
	 * Add the user as admin
	 *
	 * @return Response
	 */
	public function postStep4() {

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
		$adminRole -> is_admin = 1;
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

		return Redirect::to('install/step5');
	}

	/**
	 * Get the config form.
	 */
	public function getStep5() {
		return View::make('install.installer.step5');
	}

	/**
	 * Save the config files and FINISH install
	 */
	public function postStep5() {
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
