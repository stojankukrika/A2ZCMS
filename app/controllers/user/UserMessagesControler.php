<?php

class UserMessagesController extends BaseController {
	
	 /*
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Inject the models.
	 * @param User $user
	 */
	public function __construct(User $user) {
		parent::__construct();
		$this -> user = $user;
	}
	/**
	 * Users messages page
	 *
	 * @return View
	 */
	public function getIndex() {
		list($user, $redirect) = $this -> user -> checkAuthAndRedirect('user');
		if ($redirect) {
			return $redirect;
		}

		// Show the page
		return View::make('site/messages/index', compact('user'));
	}
}
