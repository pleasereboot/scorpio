<?php 

	$list_name 	= "arealist";
	$root		= 5881;
	
	//if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}


/// AREA
/// LIST INI
	$CAT_INI = array(	'list' 				=> $list_name,
						'table' 			=> "contents",
						'limit' 			=> 50,
						'root' 				=> $root,
						'order'				=> 'label_fr',
						'order_dir'			=> 'ASC',
						);

	$GENRE = list_ini($CAT_INI);

/// CATS PARSE	
	$CATS_INI = array(	'list' 				=> $list_name, 
						'type' 				=> 'cats',
						'rs_name' 			=> $list_name,
						'template'			=> 'clientslist',
						'mod'				=> 'mod_products',
						'col_num'			=> 2,
						'parent'			=> 'false',
						//'sys'				=> 1,
						'form'				=> 0,
						);

	$html .= list_parse($CATS_INI);



/// CUSTOMERS
	$list_name 	= "clientslist";
	$root		= 5881;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}
	$area_id = $_GET['arealist_item_id'];

	if (isset($_GET['arealist_item_id'])) {$new_pid = $_GET['arealist_item_id'];} else {$new_pid = $root;}

/// LIST INI
	$INI = array(	'list' 					=> $list_name,
						'table' 			=> "users",
						'limit' 			=> 50,
						//'root' 			=> $list_root,
						'allowed' 			=> 1,
						'where'				=> "id > 100 AND area = '$area_id' ",
						'page' 				=> "nosclients",
						'in_groups' 		=> array(5780),
						'order'				=> 'company',
						'order_dir'			=> 'ASC',
						'new_pid'			=> $new_pid,
						);

	$GENRE = list_ini($INI);
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 				=> $list_name,
						'rs_name' 			=> $list_name,
						'template'			=> 'clientslist',
						'mod'				=> 'mod_products',
						'sep'				=> true, 
						);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 				=> $list_name,
						'template'			=> 'clientslist',
						);

	$html .= list_nav($ITEMS_NAV);

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>