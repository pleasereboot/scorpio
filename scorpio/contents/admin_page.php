<?php 

	$page_name	= $CORE['GET']['p'];
	$page_id 	= data_switch("contents", $page_name);

	if ($page_name == "error") {
		$return 	= "	<div class=\"MENU_GOD_SWITCH\">
							create this page +<br>
						" . addPageForm($_GET['p'],"?p=admin_pages","?p=" . $_GET['p']) . "	 
						</div>
						<br>";
	} else {
	/// PARENT PAGE PARSE	
		$PARENT_INI = array(	'table' 	=> "contents",
								'limit' 	=> 20,
								'root' 		=> 236,	
								'list' 		=> "pageslist",
								'rs_name' 	=> "pageslist",
								'template'	=> "pages",
								'sys'		=> 1,
								'item_id' 	=> $page_id,
								'mode' 		=> "list",
								'add' 		=> "false",
								'mod'		=> "mod_admin",
								
							);
		//$GENRE = list_ini($PARENT_INI);
		//$html .= list_parse($PARENT_INI);	
	
		$return 	= "	<div class=\"MENU_GOD_SWITCH\">
							<a href=\"?p=admin_pages&pageslist_cat_id=$page_id\" target=\"_blank\"> edit this page </a> <br>	 
						
						<br />
						$html
						
						</div>
						<br />
						";
						
		//$return 	= "<a href=\"?p=admin_pages&contentslist_cat_id=$page_id\"> edit this page </a> <br>";
	}
	


	
?>