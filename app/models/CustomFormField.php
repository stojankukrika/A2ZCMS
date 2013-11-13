<?php

use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class CustomFormField extends Eloquent implements PresentableInterface {

	protected $table = "custom_form_fields";
	protected $softDelete = true;
	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function name() {
		return nl2br($this -> name);
	}
	
	/*get author of form*/
	public function author() {
		return $this -> belongsTo('User', 'user_id');
	}
	/*Returns options for contact form*/
	public function options() {
		return nl2br($this -> options);
	}
	
	/*Returns typeid for contact form*/
	public function typeid() {
		return nl2br($this -> typeid);
	}
	
	/*Returns mandatory for contact form*/
	public function mandatory() {
		return nl2br($this -> mandatory);
	}
	
	/*Returns order for contact form*/
	public function order() {
		return nl2br($this -> order);
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
