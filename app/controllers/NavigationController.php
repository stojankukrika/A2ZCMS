<?php

class NavigationController extends BaseController {

	/**
     * Navigation Model
     * @var Navigation
     */
	public static function main_menu()
	{
		    // Select all entries from the menu table
	    $result=Navigation::all();
	    // Create a multidimensional array to conatin a list of items and parents
	    $menu = array(
	    'items' => array(),
	    'parents' => array()
	    );
	    // Builds the array lists with data from the menu table
	   foreach ($result as $key => $items) {
		   
	   	 	// Creates entry into items array with current menu item id ie. $menu['items'][1]
	   		 $menu['items'][$items['id']] = $items;
	    	// Creates entry into parents array. Parents array contains a list of all items with children
	    	$menu['parents'][$items['parent']][] = $items['id'];
	    }
	   	$finish_menu = NavigationController::buildMenu(0, $menu);
		return $finish_menu;
	}
	// Menu builder function, parentId 0 is the root
	public static function buildMenu($parent, $menu)
	{
		$html = "";
		if (isset($menu['parents'][$parent]))
		{
			$html .= "<ul>\n";
			foreach ($menu['parents'][$parent] as $itemId)
				{
					if(!isset($menu['parents'][$itemId]))
					{
						$html .= "<li>\n <a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a>\n</li> \n";
					}
					if(isset($menu['parents'][$itemId]))
					{
						$html .= "<li>\n <a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a> \n";
						$html .= buildMenu($itemId, $menu);
						$html .= "</li> \n";
					}
				}		
			$html .= "</ul> \n";
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