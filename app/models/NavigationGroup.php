<?php
use Illuminate\Support\Facades\URL;
use Robbo\Presenter\PresentableInterface;

class NavigationGroup extends Eloquent implements PresentableInterface {

	public $table = "navigation_groups";
	protected $softDelete = true;
	protected $guarded = array();

}
