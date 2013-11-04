<?php

class AdminNavigationGroupsController extends AdminController {

	/**
	 * Navigation_group Repository
	 *
	 * @var Navigation_group
	 */
	protected $navigationGroup;

	public function __construct(NavigationGroup $navigationGroup) {
		parent::__construct();
		$this -> navigationGroup = $navigationGroup;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
		$title = Lang::get('admin/navigation/title.navigation_group_management');
		$navigationGroups = $this -> navigationGroup -> all();

		return View::make('admin/navigationgroups/index', compact('title', 'navigationGroups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		$title = Lang::get('admin/navigation/title.create_a_new_navigation_group');

		// Show the navigation group
		return View::make('admin/navigationgroups/create_edit', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Create a new blog post
			$this -> navigationGroup -> title = Input::get('title');
			$this -> navigationGroup -> abbrev = Str::slug(Input::get('title'));
			$this -> navigationGroup -> showmenu = Input::get('showmenu');
			$this -> navigationGroup -> showfooter = Input::get('showfooter');
			$this -> navigationGroup -> showsidebar = Input::get('showsidebar');
			
			$this -> navigationGroup -> save();

			if ($this -> navigationGroup -> id) {
				// Redirect to the new navigationGroup
				return Redirect::to('admin/navigationgroups/' . $this -> navigationGroup -> id . '/edit') -> with('success', Lang::get('admin/navigation/messages.create.success'));
			} 
			else {
				// Get validation errors (see Ardent package)
				$error = $this -> navigationGroup -> errors() -> all();

				return Redirect::to('admin/navigationgroups/create') -> with('error', $error);
			}
		}
		// Form validation failed
		return Redirect::to('admin/navigationgroups/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @return Response
	 */
	public function getEdit($id) {
		if ($id) {
			$navigationGroup = NavigationGroup::find($id);
			// Title
			$title = Lang::get('admin/navigation/title.navigation_group_update');
			// mode
			$mode = 'edit';

			return View::make('admin/navigationgroups/create_edit', compact('navigationGroup', 'title', 'mode'));
		} else {
			return Redirect::to('admin/navigationgroups') -> with('error', Lang::get('admin/navigation/messages.does_not_exist'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $navigationGroup
	 * @return Response
	 */
	public function postEdit($id) {
		// Declare the rules for the form validation
		$rules = array('title' => 'required|min:3');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		$navigationGroup = NavigationGroup::find($id);

		$inputs = Input::all();

		// Check if the form validates with success
		if ($validator -> passes()) {
			$navigationGroup -> abbrev = Str::slug(Input::get('title'));
			// Was the page updated?
			if ($navigationGroup -> update($inputs)) {
				// Redirect to the navigationGroup navigationGroup
				return Redirect::to('admin/navigationgroups/' . $navigationGroup -> id . '/edit') -> with('success', Lang::get('admin/navigation/messages.update.success'));
			} else {
				// Redirect to the navigationGroup navigationGroup
				return Redirect::to('admin/navigationgroups/' . $navigationGroup -> id . '/edit') -> with('error', Lang::get('admin/navigation/messages.update.error'));
			}
		}

		// Form validation failed
		return Redirect::to('admin/navigationgroups/' . $navigationGroup -> id . '/edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param $role
	 * @internal param $id
	 * @return Response
	 */
	public function getDelete($id) {
		$navigationGroup = NavigationGroup::find($id);
		// Was the role deleted?
		if ($navigationGroup -> delete()) {
			// Redirect to the role management page
			return Redirect::to('admin/navigationgroups') -> with('success', Lang::get('admin/navigation/messages.delete.success'));
		}

		// There was a problem deleting the role
		return Redirect::to('admin/navigationgroups') -> with('error', Lang::get('admin/navigation/messages.delete.error'));
	}

	/**
	 * Show a list of all the pages formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$navs = NavigationGroup::select(array('navigation_groups.id', 'navigation_groups.title', 'navigation_groups.abbrev'));

		return Datatables::of($navs) -> add_column('actions', '<a href="{{{ URL::to(\'admin/navigationgroups/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-sm"><i class="icon-edit "></i></a>
                               <a href="{{{ URL::to(\'admin/navigationgroups/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
                               
            ') -> remove_column('id') -> make();
	}

}
