<?php
use Robbo\Presenter\PresentableInterface;

class Gallery extends Eloquent implements PresentableInterface {

	protected $softDelete = true;
	protected $table = "gallery";

	/**
	 * Deletes a blog post and all
	 * the associated comments.
	 *
	 * @return bool
	 */
	public function delete() {
		// Delete the comments
		$this -> gallerycomments() -> delete();

		// Delete the blog post
		return parent::delete();
	}

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
	 * Get the blog's author.
	 *
	 * @return User
	 */
	public function author() {
		return $this -> belongsTo('User', 'user_id');
	}

	/**
	 * Get the blog's comments.
	 *
	 * @return array
	 */
	public function gallerycomments() {
		return $this -> hasMany('GalleryComment');
	}

	/**
	 * Get the date the blog was created.
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
		return new PostPresenter($this);
	}

}
