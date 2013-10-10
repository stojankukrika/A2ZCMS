<?php
use Illuminate\Support\Facades\URL; 
use Robbo\Presenter\PresentableInterface;

class Settings extends Eloquent implements PresentableInterface {
		
	protected $table = "settings";
	public $timestamps = false;
	/**
	 * Deletes a blog post and all
	 * the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the comments
		$this->categorys()->softDeletes();

		return true;
	}
	
	/**
	 * Returns a formatted varname entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function varname()
	{
		return nl2br($this->varname);
	}
	
	/**
	 * Returns a formatted groupname entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function groupname()
	{
		return nl2br($this->groupname);
	}
	
	/**
	 * Returns a formatted value entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function value()
	{
		return nl2br($this->value);
	}
	
	/**
	 * Returns a formatted defaultvalue entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function defaultvalue()
	{
		return nl2br($this->defaultvalue);
	}
	
	public function getPresenter()
    {
        return new CommentPresenter($this);
    }
	
}
