<?php

class AdminController extends Controller {

	/**
	 * Initializer.
	 *
	 * @return \AdminController
	 */
	public function __construct() {
		// Apply the admin auth filter
		$this -> beforeFilter('admin-auth');
		$this -> beforeFilter('csrf', array('on' => 'post'));
		$this -> beforeFilter('detectLang');
		
	}

}
