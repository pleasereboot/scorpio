<?php 


	$list_name = "structslist";
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = 0;}

/// LIST INI
	$INI = array(	'list' 			=> $list_name,
						'table' 		=> "contents",
						'limit' 			=> 5000,
						'root' 		=> $list_root,
						);

	$GENRE = list_ini($INI);
	
/// PARENT PAGE PARSE	
	if (isset($_GET['structslist_cat_id'])) {	
		$PARENT_INI = array(	'list' 		=> "structlist",
								'rs_name' 	=> $list_name,
								'template'	=> "page_parent",
								'sys'		=> 1, 
								'item_id' 	=> $_GET['structslist_cat_id'],
								//'mode' 		=> "list",
								'mod'		=> "mod_admin",
								'add'		=> "false", 
								'edit'		=> 1,
							);
		$GENRE = list_ini($PARENT_INI); 
		$html .= list_parse($PARENT_INI);
	}
	
/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> "contentslist",
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "admin_structs",
						'catlist' 	=> $list_name,
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> "layoutslist",
						'template'	=> "contentslist",
						'sys'		=> 1,
						'form'		=> 1,
						 
	 					);

	$html .= list_parse($CATS_INI);	
	
	 
	
///// ITEMS PARSE	
//	$ITEMS_INI = array(	'list' 		=> $list_name,
//						'rs_name' 	=> "structslist",
//						'template'	=> "contentslist",
//						'sys'		=> 1,
//	 					);
//
//	$html .= list_parse($ITEMS_INI);		

///// ITEMS NAV	
//	$ITEMS_NAV = array(	'list' 		=> $list_name,
//						
//	 					);
//
//	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>