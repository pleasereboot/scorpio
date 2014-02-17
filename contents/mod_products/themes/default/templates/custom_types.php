<?php 

	function prod_colors($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;

		$PAR 				= explode_par($par);
		
		$COLOR_IDS = explode('||' , $AC['color']);
		
		$html  = "<table align=\"center\" ><tr>";
		
		foreach ($COLOR_IDS as $color_id) {
			$img = '<img src="' . strtolower($LIST['colors']['DATA'][$id][$color_id]['title_fr']) . '.jpg"/>';
			$html .= "<td align=\"center\" width=\"40\"><strong><font size=\"-1\">$img</font></strong></td>";
		}
			 
		$html  .= "</tr></table>";


//		$page 		= qs_load();
//		$list_name 	= $AC['list_name'];
//		$id 		= $AC['id'];
//		$table  	= $AC['table'];
//		$pid		= explode_pid($AC['pid']);
//
//		$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&" . $list_name . "_$table" . "_edit=$id". "&mode=form_all";
//		$return .= "<a href=\"$page$action\"><b>mod</b></a> | ";
//
//		$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&mode=view_infos";
//		$return .= "<a href=\"$page$action\"><b>vis</b></a> | ";		
//
//		$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&mode=view_inspect";
//		$return .= "<a href=\"$page$action\"><b>ins</b></a> | ";
//
//		$action	= $list_name . "_$table" . "_dup=$id";
//		$return .= "<a href=\"?p=dossiers_all&$action\"><b>dup</b></a> | ";			
//
//		$action = $list_name . "_$table" . "_del=$id";
//		$return .= "<a href=\"?p=dossiers_all&$action\"><b>sup</b></a>";	

		//$return = "<a href=\"?p=search_process&date_dep=$date_depart&gateway_dep=YUL&duration=7&dest_dep=$hotel_dest&flex=Y&engines=S&target=_self&language=fr&all_inclusive=Y&price_max=9999&no_hotel=$hotel_id\" target=\"_blank\">$label</a>";	

		$return = $html;

		set_function("prod_colors", $field_name);
		return $return;
	}

	function dossiers_admin($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;

		$PAR 				= explode_par($par);
		
		$page 		= qs_load();
		$list_name 	= $AC['list_name'];
		$id 		= $AC['id'];
		$table  	= $AC['table'];
		$pid		= explode_pid($AC['pid']);

		$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&" . $list_name . "_$table" . "_edit=$id". "&mode=form_all";
		$return .= "<a href=\"$page$action\"><b>mod</b></a> | ";

		$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&mode=view_infos";
		$return .= "<a href=\"$page$action\"><b>vis</b></a> | ";		

		$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&mode=view_inspect";
		$return .= "<a href=\"$page$action\"><b>ins</b></a> | ";

		$action	= $list_name . "_$table" . "_dup=$id";
		$return .= "<a href=\"?p=dossiers_all&$action\"><b>dup</b></a> | ";			

		$action = $list_name . "_$table" . "_del=$id";
		$return .= "<a href=\"?p=dossiers_all&$action\"><b>sup</b></a>";	

		//$return = "<a href=\"?p=search_process&date_dep=$date_depart&gateway_dep=YUL&duration=7&dest_dep=$hotel_dest&flex=Y&engines=S&target=_self&language=fr&all_inclusive=Y&price_max=9999&no_hotel=$hotel_id\" target=\"_blank\">$label</a>";	

		set_function("type_testinput", $field_name);
		return $return;
	}

	
?>