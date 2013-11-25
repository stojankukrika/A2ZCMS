<?php

use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class Messages extends Eloquent implements PresentableInterface {

	protected $table = "messages";
	protected $softDelete = true;
	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function content() {
		return nl2br($this -> content);
	}
		/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function subject() {
		return nl2br($this -> subject);
	}
	/**
	 * Returns is message read.
	 *
	 * @return string
	 */
	public function read() {
		return nl2br($this -> read);
	}	
	
	/**
	 * Get the pugin.
	 *
	 * @return user receiver
	 */
	public function receiver() {
		return $this -> belongsTo('User', 'user_id_to');
	}
	/**
	 * Get the pugin.
	 *
	 * @return user sender
	 */
	public function sender() {
		return $this -> belongsTo('User', 'user_id_from');
	}

	/**
	 * Get the date the post was created.
	 *
	 * @param \Carbon|null $date
	 * @return string
	 */
	public function date($date = null) {
		if (is_null($date)) {
			$date = $this -> created_at;
		}

		return String::date($date);
	}

	/**
	 * Returns the date of the blog post creation,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function created_at() {
		return $this -> date($this -> created_at);
	}

	/**
	 * Returns the date of the blog post last update,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function updated_at() {
		return $this -> date($this -> updated_at);
	}

	public function getPresenter() {
		return new CommentPresenter($this);
	}

}
