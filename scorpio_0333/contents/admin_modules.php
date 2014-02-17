<?php 
	
	global $CORE;
	global $LIST;


/// GET FOLDERS
	$SITE_DIR 		= dir_scan(SITE_CONTENTS_PATH);
	$SCORPIO_DIR 	= dir_scan(SCORPIO_CONTENTS_PATH);

/// GET REGISTRED MODULES
	$CORE_MODULES = tree(3100);
	
	foreach ($CORE_MODULES['CHILDS'] as $MODULE) {
		$REGISTRED_MODULES[] = $MODULE['name'];
	}


/// VALID REGISTRED MODULES 
	foreach ($SITE_DIR['FOLDERS'] as $folder) {
		if (in_array($folder,$REGISTRED_MODULES)) {
			$message = " enregistré";
				
		}
		
		$return .= $folder . $message . "<br>";
	}




	$list_name = "contentslist";
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = 0;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "contents",
					'limit' 	=> 5000,
	 				'root' 		=> $list_root,
					);

	$GENRE = list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> "contentslist",
						'type' 		=> "cats",
						'sys'		=> 1,
						'page' 		=> "admin_modules",
						
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> "layoutslist",
						'template'	=> "contentslist",
						'sys'		=> 1,
						'form'		=> 0,
	 					);

	$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> "layoutslist",
						'template'	=> "contentslist",
						'sys'		=> 1,
	 					);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return .= $html;//print_r($GENRE, 1);
	
?>