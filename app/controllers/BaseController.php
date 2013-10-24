<?php

class BaseController extends Controller {

	/*
	 * navigation for webpage
	 * */
	protected $navigation;
    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    
    public function __construct()
    {
    	$this->beforeFilter('csrf', array('on' => 'post'));
		// Redirect to /install if the db isn't setup.
		if (Config::get("a2zcms.installed") !== true)
		{
			header('Location: install');
			exit;
		}
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	public function main_menu()
	{
		$navigation = Navigation::select('id','title','parent','link_type','target','position')->get();
				
		$menu = array(
	    'items' => array(),
	    'parents' => array()
	    );
	    // Builds the array lists with data from the menu table
	   foreach ($navigation as $key => $items) {
		   
	   	 	// Creates entry into items array with current menu item id ie. $menu['items'][1]
	   		 $menu['items'][$items['id']] = $items;
	    	// Creates entry into parents array. Parents array contains a list of all items with children
	    	$items['parent'] = (is_null($items['parent']))?0:$items['parent'];
	    	$menu['parents'][$items['parent']][] = $items['id'];
	    }
	   	return $this->buildMenu(0, $menu);
	}
	
	// Menu builder function, parentId 0 is the root
	public function buildMenu($parent, $menu)
	{
		$html='';
		if (isset($menu['parents'][$parent]))
		{
			foreach ($menu['parents'][$parent] as $itemId)
				{
					if(!isset($menu['parents'][$itemId]))
					{
						$html .= "<li> <a href='".$menu['items'][$itemId]['target']."'>".$menu['items'][$itemId]['title']."</a></li>";
					}
					if(isset($menu['parents'][$itemId]))
					{
						$html .= "<li class='dropdown'> <a class='dropdown-toggle' data-toggle='dropdown' href='".$menu['items'][$itemId]['target']."'>".$menu['items'][$itemId]['title']."</a>
						<ul class='dropdown-menu'>";
						$html .= $this->buildMenu($itemId, $menu);
						$html .= " </ul></li>";
					}
				}	
		}
		return $html;
	}
/*
 <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            External Pages
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="features.html">Features</a></li>
                            <li><a href="pricing.html">Pricing</a></li>
                            <li><a href="portfolio.html">Portfolio</a></li>
                            <li><a href="coming-soon.html">Coming Soon</a></li>
                            <li><a href="aboutus.html">About us</a></li>
                            <li><a href="contact.html">Contact us</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                        </ul>
                   </li>
  */
}