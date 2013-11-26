<?php

class PermissionRole extends Eloquent {
	
	public $table = 'permission_role';
	
	protected $softDelete = true;
	 
	protected $guarded = array();

	public static $rules = array();

}
