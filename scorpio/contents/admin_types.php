<?php 


	$list_name 	= "typeslist";
	//$root		= 35;
	
	//if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}


/// LIST INI
	$INI = array(	'list' 			=> $list_name,
					'table' 		=> "types",
					'root' 			=> "no",
					'db' 			=> -1,
					'limit'			=> 500,
					'order' 		=> "order",
					'order_dir'		=> "DESC",					
					//'item_id' 	=> $site_id,
	 				
					);

	$GENRE = list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "admin_types",
						
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'sys'		=> 1,
						'form'		=> 0,
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 			=> $list_name,
						'rs_name' 		=> $list_name,
						'template'		=> $list_name,
						'sys'			=> 1,
						'fields_add'	=> 1,
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>