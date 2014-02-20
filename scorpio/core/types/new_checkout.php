<?php 

	/* SCORPIO engine - checkout.php - v3.23		*/	
	/* created on 2006-12-09 						*/
	/* updated on 2008-05-21 						*/	
	/* YYY	1637/869/1299/840/2376					*/




	function co_text_deco($INI) {
		global $CORE;

					

		set_function("co_text_deco", $field_name);
		return $return;
	}

	
	function co_url($INI) {
		global $CORE;
		
		$label	= $INI['uv'];
		$url 	= '?p=' . PAGE_NAME . '&' . $INI['listname'] . '_id=' . $INI['AR']['id'];

		if ($INI['SEED']['parent_list'] != $INI['listname'] && $_GET[$INI['SEED']['parent_list'] . '_id'] != '') {
			$url .= '&' . $INI['SEED']['parent_list'] . '_id=' . $_GET[$INI['SEED']['parent_list'] . '_id']; 
		}

		$return = url($label, $url);
		
		set_function("co_url", $AC['name']);
		return $return; 
	}	
	
	function co_sys_admin($INI) {
		global $CORE;
		global $SCORPIO;
		
		$PAR = explode_par($par);	

		//$page 		= qs_load();
		$list_name 	= $INI['listname'];
		$id 		= $INI['AR']['id'];
		//$table  	= $AR['table'];
		//$pid		= explode_pid($AC['pid']);

	/// delete
		if ((!isset($PAR['delete']) && is_allowed(5)) || (isset($PAR['delete']) && is_allowed($PAR['delete']))) {
			$action = $list_name . "_$table" . "_del=$id";
			$return .= "<a href=\"$page&$action\">" . I_DEL . " </a>";
		}
		
	/// tree delete
//		if ((!isset($PAR['delete']) && is_allowed(6)) || (isset($PAR['delete']) && is_allowed($PAR['delete']))) {
//			$action = $list_name . "_$table" . "_del=$id";
//			$return .= "<a href=\"$page&$action\">" . I_DEL . " </a>";
//		}
		
	/// duplicate	
		if ((!isset($PAR['dup']) && is_allowed(5)) || (isset($PAR['dup']) && is_allowed($PAR['dup']))) {
			$action	= $list_name . "_$table" . "_dup=$id";
			$return .= "<a href=\"$page&$action\">" . I_DUP . " </a>";
		}

	/// edit	
		if ((!isset($PAR['edit']) && is_allowed(5)) || (isset($PAR['edit']) && is_allowed($PAR['edit']))) {
			$page 		= PAGE_NAME;
			$action	= $list_name . "_edit=" . $id;
			$return .= "<a href=\"?p=$page&$action\">" . I_EDIT . " </a>"; 
		}
	
	/// export struct	
//		if ((!isset($PAR['edit']) && is_allowed(6)) || (isset($PAR['edit']) && is_allowed($PAR['edit']))) {
//			$page 		= qs_load();
//			$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&" . $list_name . "_$table" . "_edit=$id";
//			$return .= "<a href=\"$page&$action\">" . I_EDIT . " </a>";
//		}	
	
		set_function("type_custom", $AC['name']);
		return $return;
	}
	
	

//	function co_forminput($INI) {
//		global $CORE;
////
////		$PAR 				= explode_par($par);
////
////		if ($PAR['ac'] == "true") {$source = $AC[$field_name];} else {$source = $HTML[$field_name];}
////		if ($PAR['type'] == "password") {$type = "password";} else {$type = "text";}
////		if (isset($PAR['disable']) && !is_allowed($PAR['disable'])) {$disable = " disabled";} else {$disable = "";}
//// 
////		$content			= format_rte($source,1);
////		$content 			= str_replace('"', "''", $content);
////		$width 				= $PAR['width'];
////
////	/// FILL TEMPLATE		
////		$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
////		$form_input_html 	= t_set_block ("form_items_new", "INPUT");
////		
////
////		$FORM_VARS	= array("FIELD_LABEL"			=> $TYPE_PAR[lang("label")], 
////							"FIELD_VALUE" 			=> $content,
////							"NAME"					=> $field_name . "-" . $AC['id'],
////							"SIZE"					=> $width, 
////							"MAX"					=> "",
////							"DISABLE"				=> $disable,
////							"TYPE"					=> $type, // password
////							//"FIELD_ADMIN_NAME"		=> $field_admin,
////							//"FIELD_ADMIN_VALUE"		=> $field_admin,
////							);	
////		
////		$return	 			= set_var($form_input_html, $FORM_VARS);					
////
////		set_function("type_testinput", $field_name);
////		return $return;
//	}
//
//	function co_url($INI) {
//	//e($INI);
//		//$INI['uv'] = $INI['af'] * $INI['AR']['_INI']['level'];
//		$url_href = '?p=new_scorpio&' . $INI['listname'] . '_cid=' . $INI['av'];
//		$INI['uv'] = "<a href=\"$url_href\">" . $INI['av'] . '</a>';
//	}
//
//	function co_textstyle($INI) {
//		//$INI['uv'] = $INI['af'] * $INI['AR']['_INI']['level'];
//		$INI['uv'] = '<b>' . $INI['av'] . '</b>';
//	}
//
//	function co_date($INI) {
//		if (isset($INI['PAR']['str'])) {
//			$date_str = $INI['PAR']['str'];  //'Y-m-d\ H\hi\:s'
//		} else {
//			$date_str = 'Y-m-d\ H\hi';
//		}
//		
//		$INI['uv'] = date($date_str, $INI['av']); //'Y-m-d\ \- \  H\ \h i \ \: \  s'	
//	}
				
?>