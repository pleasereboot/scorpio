<?php 


//'table' 	=> "cart",
//'list' 		=> $list_name,

	$INI = array(	
					
					'limit' 	=> 20,
	 				'root' 		=> $list_root,
					'page' 		=> "cart",
					'order' 	=> "cdate",
					'select' 	=> "*",
					);

	$NEWLIST_ = new slist("genre", $INI);

	//$NEWLIST_->set_ini('dede', 'fanfan');
	//$NEWLIST_->set_ini('GENRE', $INI);

	e($NEWLIST_->INI);	




//	$list_name = "contentslist";
//
///// LIST INI
//	$INI = array(	'list' 		=> $list_name,
//					'table' 	=> "contents",
//					'limit' 	=> 50,
//	 				'root' 		=> "0"
//					);
//
//	$GENRE = list_ini($INI);
//
///// CATS PARSE	
//	$CATS_INI = array(	'list' 		=> $list_name, 
//						'type' 		=> "cats",
//						'rs_name' 	=> $list_name,
//						'template'	=> $list_name,
//						'sys'		=> 1,
//	 					);
//
//	$html .= list_parse($CATS_INI);	
//	
///// ITEMS PARSE	
//	$ITEMS_INI = array(	'list' 		=> $list_name,
//						'rs_name' 	=> $list_name,
//						'template'	=> $list_name,
//						'sys'		=> 1,
//	 					);
//
//	$html .= list_parse($ITEMS_INI);		
//
///// ITEMS NAV	
//	$ITEMS_NAV = array(	'list' 		=> $list_name
//	 					);
//
//	$html .= list_nav($ITEMS_NAV);	
//
///// RETURN	
//	$return = $html;//print_r($GENRE, 1);
	
?>