<?php

class AdminDashboardController extends AdminController {

	/**
	 * Admin dashboard
	 *
	 */
	public function getIndex() {
		
		$settings = Settings::all();
		$dateformat = "";
		$timeformat = "";
		foreach ($settings as $v) {
			if ($v -> varname == 'dateformat') {
				$dateformat  = ($v -> value!="")?$v -> value:$v -> defaultvalue;
			}
			if ($v -> varname == 'timeformat') {
				$timeformat =  ($v -> value!="")?$v -> value:$v -> defaultvalue;
			}					
			
		}
		$data['title']	= Lang::get('admin/general.dashboard');
		$data['to_do_list_not_finish'] = Todolist::where('work_done','=',0)->count();
		$data['pages'] = Page::count();
		$data['customform'] = CustomForm::count();
		$data['gallery'] = Gallery::count();
		$data['blog'] = Blog::count();
		$data['users'] = User::count();
		$data['settings'] = date($dateformat.$timeformat);
		return View::make('admin/dashboard', $data);
	}

}
