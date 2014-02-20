<?php 


	$list_name = "contentslist";
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = 0;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "contents",
					'limit' 	=> 5000,
	 				'root' 		=> $list_root,

					);

	$GENRE = list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> "contentslist",
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "admin_layouts",

	 					);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> "layoutslist",
						'template'	=> "contentslist",
						'sys'		=> 1,
						'form'		=> 0,
	 					);

	$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> "layoutslist",
						'template'	=> "contentslist",
						'sys'		=> 1,
						
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'catlist'	=> 'layoutslist',
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>