<?php

class UserMessagesController extends BaseController {
	
	 /*
	 * User Model
	 * @var User
	 */
	protected $user;
	protected $messages;

	/**
	 * Inject the models.
	 * @param User $user
	 */
	public function __construct(User $user,Messages $messages) {
		parent::__construct();
		$this -> user = $user;
		$this -> messages = $messages;
	}
	/**
	 * Users messages page
	 *
	 * @return View
	 */
	public function getIndex() {
		
		$user = $this -> user -> currentUser();
		
		list($user, $redirect) = $this -> user -> checkAuthAndRedirect('user');
		if ($redirect) {
			return $redirect;
		}
		$received = $this -> messages -> where('user_id_to','=',$user->id)-> get();
		$send = $this -> messages -> where('user_id_from','=',$user->id)-> get();

		// Show the page
		return View::make('site/messages/index', compact('user','received','send'));
	}
}
