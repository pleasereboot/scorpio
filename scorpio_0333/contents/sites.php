<?php 


	$list_name 	= "siteslist";
	//$root		= 35;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

	//if (!is_allowed(6)) {
		$site_id = $CORE['SITE']['id'];
	//}



/// ITEMS ZOOM PARSE
	$ZOOM_INI = array(	'list' 		=> $list_name . "_zoom",
						'table' 	=> "sites",
						'root' 		=> "no",
						'db' 		=> -1,
						'limit'		=> 1,
						'item_id' 	=> $site_id,
	 				
						);

	$GENRE = list_ini($ZOOM_INI);
		
	$ZOOMPARSE_INI = array(	'list' 			=> $list_name . "_zoom",
							'rs_name' 		=> $list_name,
							'template'		=> $list_name,
							'sys'			=> 1,
							'fields_add'	=> 1,
							'items_mode'	=> "zoom",
	 						);

	$html .= list_parse($ZOOMPARSE_INI);	

	if (is_allowed(6)) {
	/// LIST INI
		$INI = array(	'list' 		=> $list_name,
						'table' 	=> "sites",
						'root' 		=> "no",
						'db' 		=> -1,
						'limit'		=> 50,
						//'item_id' 	=> $site_id,
						
						);
	
		$GENRE = list_ini($INI);
		
	/// ITEMS PARSE	
		$ITEMS_INI = array(	'list' 			=> $list_name,
							'rs_name' 		=> $list_name,
							'template'		=> $list_name,
							'sys'			=> 1,
							'fields_add'	=> 1,
							);
	
		$html .= list_parse($ITEMS_INI);		
	}
	
/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>