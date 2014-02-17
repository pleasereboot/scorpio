<?php 


	$list_name 	= "bloglist";
	$root		= "34";
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}
	
/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "news",
					'limit' 	=> 10,
					'order' 	=> "cdate",
					'order_dir'	=> "DESC",
	 				'root' 		=> $list_root,
					'page' 		=> "news",
					'new'	    => "newslist",
					);

	$GENRE = list_ini($INI);

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'form'		=> 0,
						'order' 	=> "order",
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "news",
						
	 					);

	//$html .= list_nav($ITEMS_NAV);	
	
/// ITEMS NEW	
	$NEW_INI = array(	'list' 		=> $list_name, 
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
	 					);

	//$html .= list_new($NEW_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> $list_name,
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>