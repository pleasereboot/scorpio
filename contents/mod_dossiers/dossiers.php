<?php 


	$list_name 	= "dossierslist";
	$root		= 3363;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// NAVIGATION
	$dossierslist_item_id = $_GET['dossierslist_item_id'];

	$dossiers_nav .= "<br /><br />";
	$dossiers_nav .= "<a href=\"?p=dossiers_all\">LISTE</a>&nbsp;|&nbsp;"; 
	if ($dossierslist_item_id != "") {$dossiers_nav .= "<a href=\"?p=dossiers_all&mode=form_all&dossierslist_item_id=$dossierslist_item_id&dossierslist_mod_dossiers_edit=$dossierslist_item_id\">FORMULAIRE</a>&nbsp;|&nbsp;";}
	if ($dossierslist_item_id != "") {$dossiers_nav .= "<a href=\"?p=dossiers_all&mode=view_infos&dossierslist_item_id=$dossierslist_item_id\">INFORMATIONS</a>&nbsp;|&nbsp;";}
	if ($dossierslist_item_id != "") {$dossiers_nav .= "<a href=\"?p=dossiers_all&mode=view_inspect&dossierslist_item_id=$dossierslist_item_id\">INSPECTION</a>";}
	$dossiers_nav .= "<br /><br />";

	$html .= $dossiers_nav;		

	switch (mode_get()) {
		case "form_all":
		/// LIST INI
			$INI = array(	'list' 		=> $list_name,
							'table' 	=> "mod_dossiers",
							'limit' 	=> 1,
							'root' 		=> $list_root,
							'page' 		=> "dossiers_all",
							);
		
			list_ini($INI);

		/// ITEMS NAV	
			$ITEMS_NAV = array(	'list' 		=> $list_name,
								'template'	=> "dossiers",
								'mod'		=> "mod_dossiers",
								);
		
			$html .= list_nav($ITEMS_NAV);	
			
		/// ITEMS PARSE	
			$ITEMS_INI = array(	'list' 			=> $list_name,
								'rs_name' 		=> $list_name,
								'template'		=> "dossiers",
								//'add' 			=> "true",
								'mod'			=> "mod_dossiers",
								'fields_add'	=> 1,
								//'form'			=> 0,
								);
		
			$html .= list_parse($ITEMS_INI);		
		

			break;	
			
		case "view_infos":
		/// LIST INI
			$INI = array(	'list' 		=> $list_name,
							'table' 	=> "mod_dossiers",
							//'limit' 	=> 1,
							'root' 		=> $list_root,
							'page' 		=> "dossiers_all",
							'mode' 		=> "zoom",
							
							);
		
			list_ini($INI);

		/// ITEMS NAV	
			$ITEMS_NAV = array(	'list' 		=> $list_name,
								'template'	=> "dossiers",
								'mod'		=> "mod_dossiers",
								);
		
			$html .= list_nav($ITEMS_NAV);	
			
		/// ITEMS PARSE	
			$ITEMS_INI = array(	'list' 			=> $list_name,
								'rs_name' 		=> $list_name,
								'template'		=> "dossiers",
								//'add' 			=> "true",
								'mod'			=> "mod_dossiers",
								'fields_add'	=> 1,
								'form'			=> 0,
								);
		
			$html .= list_parse($ITEMS_INI);		
			
			break;	

		case "view_inspect":
		/// LIST INI
			$INI = array(	'list' 		=> $list_name,
							'table' 	=> "mod_dossiers",
							//'limit' 	=> 1,
							'root' 		=> $list_root,
							'page' 		=> "dossiers_all",
							'mode' 		=> "zoom",
							
							);
		
			list_ini($INI);

		/// ITEMS NAV	
			$ITEMS_NAV = array(	'list' 		=> $list_name,
								'template'	=> "dossiers",
								'mod'		=> "mod_dossiers",
								);
		
			$html .= list_nav($ITEMS_NAV);	
			
		/// ITEMS PARSE	
			$ITEMS_INI = array(	'list' 			=> $list_name,
								'rs_name' 		=> $list_name,
								'template'		=> "dossiers_inspect",
								//'add' 			=> "true",
								'mod'			=> "mod_dossiers",
								'fields_add'	=> 1,
								'form'			=> 0,
								);
		
			$html .= list_parse($ITEMS_INI);		
			
			break;	
			
		default:
		/// LIST INI
			$INI = array(	'list' 		=> $list_name,
							'table' 	=> "mod_dossiers",
							'limit' 	=> 12,
							'root' 		=> $list_root,
							'page' 		=> "dossiers_all",
							);
		
			list_ini($INI);
			
		/// ITEMS PARSE	
			$ITEMS_INI = array(	'list' 			=> $list_name,
								'rs_name' 		=> $list_name,
								'template'		=> "dossiers",
								'add' 			=> "true",
								'mod'			=> "mod_dossiers",
								'fields_add'	=> 1,
								'form'			=> 0,
								);
		
			$html .= list_parse($ITEMS_INI);		
		
		/// ITEMS NAV	
			$ITEMS_NAV = array(	'list' 		=> $list_name,
								'template'	=> "dossiers",
								'mod'		=> "mod_dossiers",
								);
		
			$html .= list_nav($ITEMS_NAV);	
			break;	
									
	}


/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "mod_dossiers",
					'limit' 	=> 12,
	 				'root' 		=> $list_root,
					'page' 		=> "dossiers_all",
					);

	//list_ini($INI);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> "dossiers",
						'type' 		=> "cats",
						'catlist'   => $list_name,
						'page' 		=> "dossiers_all",
						'mod'		=> "mod_dossiers",
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> "dossiers",
						'form'		=> 0,
						'parent'	=> "false",
						'mod'		=> "mod_dossiers",
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 			=> $list_name,
						'rs_name' 		=> $list_name,
						'template'		=> "dossiers",
						'add' 			=> "true",
						'mod'			=> "mod_dossiers",
						'fields_add'	=> 1,
	 					);

	//$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> "dossiers",
						'mod'		=> "mod_dossiers",
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>