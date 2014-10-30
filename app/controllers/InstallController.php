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
        define('STDIN',fopen("php://stdin","r"));
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
			Artisan::call('migrate',  array('--force' => true));
			
			//triger for update user last_login affter user is login to system
			DB::unprepared("CREATE TRIGGER ".Input::get('prefix')."user_login_historys_after_inserts 
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
			return Redirect::to('install/step4') -> withErrors($form);
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
		$content = str_replace('##url##', $url, File::get(__DIR__ . '\..\config\app.php'));
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

		if (!$validator -> passes() || Input::get('password')!=Input::get('passwordconfirm')) {
			returnRedirect::back() -> withInput() -> withErrors($validator);
		}

		$user_id = DB::table('users') -> insertGetId(array('name' => Input::get('first_name'), 
							'surname' => Input::get('last_name'), 'username' => Input::get('username'), 
							'email' => Input::get('email'), 'password' => Hash::make(Input::get('password')),
							'confirmation_code' => md5(microtime() . Config::get('app.key')), 
							'created_at' => new DateTime, 'updated_at' => new DateTime, 
							'confirmed' => '1', 'active' => '1'));

		$adminRole = new Role;
		$adminRole -> name = 'admin';
		$adminRole -> is_admin = 1;
		$adminRole -> save();

		DB::table('assigned_roles') -> insert(array('user_id' => $user_id, 'role_id' => $adminRole -> id,
											'created_at' => new DateTime, 'updated_at' => new DateTime));

		$this->seed();
		
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
	
	private function seed()
	{
		//PermissionsTableSeeder
		
		$permissions = array( 
						array('name' => 'manage_blogs', 
						'display_name' => 'Manage blogs','is_admin' => 1), 
						array('name' => 'manage_blog_categris', 
						'display_name' => 'Manage blog categris','is_admin' => 1), 
						array('name' => 'manage_comments', 
						'display_name' => 'Manage comments','is_admin' => 1), 
						array('name' => 'manage_users', 
						'display_name' => 'Manage users','is_admin' => 1), 
						array('name' => 'manage_roles', 
						'display_name' => 'Manage roles','is_admin' => 1), 
						array('name' => 'post_blog_comment', 
						'display_name' => 'Post blog comment','is_admin' => 0), 
					);

		DB::table('permissions') -> insert($permissions);

		$permissions = array( array('role_id' => 1, 'permission_id' => 1,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 2,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 3,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 4,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 5,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 6,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), );

		DB::table('permission_role') -> insert($permissions);
		
		//SettingsTableSeeder
		DB::table('settings') -> insert(array( 
											array('varname' => 'updatetime', 
												'groupname' => 'version', 
												'value' => time(), 
												'defaultvalue' => time(),
												'type' =>'text',
												'rule' => ''),
											array('varname' => 'offline', 
												'groupname' => 'offline', 
												'value' => '0', 
												'type' =>'radio',
												'defaultvalue' => '0',
												'rule' => ''),
											array('varname' => 'version', 
												'groupname' => 'version', 
												'value' => '1.0', 
												'defaultvalue' => '1.0',
												'type' =>'text',
												'rule' => ''),
											array('varname' => 'offlinemessage', 
												'groupname' => 'offline', 
												'value' => '<p>Sorry, the site is unavailable at the moment while we are testing some functionality.</p>',
												'defaultvalue' => 'Sorry, the site is unavailable at the moment while we are testing some functionality.',
												'type' =>'textarea',
												'rule' => ''),
											array('varname' => 'title', 
												'groupname' => 'general', 
												'value' => 'A2Z CMS',
												'defaultvalue' => 'A2Z CMS',
												'type' =>'text',
												'rule' => ''),
											array('varname' => 'copyright', 
												'groupname' => 'general', 
												'value' => 'yoursite.com &copy; 2013',
												'defaultvalue' => 'A2Z CMS 2013',
												'type' =>'text',
												'rule' => ''),
											array('varname' => 'metadesc', 
												'groupname' => 'metadata', 
												'value' => '',
												'defaultvalue' => '',
												'type' =>'textarea',
												'rule' => ''),
											array('varname' => 'metakey', 
												'groupname' => 'metadata', 
												'value' => '',
												'defaultvalue' => '',
												'type' =>'textarea',
												'rule' => '""'), 
											array('varname' => 'metaauthor', 
												'groupname' => 'metadata', 
												'value' => 'http://www.yoursite.com',
												'defaultvalue' => 'http://www.a2zcms.com',
												'type' =>'text',
												'rule' => ''),
											array('varname' => 'analytics', 
												'groupname' => 'analitic', 
												'value' => '',
												'defaultvalue' => '',
												'type' =>'textarea',
												'rule' => ''),
											array('varname' => 'email', 
												'groupname' => 'setting', 
												'value' => 'admin@example.com',
												'defaultvalue' => '',
												'type' =>'text',
												'rule' => 'required|email'), 
											array('varname' => 'dateformat', 
												'groupname' => 'setting', 
												'value' => 'd.m.Y', 
												'defaultvalue' => 'd.m.Y',
												'type' =>'text',
												'rule' => 'required'), 
											array('varname' => 'timeformat', 
												'groupname' => 'setting', 
												'value' => ' - H:i',
												'defaultvalue' => 'h:i A',
												'type' =>'text',
												'rule' => 'required'), 
											array('varname' => 'useravatwidth', 
												'groupname' => 'setting', 
												'value' => '150', 
												'defaultvalue' => '150',
												'type' =>'text',
												'rule' => 'required|integer'), 
											array('varname' => 'useravatheight', 
												'groupname' => 'setting', 
												'value' => '113', 
												'defaultvalue' => '113',
												'type' =>'text',
												'rule' => 'required|integer'), 
											array('varname' => 'pageitem', 
												'groupname' => 'setting', 
												'value' => '15', 
												'defaultvalue' => '15',
												'type' =>'text',
												'rule' => 'required|integer'), 
											array('varname' => 'searchcode', 
												'groupname' => 'googlesearch', 
												'value' => '',
												'defaultvalue' => '',
												'type' =>'textarea',
												'rule' => ''),
											array('varname' => 'sitetheme', 
												'groupname' => 'setting', 
												'value' => '',
												'defaultvalue' => 'default',
												'type' =>'select',
												'rule' => 'required'),
											array('varname' => 'pageitemadmin', 
												'groupname' => 'setting', 
												'value' => '10', 
												'defaultvalue' => '10',
												'type' =>'text',
												'rule' => 'required|integer'),
												
										)
									);
			
			//NavPagesPermissionSeeder			
			$permissions = array( 
					array('name' => 'manage_navigation', 
							'display_name' => 'Manage navigation','is_admin' => 1), 
					array('name' => 'manage_pages', 
							'display_name' => 'Manage pages','is_admin' => 1), 
					array('name' => 'manage_navigation_groups', 
							'display_name' => 'Manage navigation groups','is_admin' => 1),
					);

			DB::table('permissions') -> insert($permissions);
	
			$permissions_role = array( 
									array('role_id' => 1, 'permission_id' => 7,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), 
									array('role_id' => 1, 'permission_id' => 8,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), 
									array('role_id' => 1, 'permission_id' => 9,'created_at' => new DateTime, 
							'updated_at' => new DateTime,));
	
			DB::table('permission_role') -> insert($permissions_role);
				
			//GallerysPermissionSeeder
			$permissions = array( 
					array('name' => 'manage_galleries', 
							'display_name' => 'Manage galleries','is_admin' => 1), 
					array('name' => 'manage_gallery_images', 
							'display_name' => 'Manage gallery images','is_admin' => 1), 
					array('name' => 'manage_gallery_imagecomments', 
							'display_name' => 'Manage gallery image comments','is_admin' => 1),
					array ('name' => 'post_gallery_comment' ,
							'display_name' => 'Post gallery comment','is_admin' => 0));

			DB::table('permissions') -> insert($permissions);
	
			$permissions_role = array( 
									array('role_id' => 1, 'permission_id' => 10,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), 
									array('role_id' => 1, 'permission_id' => 11,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), 
									array('role_id' => 1, 'permission_id' => 12,'created_at' => new DateTime, 
							'updated_at' => new DateTime,),
									array('role_id' => 1, 'permission_id' => 13,'created_at' => new DateTime, 
							'updated_at' => new DateTime,));
	
			DB::table('permission_role') -> insert($permissions_role);
			
			//CustomFormPermissionsTableSeeder
			$permissions = array( 
						array('name' => 'manage_customform',
							'display_name' => 'Manage custom forms','is_admin' => 1),
					);

			DB::table('permissions') -> insert($permissions);
	
			$permissions = array( array('role_id' => 1, 'permission_id' => 14,'created_at' => new DateTime, 
							'updated_at' => new DateTime,) );
	
			DB::table('permission_role') -> insert($permissions);
			
			//PluginsTableSeeder
			$plugins = array( 
					array('content' => 'Blog', 
						'function_id' => 'getBlogId',
						'function_grid' => 'getBlogGroupId',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 		
					array('content' => 'Gallery', 
						'function_id' => 'getGalleryId',
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Custom form', 
						'function_id' => 'getCustomFormId',
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'To-do list', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Pages', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Blog', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Settings', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Users', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
						
				);
			 DB::table('plugins')->insert($plugins);
			 
			 //PluginfunctionTableSeeder
			 $plugin_blog = Plugin::find(1) -> id;
		$plugin_gallery = Plugin::find(2) -> id;
		$plugin_contact = Plugin::find(3) -> id;
		
		$pluginfunctions = array( 
					array('title' => 'Login form', 
						'plugin_id' => 0,
						'function'=>'login',
						'params'=>'',
						'type' => 'sidebar',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 		
					array('title' => 'Search Form', 
						'plugin_id' => 0,
						'function'=>'search',
						'params'=>'',
						'type' => 'sidebar',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
					array('title' => 'New gallerys', 
						'plugin_id' => $plugin_gallery,
						'function'=>'newGallerys',
						'params'=>'sort:asc;order:id;limit:5;',
						'type' => 'sidebar',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,),
					array('title' => 'New blogs', 
						'plugin_id' => $plugin_blog,
						'function'=>'newBlogs',
						'params'=>'sort:asc;order:id;limit:5;',
						'type' => 'sidebar',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,),
					array('title' => 'Content', 
						'plugin_id' => 0,
						'function'=>'content',
						'params'=>'',
						'type' => 'content',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,),					
					array('title' => 'Display gallery', 
						'plugin_id' => $plugin_gallery,
						'function'=>'showGallery',
						'params'=>'id;sort;order;limit;',
						'type' => 'content',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,),
					array('title' => 'Display blogs', 
						'plugin_id' => $plugin_blog,
						'function'=>'showBlogs',
						'params'=>'id;sort;order;limit;',
						'type' => 'content',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,),
					array('title' => 'Display custom form', 
						'plugin_id' => $plugin_contact,
						'function'=>'showCustomFormId',
						'params'=>'id;',
						'type' => 'content',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime,),	
					array('title' => 'Side menu', 
						'plugin_id' => 0,
						'function'=>'sideMenu',
						'params'=>'',
						'type' => 'sidebar',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 	
						);
						
				DB::table('plugin_functions')->insert($pluginfunctions);
				
				//CustomFormsTableSeeder
				$user_id = User::first();
		
				$custom_forms = array( 
							array('title' => 'Standard contact form', 
								'user_id' => $user_id -> id,
								'recievers' => $user_id -> email,
								'message' => '<p>Thank you for contact us, we will get back to you as soon as we can.</p>',
								'created_at' => new DateTime, 
								'updated_at' => new DateTime, ));
		
				DB::table('custom_forms')->insert($custom_forms);
				
				//CustomFormFieldsTableSeeder
				$custom_forms = CustomForm::find(1) -> id;
                $user_id = User::first() -> id;

                $custom_form_fields = array(
                            array(
							'custom_form_id'=>$custom_forms,
							'user_id' => $user_id,
							'name' => 'Name', 
							'options' => '',
							'type' => '1',
							'order' => '1',
							'mandatory' => '1',
							'created_at' => new DateTime, 
							'updated_at' => new DateTime, ),
						array(
							'custom_form_id'=>$custom_forms,
							'user_id' => $user_id,
							'name' => 'Email', 
							'options' => '',
							'type' => '1',
							'order' => '2',
							'mandatory' => '4',
							'created_at' => new DateTime, 
							'updated_at' => new DateTime, )	,
						array(
							'custom_form_id'=>$custom_forms,
							'user_id' => $user_id,
							'name' => 'Phone', 
							'options' => '',
							'type' => '1',
							'order' => '3',
							'mandatory' => '2',
							'created_at' => new DateTime, 
							'updated_at' => new DateTime, )	,
						array(
							'custom_form_id'=>$custom_forms,
							'user_id' => $user_id,
							'name' => 'Message', 
							'options' => '',
							'type' => '2',
							'order' => '4',
							'mandatory' => '1',
							'created_at' => new DateTime, 
							'updated_at' => new DateTime, )							
				);
				DB::table('custom_form_fields')->insert($custom_form_fields);
				
				//NavigationGroupsTableSeeder
				$navigation_groups = array( 
					array('title' => 'Main menu', 
						'slug' => 'main-menu',
						'showmenu' => '1',
						'showfooter' => '0',
						'showsidebar' => '0',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);
				 DB::table('navigation_groups')->insert($navigation_groups);
				 
				 //PagesTableSeeder
				 $ontent = '<div><h1>A2Z CMS 1.0</h1><p>Welcome to your very own A2Z CMS 1.1 installation.</p></div><div><p>Login into your profile and change this page and enjoy in A2ZCMS.</p><p>If you have any questions feel free to check the <a href="https://github.com/mrakodol/A2ZCMS/issues">Issues</a> at any time or create a new issue.</p><p>Enjoy A2Z CMS and welcome a board.</p><p>Kind Regards</p><p>Stojan Kukrika - A2Z CMS</p></div>';
				$pages = array( 
					array('title' => 'Home', 
						'slug' => 'home',
						'sidebar' => '1',
						'showtags' => '1',
						'showtitle' => '1',
						'showvote' => '1',
						'showdate' => '1',
						'voteup' => '0',
						'votedown' => '0',
						'password' => '',
						'tags' => 'tag1',
						'hits' => '0',
						'content' => $ontent,
						'status' => '1',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);
		 	DB::table('pages')->insert($pages);
			
			//NavigationLinksTableSeeder
			$page_id = Page::first()->id;
			$navigation_group_id = NavigationGroup::first()->id;
			
			$navigation_links = array( 
						array('title' => 'Home', 
						'parent' => NULL,
						'link_type' => 'page',
						'page_id' => $page_id,
						'url' => '',
						'uri' => '',
						'navigation_group_id' => $navigation_group_id,
						'position' => '1',
						'target' => '',
						'restricted_to' => '',
						'class' => '',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )							
				);
			DB::table('navigation_links')->insert($navigation_links);
			
			//PagePluginFunctionsTableSeeder
			$page_id = Page::first()->id;

			$page_plugin_functions = array( 
					array('page_id' => $page_id, 
						'plugin_function_id' => PluginFunction::find(1)->id,
						'order' => '1',
						'param' => '',
						'type' => '',
						'value' => '',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ),
					array('page_id' => $page_id, 
						'plugin_function_id' => PluginFunction::find(5)->id,
						'order' => '1',
						'param' => '',
						'type' => '',
						'value' => '',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);
			DB::table('page_plugin_functions')->insert($page_plugin_functions);
			
			//SettingsPermissionsTableSeeder
			$permissions = array( 
						array('name' => 'manage_settings', 
						'display_name' => 'Manage settings','is_admin' => 1),
					);

			DB::table('permissions') -> insert($permissions);
			$permissions = array( array('role_id' => 1, 'permission_id' => 15,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), );
			DB::table('permission_role') -> insert($permissions);
				
			//ToDoListPermissionsTableSeeder
			$permissions = array( 
						array('name' => 'manage_todolists', 
						'display_name' => 'Manage todolists','is_admin' => 1),
					);

			DB::table('permissions') -> insert($permissions);
			$permissions = array( array('role_id' => 1, 'permission_id' => 16,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), );
			DB::table('permission_role') -> insert($permissions);
			
			//PageVotePermissionsTableSeeder
			$permissions = array( 
						array('name' => 'post_page_vote', 
						'display_name' => 'Post page vote','is_admin' => 0),
						array('name' => 'post_blog_vote', 
						'display_name' => 'Post blog vote','is_admin' => 0),
						array('name' => 'post_image_vote', 
						'display_name' => 'Post image vote','is_admin' => 0),
					);
	
			DB::table('permissions') -> insert($permissions);
	
			$permissions = array( array('role_id' => 1, 'permission_id' => 17,'created_at' => new DateTime, 
							'updated_at' => new DateTime,), 
							array('role_id' => 1, 'permission_id' => 18,'created_at' => new DateTime, 
							'updated_at' => new DateTime,),
							array('role_id' => 1, 'permission_id' => 19,'created_at' => new DateTime, 
							'updated_at' => new DateTime,),);
	
			DB::table('permission_role') -> insert($permissions);
			
			//AdminNavigationsTableSeeder
			DB::table('admin_navigations') -> insert(array( 
							array('plugin_id' => 4, 
								'title' => 'To-do list',
								'icon' =>'icon-bell', 
								'url' => 'todolists', 
								'order' => 1,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
							array('plugin_id' => 3, 
								'title' => 'Custom forms', 
								'icon' =>'icon-list-alt',
								'url' => 'customform', 
								'order' => 2,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
							array('plugin_id' => 5, 
								'title' => 'Pages',
								'icon' =>'icon-globe', 
								'url' => 'pages', 
								'order' => 3,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
							array('plugin_id' => 1, 
								'title' => 'Blog', 
								'icon' =>'icon-external-link',
								'url' => 'blogcategorys', 
								'order' => 4,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
							array('plugin_id' =>2, 
								'title' => 'Gallery',
								'icon' =>'icon-camera', 
								'url' => 'gallery', 
								'order' => 5,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
							array('plugin_id' => 7, 
								'title' => 'Users', 
								'icon' =>'icon-group',
								'url' => 'users', 
								'order' => 6,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
							array('plugin_id' => 6, 
								'title' => 'Settings', 
								'icon' =>'icon-cogs',
								'url' => 'settings', 
								'order' => 7,
								'created_at' => new DateTime, 
								'updated_at' => new DateTime,), 
						)
					);
					
			//AdminSubNavigationsTableSeeder
			DB::table('admin_subnavigations') -> insert(array( 
                                array('admin_navigation_id' => 3,
                                    'title' => 'Navigation group',
                                    'icon' =>'icon-th-list',
                                    'url' => 'navigationgroups',
                                    'order' => 1,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 3,
                                    'title' => 'Pages',
                                    'icon' =>'icon-th-large',
                                    'url' => 'pages',
                                    'order' => 2,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 3,
                                    'title' => 'Navigation',
                                    'icon' =>'icon-th',
                                    'url' => 'navigation',
                                    'order' => 3,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 4,
                                    'title' => 'Blog categorys',
                                    'icon' =>'icon-rss',
                                    'url' => 'blogcategorys',
                                    'order' => 1,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 4,
                                    'title' => 'Blog',
                                    'icon' =>'icon-book',
                                    'url' => 'blogs',
                                    'order' => 2,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 4,
                                    'title' => 'Blog comments',
                                    'icon' =>'icon-comment-alt',
                                    'url' => 'blogcomments',
                                    'order' => 3,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 5,
                                    'title' => 'Gallery images',
                                    'icon' =>'icon-rss',
                                    'url' => 'galleryimages',
                                    'order' => 1,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 5,
                                    'title' => 'Galleries',
                                    'icon' =>'icon-camera-retro',
                                    'url' => 'galleries',
                                    'order' => 2,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 5,
                                    'title' => 'Gallery comments',
                                    'icon' =>'icon-comments-alt',
                                    'url' => 'galleryimagecomments',
                                    'order' => 3,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id'=> 6,
                                    'title' => 'Users',
                                    'icon' =>'icon-user',
                                    'url' => 'users',
                                    'order' => 1,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                                array('admin_navigation_id' => 6,
                                    'title' => 'Roles',
                                    'icon' =>'icon-user-md',
                                    'url' => 'roles',
                                    'order' => 2,
                                    'created_at' => new DateTime,
                                    'updated_at' => new DateTime,),
                            )
                        );
		}
}
