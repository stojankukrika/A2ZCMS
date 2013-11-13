<?php

use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class CustomForm extends Eloquent implements PresentableInterface {

	protected $table = "custom_forms";
	protected $softDelete = true;
	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function title() {
		return nl2br($this -> title);
	}
	/*Returns content for contact form*/
	public function message() {
		return nl2br($this -> message);
	}
	/*get author of form*/
	public function author() {
		return $this -> belongsTo('User', 'user_id');
	}
	
	public function customformfields() {
		return $this -> hasMany('CustomFormField')->orderBy('custom_form_fields.order', 'ASC');
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
