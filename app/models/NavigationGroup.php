<?php
use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class NavigationGroup extends Eloquent implements PresentableInterface {

	public $table = "navigation_groups";
	protected $softDelete = true;
	protected $guarded = array();
	
	public function navigations() {
        return $this->has_many('Navigation');
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
