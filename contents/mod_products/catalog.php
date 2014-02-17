<?php 



	$DB = new db();
	
/// PREPEND PRODUCTS TYPES AND STYLES
	//include_once('products_prepend.php');
	//include_once('custom_types.php');
	
	$list_name 	= 'cataloglist';
	$root		= 3776;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}
	if (isset($PAR['page_root'])) {$page_root = $PAR['page_root'];} else {$page_root = $_GET['p'];}	

/// LIST INI
	$INI = array(	'list' 			=> $list_name,
					'table' 		=> 'prod_products',
					'limit' 		=> 12,
	 				'root' 			=> $list_root,
					'page' 			=> $page_root,
					'mod'			=> 'mod_products',
					//'select'		=> 'style,img',
					'group'			=> 'style',
					'order'			=> 'name',
					'order_dir'		=> 'desc',
					);

	list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> 'cats',
						'catlist'   => $list_name,
						'page' 		=> $page_root,
						'mod'		=> 'mod_products',
						
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 			=> $list_name, 
						'type' 			=> 'cats',
						'rs_name' 		=> $list_name,
						'template'		=> $list_name,
						'form'			=> 0,
						'parent'		=> 'false',
						'mod'			=> 'mod_products',
						'no_item_show'	=> 'false',
	 					);

	$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 			=> $list_name,
						'rs_name' 		=> $list_name,
						'template'		=> $list_name,
						'add' 			=> 'true',
						'mod'			=> 'mod_products',
						'no_item_show'	=> 'false',
						'form'			=> 0,
						'splash'		=> 1,
						
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> $list_name,
						'mod'		=> 'mod_products',
						'page' 		=> $page_root,
						'splash'	=> 1,
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>