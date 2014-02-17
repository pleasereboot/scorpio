<?php 


	$list_name 	= "albumlist";
	$root		= 710;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "album",
					'limit' 	=> 12,
	 				'root' 		=> $list_root,
					'page' 		=> "album",
					'no_item_show'	=> 'false',
					
					);

	list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> "cats",
						'catlist'   => $list_name,
						'page' 		=> "album",
						
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 			=> $list_name, 
						'type' 			=> "cats",
						'rs_name' 		=> $list_name,
						'template'		=> $list_name,
						'form'			=> 0,
						'parent'		=> "false",
						'no_item_show'	=> "false",
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'add' 		=> "true",
						'no_item_show'	=> 'false', 
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> $list_name,
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>