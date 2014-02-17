<?php 


	$list_name 	= "news_small";
	$root		= 'all';//"all"33;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}
	
/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "news",
					'limit' 	=> 5,
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
						'mod'		=> 'mod_news',
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> 'newssmalllist',
						'form'		=> 0,
						'more'		=> array("plus...", "more..."),
						'more_page'	=> 'news',
						'mod'		=> 'mod_news',
	 					);

	//if (PAGE_NAME != 'news') {
		$html .= list_parse($ITEMS_INI);	
	//}		
//e($html);
/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>