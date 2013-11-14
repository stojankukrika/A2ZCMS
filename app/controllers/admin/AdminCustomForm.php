<?php

class AdminCustomFormController extends AdminController {

	/**
	 * Page Repository
	 *
	 * @var Page
	 */
	protected $customform;

	//public $restful = true;

	public function __construct(CustomForm $customform) {
		parent::__construct();
		$this -> customform = $customform;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {

		$title = Lang::get('admin/customform/title.contact_form_management');
		
		// Grab all the blog posts
		$customform = $this -> customform;

		return View::make('admin/customform/index', compact('title', 'customform'));
	}
	
	public function getCreate() {

		$title = Lang::get('admin/customform/title.contact_form_management');

		return View::make('admin/customform/create_edit', compact('title'));
	}
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate() {
		// Declare the rules for the form validation
		$rules = array('title' => 'required', 'message' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator -> passes()) {
			// Create a new blog post
			$user = Auth::user();

			// Update the blog post data
			$this -> contactform -> title = Input::get('title');
			$this -> contactform -> message = Input::get('message');
			$this -> contactform -> recievers = Input::get('recievers');
			$this -> customform -> user_id = $user -> id;
			
			// Was the blog post created?
			if ($this -> customform -> save()) {
					
				//add fileds to form
				if(Input::get('pagecontentorder')!=""){
					//$this->saveFilds(Input::get('pagecontentorder'),Input::get('count'),$this -> contactform -> id,$user -> id);
				}				
				
				// Redirect to the new blog post page
				return Redirect::to('admin/customform/' . $this -> customform -> id . '/edit') -> with('success', Lang::get('admin/customform/messages.create.success'));
			}

			// Redirect to the blog post create page
			return Redirect::to('admin/customform') -> with('error', Lang::get('admin/customform/messages.create.error'));
		}

		// Form validation failed
		return Redirect::to('admin/customform') -> withInput() -> withErrors($validator);
	}	

	public function getEdit($id) {

		$title = Lang::get('admin/customform/title.contact_form_management');

		$customform = CustomForm::find($id);
		
		return View::make('admin/customform/create_edit', compact('title', 'customform'));
	}
		
	/**
	 * Update the specified resource in storage.
	 *
	 * @param $form
	 * @return Response
	 */
	public function postEdit($id) {

		$rules = array('title' => 'required', 'message' => 'required');
		
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		// Check if the form validates with success
		if ($validator -> passes()) {
	
			$customform = CustomForm::find($id);
			$user = Auth::user();
			$customform -> title = Input::get('title');
			$customform -> message = Input::get('message');
			$customform -> recievers = Input::get('recievers');
			$customform -> user_id = $user -> id;
			
			if ($contactform -> save()) {
					
				//add fileds to form
				if(Input::get('pagecontentorder')!=""){
					$this->saveFilds(Input::get('pagecontentorder'),Input::get('count'),$contactform -> id,$user -> id);
				}	
				
				return Redirect::to('admin/customform/' . $customform -> id . '/edit') -> with('success', Lang::get('admin/customform/messages.update.success'));
			}
		}

		// Form validation failed
		return Redirect::to('admin/customform/' . $id . '/edit') -> withInput() -> withErrors($validator);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $blog
	 * @return Response
	 */
	public function getDelete($id) {
			
		$customform = CustomForm::find($id);
		// Was the role deleted?
		if ($customform -> delete()) {

			// Redirect to the blog posts management page
			return Redirect::to('admin/customform') -> with('success', Lang::get('admin/customform/messages.delete.success'));
		}
		// There was a problem deleting the blog post
		return Redirect::to('admin/customform') -> with('error', Lang::get('admin/customform/messages.delete.error'));
	}
	
	
	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData() {
		$blogs = CustomForm::select(array('title', 'id as fields', 'id as id', 'created_at'));

		return Datatables::of($blogs) 
			-> edit_column('fields', '{{ DB::table(\'custom_form_fields\')->where(\'custom_form_id\', \'=\', $id)->count() }}') 
			-> add_column('actions', '<a href="{{{ URL::to(\'admin/customform/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-sm iframe" ><i class="icon-edit "></i></a>
                <a href="{{{ URL::to(\'admin/customform/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger"><i class="icon-trash "></i></a>
            ') 
            -> remove_column('id') -> make();
	}
	
	public function saveFilds($pagecontentorder,$count,$customform_id,$user_id)
	{
		$formfields = CustomFormField::where('custom_form_id','=',$customform_id)->get();
		$formfields->delete();
		$params = explode(',', $pagecontentorder);
		$order = 1;
		for ($i=0; $i <= $count; $i=$i+4) {
			 
			$customformfield = new CustomFormField;
			$customformfield -> name = $params[$i];
			$customformfield -> mandatory = $params[$i+1];
			$customformfield -> type = $params[$i+2];
			$customformfield -> options = $params[$i+3];
			$customformfield -> order = $order;
			$customformfield -> custom_form_id = $customform_id;
			$customformfield -> user_id = $user_id;						
			$customformfield -> save();	
			$order++;
		}
	}
}