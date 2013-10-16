<?php

class InstallController extends BaseController {

	/**
	 * The user repository implementation.
	 *
	 * @var Wardrobe\UserRepositoryInterface
	 */
	protected $user;

	/**
	 * Create a new API User controller.
	 *
	 * @param UserRepositoryInterface $users
	 *
	 * @internal param UserRepositoryInterface $user
	 * @return InstallController
	 */
	public function __construct(User $user)
	{
		// If the config is marked as installed then bail with a 404.
		if (Config::get("a2zcms.installed") === true)
		{
			return App::abort(404, 'Page not found');
		}

		$this->user = $user;
	}

	/**
	 * Get the install index.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return View::make('install.installer.step1');
	}

	/**
	 * Run the migrations
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		Artisan::call('key:generate', array('--env' => App::environment()));

		$artisan = Artisan::call('migrate', array('--env' => App::environment()));

		if ($artisan > 0)
		{
			return Redirect::back()
				->withErrors(array('error' => 'Install Failed'))
				->with('install_errors', true);
		}

		return Redirect::to('install/user');
	}

	/**
	 * Get the user form.
	 *
	 * @return Response
	 */
	public function getUser()
	{
		return View::make('install.installer.user');
	}

	/**
	 * Add the user and show success!
	 *
	 * @return Response
	 */
	public function postUser()
	{
		
		 $rules = array(
            'first_name'   => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
        );
		
	     // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

		if (!$validator->passes())
		{
			returnRedirect::back()->withInput()->withErrors($validator);
		}
		
		$this->user->name = Input::get( 'name' );
        $this->user->surname = Input::get( 'surname' );
        $this->user->username = Input::get( 'email' );
        $this->user->email = Input::get( 'email' );
        $this->user->password = Input::get( 'password' );
		
		$this->user->save();

		return Redirect::to('install/config');
	}

	/**
	 * Get the config form.
	 */
	public function getConfig()
	{
		return View::make('install.installer.config');
	}

	/**
	 * Save the config files
	 */
	public function postConfig()
	{
		$this->setWardrobeConfig(Input::get('title', 'Site Name'), Input::get('theme', 'Default'), Input::get('per_page', 5));
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
	protected function setWardrobeConfig($title, $theme, $per_page)
	{
		$path = $this->getConfigFile('a2zcms.php');
		$content = str_replace(
			array('##title##', '##theme##', "'##per_page##'", "'##installed##'"),
			array(addslashes($title), $theme, (int) $per_page, 'true'),
			File::get($path)
		);
		return File::put($path, $content);
	}

	/**
	 * Get the config file
	 *
	 * Use the current environment to load the config file. With a fall back on the original.
	 *
	 * @param string $file
	 * @return string
	 */
	protected function getConfigFile($file)
	{
		if (file_exists(app_path().'/config/'.App::environment().'/'.$file))
		{
			return app_path().'/config/'.App::environment().'/'.$file;
		}

		return app_path().'/config/'.$file;
	}
}
