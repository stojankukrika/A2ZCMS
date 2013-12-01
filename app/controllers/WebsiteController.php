<?php

class WebsiteController extends BaseController {	
 
 	/**
	 * Page Model
	 * @var Page
	 */
	protected $page;
	/**
	 * Settings Model
	 * @var Settings
	 */
	protected $settings;
	/**
	 * Inject the models.
	 * @param Blog $blog
	 * @param User $user
	 */
	public function __construct(Page $page, Settings $settings) {
		parent::__construct();
		$this -> page = $page;
		$settings = Settings::all();
		$this -> settings = $settings;

	}	

	public function getView($slug=0) {
		if($slug==0) $slug = 1;
		// Get this webpage data
		$navigation_link = Navigation::where('id', '=', $slug) -> first();
		$page = $this -> page -> where('id', '=', $navigation_link->page_id) -> first();
		$page -> hits = $page -> hits + 1;
		$page -> update();
		
		// Check if the blog page exists
		if (is_null($page)) {
			// If we ended up in here, it means that a page didn't exist.
			// So, this means that it is time for 404 error page.
			return App::abort(404);
		}
		$pagecontent = BaseController::createSiderContent($navigation_link->page_id);
		// Show the page
		$data['sidebar_right'] = $pagecontent['sidebar_right'];
		$data['sidebar_left'] = $pagecontent['sidebar_left'];
		$data['content'] = $pagecontent['content'];
		$data['page'] = $page;
		return View::make('site/page/view_page', $data);
	}
	
	/*method for voting content get id of content,up-down vote and type of content(page,blog,image)*/
	public function contentvote()
	{
		$id = Input::get('id');
		$updown = Input::get('updown');
		$content = Input::get('content');
		$user = $this -> user -> currentUser();
		$newvalue = 0;
		$exists = ContentVote::where('content','=',$content)->where('idcontent','=',$id)->where('user_id','=',$user->id)->select('id')->get();
		
		switch ($content) {
			case 'page':
				$item = Page::where('id', '=', $id) -> first();
				break;
			case 'image':
				$item = GalleryImage::where ('id', '=', $id) -> first();
				break;
			case 'blog':
				$item = Blog::where ('id', '=', $id) -> first();
				break;			
			}
		if($exists->count() == 0 ){
			$contentvote = new ContentVote;
			$contentvote -> user_id = $user->id;
			$contentvote -> updown = $updown;
			$contentvote -> content = $content;
			$contentvote -> idcontent = $id;
			$contentvote -> created_at = new DateTime;
			$contentvote -> created_at = new DateTime;
			$contentvote -> save();
			
			if($updown=='1')
				{
					$item -> voteup = $item -> voteup + 1;
				}
				else {
					$item -> votedown = $item -> votedown + 1;
				}
				
				$item ->save();
			}
			$newvalue = $item->voteup - $item -> votedown;
					
		return $newvalue;
	}
	 
	 
}
