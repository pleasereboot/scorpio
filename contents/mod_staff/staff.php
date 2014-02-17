<?php 

	$list_name 	= "stafflist";
	$root		= 35; 
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI
	$INI = array(	'list' 				=> $list_name,
					'table' 			=> "users",
					'limit' 			=> 12,
					//'root' 			=> $list_root,
					'page' 				=> "nosartistes",
					'mod' 				=> "staff",
					'in_groups' 		=> array(5675),
					'new_pid'			=> 35,
					);

	list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 				=> $list_name, 
						'template'			=> "staff",
						'type' 				=> "cats",
						'catlist'   		=> $list_name,
						//'page' 				=> "artists",
						'mod'				=> "mod_staff",
						
						);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 					=> $list_name, 
						'type' 					=> "cats",
						'rs_name' 				=> $list_name,
						'template'				=> "staff",
						'form'					=> 0,
						'parent'				=> "false",
						'no_item_show'			=> "false",
						'mod'					=> "mod_staff",
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 					=> $list_name,
						'rs_name' 				=> $list_name,
						'template'				=> "staff",
						'add' 					=> "true",
						'no_item_show'			=> "false",
						'mod'					=> "mod_staff",
						'new_name'   			=> 'AJOUTER UN ARTISTE',
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> "staff",
						'mod'		=> "mod_staff",
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>