<?php 


	$list_name 	= "linkslist";
	$root		= 5370;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}
	
/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 		=> 'news',
					'limit' 			=> 20,
					//'order' 		=> 'cdate',
					//'order_dir'	=> 'DESC',
	 				'root' 		=> $list_root,
					'page' 		=> 'liens',
					'new'	    	=> 'linkslist',
					'form'	    	=> 0,
					'where'			=> '`order` > 1000',
					);

	$GENRE = list_ini($INI);

/// ITEMS NEW	
	$NEW_INI = array(	'list' 		=> $list_name, 
						'rs_name' 		=> $list_name,
						'template'		=> $list_name,
	 					);

	//$html .= list_new($NEW_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 			=> $list_name,
						'template'			=> $list_name,
						'mod'					=> 'mod_links',
	 					);

	
	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'			=> $list_name,
						'mod'					=> 'mod_links',
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>