<?php 

	$list_name 	= "pageslist";
	$root		= 236;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = 0;}
	$DB = new db();

	$page_name	= $CORE['GET']['p']; 

/// MANAGE ACTUAL PAGE
	if ($page_name == "error") {
		$html 	.= "	<div class=\"MENU_GOD_SWITCH\">
							create this page +<br>
						" . addPageForm($_GET['p'],"?p=admin_pages","?p=" . $_GET['p']) . "	 
						</div>
						<br>";
	} else {
	/// LIST INI
	/// PARENT PAGE PARSE	
		$MANAGE_INI = array(	'list' 				=> $list_name,
										'rs_name' 		=> "pageslist",
										'template'		=> "page_parent",
										'sys'				=> 1,
										'item_id' 		=> PAGE_ID,
										//'mode' 			=> "list",
										'mod'				=> "mod_admin",
										'add'				=> "false",
										'system_edit'	=> 'true',
										);
		$GENRE = list_ini($MANAGE_INI);
		
		$html .= list_parse($MANAGE_INI);			
		
	/// ITEMS PARSE	
		$CRISS = array(	'list' 		=> $list_name,
								'table' 	=> "contents",
								'limit' 		=> 20,
								'root' 	=> $list_root,
								'gen'		=> 10,
								);
	
		//$GENRE = list_ini($CRISS);	
		
		$PROUT_INI = array(	'list' 			=> $list_name,
										'rs_name' 	=> "pageslist",
										'template'	=> "contentslist",
										'sys'			=> 1,
										
										);
							
		//$GENRE = list_ini($CRISS);
		//$html .= list_parse($PROUT_INI);
		
				
		$html 	= "	<div class=\"MENU_GOD_SWITCH\">
							<a href=\"?p=admin_pages&pageslist_cat_id=" . PAGE_ID . "\" target=\"_blank\"> edit this page </a> <br>	 
						
						<br />
						$html
						
						</div>
						<br />
						";	

		//$html 	.= div( '+ ajouter un html'	. BR . addHtmlForm($pid="", $action="", $returnUrl="") , array('class' => 'MENU_GOD_SWITCH'));
						
	}

	if (is_allowed(6)) {
	/// MANAGE ACTUAL SITE LAYOUT	
			$html 	.= "	<div class=\"MENU_GOD_BUTTON\">
								<a href=\"?p=admin_layouts&layoutslist_cat_id=" . SITE_LAYOUT_ID . "\" target=\"_blank\"> edit site layout (" . SITE_LAYOUT_NAME . ")</a> <br>	 
							
							<br />
							
							
							</div>
							<br />
							";		
	/// MANAGE ACTUAL PAGE LAYOUT	
			$html 	.= "	<div class=\"MENU_GOD_BUTTON\">
								<a href=\"?p=admin_layouts&layoutslist_cat_id=" . PAGE_LAYOUT_ID . "\" target=\"_blank\"> edit page layout (" . PAGE_LAYOUT_NAME . ")</a> <br>	 
							
							<br />
							
							
							</div>
							<br />
							";		
	}	
	
/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>