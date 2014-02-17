<?php 


	$list_name 	= "cowslist";
	$root		= 370;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "farm_cows",
					'limit' 	=> 20,
	 				'root' 		=> $list_root,
					'page' 		=> "cows",
					//'order' 	=> "label_fr",
					'mod' 		=> "mod_farm",
					);

	list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> "cats",
						'page' 		=> "cows",
						'mod' 		=> "mod_farm",
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'form'		=> 0,
						'mod' 		=> "mod_farm",
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'mod' 		=> "mod_farm",
						//'col_num' 	=> 1, 
						
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> $list_name,
						'mod' 		=> "mod_farm", 
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>