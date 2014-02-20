<?php 


	$list_name 	= "userslist";
	$root		= 35;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI

	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "users",
					'limit' 	=> 50,
	 				'root' 		=> 'ALL',
					'allowed' 	=> 1,
					'ci_name'   => 'userslist',
					'page' 		=> "admin_users",
					);

	if(!is_allowed(6)) {
		$INI['where'] = 'id > 100';
	}					
					
					
	$GENRE = list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> "users",
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "admin_users",
						
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> "users",
						'sys'		=> 1,
						'form'		=> 0,
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> "users",
						'sys'		=> 1,
						'mod'		=> "mod_admin",
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> "users",
	 					);

	$html .= list_nav($ITEMS_NAV);

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>