<?php
use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class Navigation extends Eloquent implements PresentableInterface {

	public $table = "navigation_links";
	protected $softDelete = true;
	protected $guarded = array();
	
	public function getPresenter() {
		return new PostPresenter($this);
	}
}
