<?php

class AdminRoleController extends AdminController {

	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Role Model
	 * @var Role
	 */
	protected $role;

	/**
	 * Permission Model
	 * @var Permission
	 */
	protected $permission;

	/**
	 * Inject the models.
	 * @param User $user
	 * @param Role $role
	 * @param Permission $permission
	 */
	public function __construct(User $user, Role $role, Permission $permission) {
		parent::__construct();
		$this -> user = $user;
		$this -> role = $role;
		$this -> permission = $permission;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
		// Title
		$title = Lang::get('admin/roles/title.role_management');

		// Grab all the groups
		$roles = $this -> role;

		// Show the page
		return View::make('admin/roles/index', compact('roles', 'title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// Get all the available permissions
		$permissions = $this -> permission -> all();

		// Selected permissions
		$permisionsadd =Input::old('permissions', array());
		// Title
		$title = Lang::get('admin/roles/title.create_a_new_role');

		// Show the page
		return View::make('admin/roles/create_edit', compact('permissions', 'permisionsadd', 'title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {

		// Declare the rules for the form validation
		$rules = array('name' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		// Check if the form validates with success
		if ($validator -> passes()) {
			// Get the inputs, with some exceptions
			
			$this -> role -> name = Input::get('name');
			$this -> role -> save();
			foreach (Input::get('permission') as $item) {
				$permission = new PermissionRole;
				$permission->permission_id = $item;
				$permission->role_id = $this -> role->id;
				$permission -> save();
			}
		}

		// Form validation failed
		return Redirect::to('admin/roles/' . $this -> role -> id . '/create_edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $role
	 * @return Response
	 */
	public function getEdit($role) {
		if (!empty($role)) {
			$permissions = $this -> permission -> preparePermissionsForDisplay($role -> perms() -> get());
		} else {
			// Redirect to the roles management page
			return Redirect::to('admin/roles') -> with('error', Lang::get('admin/roles/messages.does_not_exist'));
		}
		$permisionsadd = PermissionRole::where('role_id','=',$role->id)->select('permission_id')->get();
		// Title
		$title = Lang::get('admin/roles/title.role_update');

		// Show the page
		return View::make('admin/roles/create_edit', compact('role', 'permissions', 'title','permisionsadd'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $role
	 * @return Response
	 */
	public function postEdit($role) {
		// Declare the rules for the form validation
		$rules = array('name' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Update the role data
			$role -> name = Input::get('name');			
			$role -> save();
			
			PermissionRole::where('role_id','=',$role->id) -> delete();
				
			foreach (Input::get('permission') as $item) {
				$permission = new PermissionRole;
				$permission->permission_id = $item;
				$permission->role_id = $role->id;
				$permission -> save();
			}
		}

		// Form validation failed
		return Redirect::to('admin/roles/' . $role -> id . '/create_edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove user page.
	 *
	 * @param $role
	 * @return Response
	 */
	public function getDelete($role) {
		
			if ($role -> delete()) {
			// Redirect to the role management page
			return Redirect::to('admin/roles') -> with('success', Lang::get('admin/roles/messages.delete.success'));
		}

		// There was a problem deleting the role
		return Redirect::to('admin/roles') -> with('error', Lang::get('admin/roles/messages.delete.error'));
	}

	/**
	 * Show a list of all the roles formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$roles = Role::select(array('roles.id', 'roles.name', 'roles.id as users', 'roles.created_at'));

		return Datatables::of($roles) -> edit_column('users', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/usersforrole\' ) }}}" class="btn btn-link btn-sm" >{{{ AssignedRoles::where(\'role_id\', \'=\', $id)->count()  }}}</a>') 
					-> add_column('actions', '<a href="{{{ URL::to(\'admin/roles/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-sm btn-default"><i class="icon-edit "></i></a>
                                <a href="{{{ URL::to(\'admin/roles/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
                    ') -> remove_column('id') -> make();
	}

}
