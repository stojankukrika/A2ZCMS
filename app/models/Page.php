<?php
use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class Page extends Eloquent implements PresentableInterface {

	public $table = 'pages';
	protected $softDelete = true;
	protected $guarded = array();	
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
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function content() {
		return nl2br($this -> content);
	}
	
	/**
	 * Returns a formatted post content css,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function page_css() {
		return nl2br($this -> page_css);
	}
	
	/**
	 * Returns a formatted post content javacript,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function page_javascript() {
		return nl2br($this -> page_javascript);
	}
	
}
