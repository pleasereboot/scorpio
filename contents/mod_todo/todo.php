<?php 

	

/// INI
	global $SCORPIO;
	global $LIST;
	
	$SCORPIO->ini_classes(array('items'));
	
/// CATS	
	$CATS = new items(array('list' => 'todocats'));
	
	$CATS->parse();	

	$html .= $CATS->html;	
	
/// ITEMS	
	$ITEMS = new items($PAR);
	
	$ITEMS->parse();	

	$html .= $ITEMS->html;

/// ITEMS ZOOM	
	$ITEMS = new items(array('list' => 'todolist', 'mode' => 'zoom'));
	
	$ITEMS->parse();	

	$html .= $ITEMS->html;



	$list_name 	= 'todolist';
	$root		= 4980;

	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> 'todo_tasks',
					'limit' 	=> 12,
	 				'root' 		=> $list_root,
					'page' 		=> 'todo',

					);

	list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> 'cats',
						'catlist'   => $list_name,
						'page' 		=> 'todo',
						'mod'		=> 'mod_todo',
						
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 			=> $list_name, 
						'type' 			=> 'cats',
						'rs_name' 		=> $list_name,
						'template'		=> $list_name,
						'form'			=> 0,
						'parent'		=> 'false',
						'mod'			=> 'mod_todo',
						'no_item_show'	=> 'false',
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'add' 		=> 'true',
						'mod'		=> 'mod_todo',

	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> $list_name,
						'mod'		=> 'mod_todo',
						'page' 		=> 'todo',
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>