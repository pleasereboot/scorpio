<?php 


	$list_name = "newslist";

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "news",
					'limit' 	=> 10,
	 				'root' 		=> 33
					);

	$GENRE = list_ini($INI);

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>