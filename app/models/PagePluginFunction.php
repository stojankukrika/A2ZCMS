<?php
use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class PagePluginFunction extends Eloquent implements PresentableInterface {

	public $table = 'page_plugin_functions';
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
	 * Returns a params for functions
	 *
	 * @return string
	 */
	public function params() {
		return nl2br($this -> params);
	}
	
	/**
	 * Get the pugin.
	 *
	 * @return Plugin
	 */
	public function plugin() {
		return $this -> belongsTo('PluginFunction', 'plugin_function_id');
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
	
	public function getPresenter() {
		return new PostPresenter($this);
	}
	
}
