<?php

class AdminUserController extends AdminController {

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
		$title = Lang::get('admin/users/title.user_management');

		// Grab all the users
		$users = $this -> user;

		// Show the page
		return View::make('admin/users/index', compact('users', 'title'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getUsersForRole($user_role) {
		// Title
		$title = Lang::get('admin/users/title.user_management_for_role');

		// Show the page
		return View::make('admin/users/usersforrole', compact('title', 'user_role'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// All roles
		$roles = $this -> role -> all();
		// Get all the available permissions
		$permissions = $this -> permission -> all();
		// Selected groups
		$selectedRoles = Input::old('roles', array());
		// Selected permissions
		$selectedPermissions = Input::old('permissions', array());
		// Title
		$title = Lang::get('admin/users/title.create_a_new_user');
		// Mode
		$mode = 'create';
		// Show the page
		return View::make('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		$this -> user -> name = Input::get('name');
		$this -> user -> surname = Input::get('surname');
		$this -> user -> username = Input::get('username');
		$this -> user -> email = Input::get('email');
		$this -> user -> password = Input::get('password');
		// The password confirmation will be removed from model
		// before saving. This field will be used in Ardent's
		// auto validation.
		$this -> user -> password_confirmation = Input::get('password_confirmation');
		$this -> user -> confirmed = Input::get('confirm');
		
		// Permissions are currently tied to roles. Can't do this yet.
		//$user->permissions = $user->roles()->preparePermissionsForSave(Input::get( 'permissions' ));

		// Save if valid. Password field will be hashed before save
		$this -> user -> save();

		if ($this -> user -> id) {
			// Save roles. Handles updating.
			$this -> user -> saveRoles(Input::get('roles'));

			// Redirect to the new user page
			return Redirect::to('admin/users/' . $this -> user -> id . '/edit') -> with('success', Lang::get('admin/users/messages.create.success'));
		} else {
			// Get validation errors (see Ardent package)
			$error = $this -> user -> errors() -> all();

			return Redirect::to('admin/users/create') -> withInput(Input::except('password')) -> with('error', $error);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($user) {
		// redirect to the frontend
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getEdit($user) {
		if ($user -> id) {
			$roles = $this -> role -> all();
			$permissions = $this -> permission -> all();

			// Title
			$title = Lang::get('admin/users/title.user_update');
			// mode
			$mode = 'edit';

			return View::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'title', 'mode'));
		} else {
			return Redirect::to('admin/users') -> with('error', Lang::get('admin/users/messages.does_not_exist'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $user
	 * @return Response
	 */
	public function postEdit($user) {
		// Validate the inputs
		$validator = Validator::make(Input::all(), $user -> getUpdateRules());

		if ($validator -> passes()) {
			$oldUser = clone $user;
			$user -> name = Input::get('name');
			$user -> surname = Input::get('surname');
			$user -> username = Input::get('username');
			$user -> email = Input::get('email');
			$user -> confirmed = Input::get('confirm');

			$password = Input::get('password');
			$passwordConfirmation = Input::get('password_confirmation');

			if (!empty($password)) {
				if ($password === $passwordConfirmation) {
					$user -> password = $password;
					// The password confirmation will be removed from model
					// before saving. This field will be used in Ardent's
					// auto validation.
					$user -> password_confirmation = $passwordConfirmation;
				} else {
					// Redirect to the new user page
					return Redirect::to('admin/users/' . $user -> id . '/edit') -> with('error', Lang::get('admin/users/messages.password_does_not_match'));
				}
			} else {
				unset($user -> password);
				unset($user -> password_confirmation);
			}

			if ($user -> confirmed == null) {
				$user -> confirmed = $oldUser -> confirmed;
			}

			$user -> prepareRules($oldUser, $user);

			// Save if valid. Password field will be hashed before save
			$user -> amend();

			// Save roles. Handles updating.
			$user -> saveRoles(Input::get('roles'));
		}

		// Get validation errors (see Ardent package)
		$error = $user -> errors() -> all();

		if (empty($error)) {
			// Redirect to the new user page
			return Redirect::to('admin/users/' . $user -> id . '/edit') -> with('success', Lang::get('admin/users/messages.edit.success'));
		} else {
			return Redirect::to('admin/users/' . $user -> id . '/edit') -> with('error', Lang::get('admin/users/messages.edit.failure'));
		}
	}

	/**
	 * Remove user page.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getDelete($user) {
		// Check if we are not trying to delete ourselves
		if ($user -> id === Confide::user() -> id) {
			// Redirect to the user management page
			return Redirect::to('admin/users') -> with('error', Lang::get('admin/users/messages.delete.impossible'));
		}

		AssignedRoles::where('user_id', $user -> id) -> delete();

		$id = $user -> id;
		$user -> delete();

		// Was the comment post deleted?
		$user = User::find($id);
		if (empty($user)) {
			return Redirect::to('admin/users') -> with('success', Lang::get('admin/users/messages.delete.success'));
		} else {
			// There was a problem deleting the user
			return Redirect::to('admin/users') -> with('error', Lang::get('admin/users/messages.delete.error'));
		}
	}

	/**
	 * Show a list of all the users formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$users = User::select(array('users.id', 'users.name', 'users.surname', 'users.username', 'users.email', 'users.confirmed', 'users.created_at'));

		return Datatables::of($users)
			-> edit_column('confirmed', '@if($confirmed)
                            Yes
                        @else
                            No
                        @endif') -> add_column('actions', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-sm btn-default"><i class="icon-edit "></i></a>
                                @if($username == \'admin\')
                                @else
                                    <a href="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
                                @endif
            ') -> remove_column('id') -> make();
	}

	/**
	 * Show a list of all the users with role formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getDataforrole($role_id) {
		$users = User::leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id') 
					-> leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id') 
					-> where('assigned_roles.role_id', '=', $role_id) 
					-> select(array('users.id', 'users.name', 'users.surname', 'users.username', 'users.email', 'roles.name as rolename', 'users.confirmed', 'users.created_at'));

		return Datatables::of($users) -> edit_column('confirmed', '@if($confirmed)
                            Yes
                        @else
                            No
                        @endif') -> add_column('actions', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-sm btn-default"><i class="icon-edit "></i></a>
                                @if($username == \'admin\')
                                @else
                                    <a href="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-sm btn-danger"><i class="icon-trash "></i></a>
                                @endif
            ') -> remove_column('id') -> make();
	}
	
	/*edit admin user profile*/
	/**
	 * Users settings page
	 *
	 * @return View
	 */
	public function getProfileEdit() {
					
			$user_auth = Auth::user();
			$user = User::where('id', '=', $user_auth->id) -> first();
			// Title
			$title = Lang::get('admin/users/title.user_update');			
			// mode
			$mode = 'edit';
			return View::make('admin/users/profile', compact('user', 'title', 'mode'));
	}
	
	 
	 /**
	 * Edits a user
	 *
	 */
	public function postProfileEdit() {
			// Declare the rules for the form validation
		$rules = array('surname' => 'required', 
						'name'=>'required');
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		
		$user_auth = Auth::user();
		$user = User::where('id', '=', $user_auth->id) -> first();		
		if ($validator -> passes()) {
		
			$oldUser = clone $user;
			$user -> name = Input::get('name');
			$user -> surname = Input::get('surname');
			$password = Input::get('password');
			$passwordConfirmation = Input::get('password_confirmation');
			if(Input::hasFile('avatar'))
			{
				$file = Input::file('avatar');
				$destinationPath = public_path() . '\avatar\\/';
				$filename = $file->getClientOriginalName();				
				$extension = $file -> getClientOriginalExtension();
				$name = sha1($filename . time()) . '.' . $extension;			
				Input::file('avatar')->move($destinationPath, $name);
				Thumbnail::generate_image_thumbnail($destinationPath. $name, $destinationPath .$name,80,80);
				$user -> avatar = $name;
			}
			if (!empty($password)) {
				if ($password === $passwordConfirmation) {
					$user -> password = $password;
					// The password confirmation will be removed from model
					// before saving. This field will be used in Ardent's
					// auto validation.
					$user -> password_confirmation = $passwordConfirmation;
				} else {
					// Redirect to the new user page
					return Redirect::to('users') -> with('error', Lang::get('admin/users/messages.password_does_not_match'));
				}
			} else {
				unset($user -> password);
				unset($user -> password_confirmation);
			}
			$user -> amend();
		}
		// Get validation errors (see Ardent package)
		$error = $user -> errors() -> all();
		
		if (empty($error)) {
			return Redirect::to('admin/users/profile') -> with('success', Lang::get('user/user.user_account_updated'));
		} else {
			return Redirect::to('admin/users/profile') -> withInput(Input::except('password', 'password_confirmation')) -> with('error', $error);
		}
	}
	

}
