<?php 


	$list_name 	= "customers";
	$root		= 35;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "users",
					'limit' 	=> 50,
	 				'root' 		=> $list_root,
					'allowed' 	=> 1,
					'where'		=> 'id > 100',
					'page' 		=> "admin_customers",
					'ci_name'   => 'defaultlist'
					);

	$GENRE = list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> "customers",
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "admin_customers",
						
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> "customers",
						'sys'		=> 1,
						'form'		=> 0,
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> "customers",
						'mod'		=> "mod_products",
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> "customers",
	 					);

	$html .= list_nav($ITEMS_NAV);

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>