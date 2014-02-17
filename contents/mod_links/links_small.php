<?php 


	$list_name 	= "linksmalllist";
	$root		= 5370;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}
	
/// LIST INI
	$INI = array(	'list' 			=> $list_name,
						'table' 		=> 'news',
						'limit' 			=> 2,
						//'order' 		=> 'cdate',
						//'order_dir'	=> 'DESC',
						'root' 		=> $list_root,
						'page' 		=> 'liens',
						'new'	    	=> 'linksmalllist', 
						'form'	    	=> 0,
						'mode'	    => 'list',
						);

			
	
						
	$GENRE = list_ini($INI);

/// ITEMS NEW	
	$NEW_INI = array(	'list' 			=> $list_name, 
								'rs_name' 	=> $list_name,
								'template'	=> $list_name,
								);

	//$html .= list_new($NEW_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 				=> $list_name,
									'rs_name' 		=> $list_name,
									'template'		=> $list_name,
									'mod'				=> 'mod_links',
									'more'			=> array("plus...", "more..."),
									'more_page'	=> 'liens',
									'struct'			=> 'false',
									'add'				=> 'false',
									
									);

	
	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 			=> $list_name,
									'template'	=> $list_name,
									'mod'			=> 'mod_links',
									);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>