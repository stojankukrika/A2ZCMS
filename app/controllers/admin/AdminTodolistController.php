<?php

class AdminTodolistController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $todolist;
	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Todolist $todolist) {
		parent::__construct();
		$this -> todolist = $todolist;
	}

	/**
	 * Show a list of all the todo list.
	 *
	 * @return View
	 */
	public function getIndex() {
		// Title
		$title = Lang::get('admin/todolists/title.to_do_management');
		// Show the page
		return View::make('admin/todolists/index', compact('title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate() {
		// Title
		$title = Lang::get('admin/todolists/title.create_a_new_to_do');

		// Show the page
		return View::make('admin/todolists/create_edit', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('content' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			$user = Auth::user();
			
			$this -> todolist -> title = Input::get('title');
			$this -> todolist -> content = Input::get('content');
			$this -> todolist -> finished = Input::get('finished');
			$this -> todolist -> work_done = (Input::get('finished')==100.00)?'1':'0';
			$this -> todolist -> user_id = $user -> id;
			// create todo list
			$this -> todolist -> save();
			
		}

		// Form validation failed
		return Redirect::to('admin/todolists/create') -> withInput() -> withErrors($validator);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $blog_category
	 * @return Response
	 */
	public function getEdit($id) {
		// Title
		$title = Lang::get('admin/todolists/title.to_do_update');
		$todolist = Todolist::find($id);
		// Show the page
		return View::make('admin/todolists/create_edit', compact('todolist', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $blog_category
	 * @return Response
	 */
	public function postEdit($id) {
	
		// Declare the rules for the form validation
		$rules = array('content' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		$todolist = Todolist::find($id);

		$inputs = Input::all();

		// Check if the form validates with success
		if ($validator -> passes()) {
				$user = Auth::user();
				$todolist -> title = Input::get('title');
				$todolist -> content = Input::get('content');
				$todolist -> finished = Input::get('finished');
				$todolist -> user_id = $user -> id;
				$todolist -> work_done = (Input::get('finished')==100.00)?'1':'0';
				
			if (!$todolist -> save()) {
				return Redirect::to('admin/todolists/' . $todolist -> id . '/edit') -> with('error', Lang::get('admin/todolists/messages.update.error'));
			}
		// Form validation failed
		return Redirect::to('admin/todolists/' . $todolist -> id . '/edit') -> withInput() -> withErrors($validator);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $comment
	 * @return Response
	 */
	public function getDelete($id) {
		
		$todo_list = Todolist::find($id);
		// Was the role deleted?
		if ($todo_list -> delete()) {
			// Redirect to the role management page
			return Redirect::to('admin/todolists') -> with('success', Lang::get('admin/todolists/messages.delete.success'));
		}

		// There was a problem deleting the role
		return Redirect::to('admin/todolists') -> with('error', Lang::get('admin/todolists/messages.delete.error'));
	}

	/** Change to-do to work ore done
	 * @param $todolist
	 * @return Redirect
	 * */
	public function getChange($id) {

		$this -> todolist = Todolist::find($id);
		$this -> todolist -> work_done = ($this -> todolist -> work_done + 1) % 2;
		$this -> todolist -> finished = $this -> todolist -> work_done *100.00;
		$this -> todolist -> save();

		// Form validation failed
		return Redirect::to('admin/todolists');

	}

	/**
	 * Show a list of all the comments formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$todolists = Todolist::select(array('todolist.id', 'todolist.content', 'todolist.work_done','todolist.finished', 'todolist.created_at'))->where('user_id','=',Auth::user()->id);

		return Datatables::of($todolists) -> edit_column('work_done', '@if ($work_done==0){{ "Work" }} @else {{ "Done" }} @endif') 
		-> add_column('actions', '<a href="{{{ URL::to(\'admin/todolists/\' . $id . \'/change\' ) }}}" class="btn btn-link btn-sm" ><i class="icon-retweet "></i></a>
        <a href="{{{ URL::to(\'admin/todolists/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-sm iframe" ><i class="icon-edit "></i></a>
                <a href="{{{ URL::to(\'admin/todolists/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
            ') -> remove_column('id') -> make();
	}

}
