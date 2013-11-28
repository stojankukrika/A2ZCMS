<?php

class AdminController extends Controller {

	/**
	 * Initializer.
	 *
	 * @return \AdminController
	 */
	public function __construct() {
		// Apply the admin auth filter
		$this -> beforeFilter('check_admin');
		$this -> beforeFilter('csrf', array('on' => 'post'));
		$this -> beforeFilter('detectLang');
		$this -> beforeFilter('auth');
		$this -> beforeFilter('before');
		
	}

}
