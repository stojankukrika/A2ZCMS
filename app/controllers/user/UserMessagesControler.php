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
		$allUsers = User::where('id','<>',$user->id)->get();
		list($user, $redirect) = $this -> user -> checkAuthAndRedirect('user');
		if ($redirect) {
			return $redirect;
		}
		$received = $this -> messages -> where('user_id_to','=',$user->id)->orderBy('id', 'DESC')-> get();
		$send = $this -> messages -> where('user_id_from','=',$user->id)->orderBy('id', 'DESC')-> get();
		
		$page = Page::first();
		$pagecontent = BaseController::createSiderContent($page->id);
		// Show the page
		$data['sidebar_right'] = $pagecontent['sidebar_right'];
		$data['sidebar_left'] = $pagecontent['sidebar_left'];
		$data['page'] = $page;
		$data['user'] =$user;
		$data['received'] = $received;
		$data['send'] =$send;
		$data['allUsers'] =$allUsers;
		
		return View::make('site/messages/index', $data);
	}
	
	public function postSendmessage() {
		// Declare the rules for the form validation
		$rules = array('content' => 'required|min:3','subject' => 'required|min:3','recipients' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			
			$user = $this -> user -> currentUser();
			
			$this -> messages -> subject = Input::get('subject');
			$this -> messages -> content = Input::get('content');
			$this -> messages -> user_id_from = $user->id;
			foreach (Input::get('recipients') as $recipient) {
				$this -> messages -> user_id_to = $recipient;
				$this -> messages -> save();
			}
		}	

		// Show the page
		return Redirect::to('user/messages');
	}
	
	public function getRead($message_id)
	{
		$message = Messages::where('id', '=', $message_id)->first();
		$message->read = 1;
		$message->save();
	}
}
