<?php 

	/* SCORPIO engine - checkout.php - v3.22		*/	
	/* created on 2006-12-09 						*/
	/* updated on 2008-04-01 						*/	
	/* YANNICK MENARD	1637/869/1299/840/2376		*/


	function type_piasses($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		$PAR = explode_par($par);

		$return = number_format($AC[$field_name], 2, '.', '') . ' $';

		return $return;
	}



	function type_sys_selector_news($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout réécrire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;

		$PAR = explode_par($par);

		$id			= $AC['id'];

		$TYPES[1] = array('id' => 1, 'label_fr' => 'actualités');
		$TYPES[2] = array('id' => 2, 'label_fr' => 'a la une');
		$TYPES[3] = array('id' => 3, 'label_fr' => 'communiqués');
		$TYPES[4] = array('id' => 4, 'label_fr' => 'chroniques');
		$TYPES[5] = array('id' => 5, 'label_fr' => 'mini liste');
		$TYPES[6] = array('id' => 6, 'label_fr' => 'consommation');

		$SELECTED = explode('||', $AC['type']);
//	//e($SELECTED);
		if ($SELECTED[0] == '') {
			if ($PAR['default'] != '') {
				$SELECTED = $PAR['default'];
			}
		}
//
//		$GROUPS  = tree(1193);
//
		foreach ($TYPES as $TYPE) {
			//if (is_allowed($GROUP['allowed']) || is_allowed(6)) {
				$SELECT_LIST[] = $TYPE;
			//}
		}

		$select .= select_build($SELECT_LIST, 'selectortypes', 'id', 'label_fr', $field_name . "-" . $id, $SELECTED, $blank=false, count($SELECT_LIST));

	 // FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR");

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")],
							"FIELD_VALUE" 		=> $select,
							"NAME"				=> $field_name . "-" . $AC['id'],
							);

		$return	 			= set_var($form_selector_html, $FORM_VARS);

		set_function("type_sys_selector_news", $field_name);
		return $return;
	}

	function type_query ($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		$DB = new db();
	
		$PAR = explode_par($par);
		
		$table = $PAR['table'];
		$lookup = $PAR['lookup'];
		$field = $PAR['field'];
		$value = $AC[$field_name];
		
		$query = "SELECT $field FROM $table WHERE $lookup = $value";
		
		$RESULT = $DB->select($query, 3);

		$return = $RESULT[$field];
		
	
		set_function("type_query", $field_name);
		return $return;	
	}
	
	function type_separator ($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		$PAR = explode_par($par);
		
		$class = strtoupper($PAR['class']);
	
		$return = "<hr class=\"$class \">";
		
	
		set_function("type_separator", $field_name);
		return $return;	
	}

	function type_sys_selector_groups($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rÃ©Ã©crire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		$id			= $AC['id'];
		
		$SELECTED = explode('||', $AC['groups']);
	//e($SELECTED);	
		if ($SELECTED[0] == '') {
			if ($PAR['default'] != '') {
				$SELECTED = $PAR['default'];
			}
		}
		
		$GROUPS  = tree2(1193);
		
		foreach ($GROUPS['CHILDS'] as $GROUP) {
			if (is_allowed($GROUP['allowed']) || is_allowed(6)) {
				$SELECT_LIST[] = $GROUP;
			}
		}

		$select .= select_build($SELECT_LIST, 'selectorgroups', 'id', 'label_fr', $field_name . "-" . $id, $SELECTED, $blank=false, count($SELECT_LIST));
			
	 // FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR");

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $select,
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);

		set_function("type_sys_selector_groups", $field_name);
		return $return;
	}	
	
	function type_pdf_link($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);
	
		$id = $AC['id'];
				
		if ($PAR['caption'] != '') {$caption = $AC[$field_name];}
		if ($PAR['icon'] != '' && $AC[$field_name] != '') {$label = '<img src="' . SCORPIO_IMAGES_PATH . 'icons/sys_pdf.gif" border="0" />' . ' ' . $caption;} else {$label = $AC[$field_name];}

		$return = url($label, 'files/' . $AC[$field_name]);

		set_function("type_pdf_link", $field_name);
		return $return;
	}

	function type_sys_selector_pdf($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);
	
		$id = $AC['id'];
		
		if (isset($PAR['db_field'])) {$field_name = $PAR['db_field'];} else {$field_name = "img";}
		if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
		//if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
		
		$SELECT_PAR['where'] = "`type` = 'application/pdf'";
		
				
		if (!isset($LIST['selector_image'])) {$LIST[$list_name] = db_select("files", $SELECT_PAR);}
		
		$DROP = $LIST[$list_name]['DATA'];	
		$DROP = array_order($DROP, lang('label'));
		
		if (isset($PAR['filter'])) {$FILTER = explode(",", $PAR['filter']);}
		
		$field_id = $field_name . "-" . $id;
		
		$select  = "<select name=\"$field_id\"$size onchange=\"image_switch(this.value,'preview_$field_id')\">";
		
		if ($PAR['none'] != "false") {$select .= "<option value=\"\"$selected> </option>";}
		
		foreach($DROP as $key => $DLIST) {
			$selected = "";	

			if ($AC[$field_name] == $DLIST['name']) {
				$selected = " selected";
			}
	
			$value = $DLIST['name'];
			$label = $DLIST[lang('label')];
			
			$select .= "<option value=\"$value\"$selected>$label</option>";
		}
		
		$select .= "</select>";
		$content = $select;	

	/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR_IMAGES");
		
		$IMG_NAME = explode(".", $AC[$field_name]);

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $content,
							//"IMAGE_PREVIEW" 	=> "<img src=\"files/" . $IMG_NAME[0] . "_m." . $IMG_NAME[1] . "\" id=\"preview_$field_id\" border=\"0\"/>",
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);
		
		reset($DROP);

		set_function("type_sys_selector_pdf", $field_name);
		return $return;
	}

	function type_sys_selector_types($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		$id			= $AC['id'];

		foreach ($LIST['types']['DATA'] as $TYPE) {
			$SELECT_LIST[] = $TYPE;
		}

		$select .= select_build($SELECT_LIST, 'selectortypes', 'id', 'name', $field_name . "-" . $id, $AC[$field_name], $blank=false);
			
	 // FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR");

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $select,
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);

		set_function("type_selector_list", $field_name);
		return $return;
	}	
	
	function type_sys_selector_allowed($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		$id			= $AC['id'];
		
		$SELECTED = explode(',', $AC['allowed']);
		
		foreach ($LIST['groups']['DATA'] as $GROUP) {
			if (is_allowed($GROUP['id']) || is_allowed(6)) {
				$SELECT_LIST[] = $GROUP;
			}
		}

		$select .= select_build($SELECT_LIST, 'selectorallowed', 'id', 'label_fr', $field_name . "-" . $id, $SELECTED, $blank=false, count($SELECT_LIST));
			
	 // FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR");

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $select,
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);

		set_function("type_selector_list", $field_name);
		return $return;
	}	
	
	function type_sys_par($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;

		$PAR 				= explode_par($par);

		if (1 == 1) {
			if ($PAR['ac'] == "true") {$source = $AC[$field_name];} else {$source = $HTML[$field_name];}
			if ($PAR['type'] == "password") {$type = "password";} else {$type = "text";}
	 
			$content			= format_rte($source,1);
			$content 			= str_replace('"', "''", $content);
			$width 				= $PAR['width'];
	
		/// FILL TEMPLATE		
			$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
			$form_input_html 	= t_set_block ("form_items_new", "INPUT");
			
	
			$FORM_VARS	= array("FIELD_LABEL"			=> $TYPE_PAR[lang("label")], 
								"FIELD_VALUE" 			=> $content,
								"NAME"					=> $field_name . "-" . $AC['id'],
								"SIZE"					=> $width, 
								"MAX"					=> "",
								"TYPE"					=> $type, // password
								//"FIELD_ADMIN_NAME"		=> $field_admin,
								//"FIELD_ADMIN_VALUE"		=> $field_admin,
								);	
			
			$return	 			= set_var($form_input_html, $FORM_VARS);					
		} else {
		/// PARENT PAGE PARSE	
			if (isset($PAR['rs'])) {$rs_id = $PAR['rs'];} else {$rs_id = 4905;}
			
			$THIS_PAR = explode_par($AC['par']);
			$RS_PAR = tree2($rs_id);
	
			foreach ($RS_PAR['CHILDS'] as $THIS_FIELD) {
				$field_name = $THIS_FIELD['name'];
				
				foreach ($THIS_FIELD['CHILDS'] as $THIS_TYPE) {
					$type_name = &$LIST['types']['DATA'][$THIS_TYPE['type']]['function'];

					if (function_exists($type_name)) { 
						$return .= @call_user_func($type_name, array($field_name => $THIS_PAR[$field_name]), array($field_name => $THIS_PAR[$field_name]), $THIS_TYPE['par'], $field_name, array('label_fr' => $field_name,'label_en' => $field_name, 'par_form' => true)) . "\n";
					} else {
						if (trim($type_name) != '') { //v3.25 gossait pas mal
							set_message("function_$type_name", "la function $type_name n'existe pas - content name : $field_name", 1);
						}
					}
				}				
			}			
		}

		set_function("type_testinput", $field_name);
		return $return;
	}

//	function type_prod_details($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
//		global $CORE;
//		
//		$VAR = &$CORE['VARS']['products'];
//		
//		$t_qty = $AC['size_xxs'] + $AC['size_xs'] + $AC['size_s'] + $AC['size_m'] + $AC['size_l'] + $AC['size_xl'] + $AC['size_xxl'] + $AC['size_1'] + $AC['size_3'] + $AC['size_5'] + $AC['size_7'] + $AC['size_9'] + $AC['size_11'] + $AC['size_13'] + $AC['size_15'] + $AC['size_17'] + $AC['size_19'];
//
//		//$return	 			= $t_qty;
//
//	//e(number_format($AC['product_price'], 2, '.', ''));
//
//		$HTML['product_qty']	= $t_qty;
//		$HTML['product_amount']	= number_format($t_qty * $AC['product_price'], 2, '.', '');
//		
//		$VAR['tps'] = $tps;
//		$VAR['tvq'] = $tvq;
//		
////e($HTML);
//		set_function("type_prod_amount", $field_name);
//		return $return;		
//	
//	}
//
//	function type_prod_totals($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
//		global $CORE;
//		
//		//$HTML['stotal'] = $CORE['VARS']['prod_stotal'];
//
//		set_function("type_prod_totals", $field_name);
//		//return $return;		
//	
//	}

	function type_sys_selector_user($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		$id			= $AC['id'];
		$list_name 	= $PAR['list'];
	
		$SELECT_PAR = array('order_by' => 'name');
		
		if($PAR['group'] != '') {$SELECT_PAR['in_groups'] = $PAR['group'];} //v3.32
		if($PAR['list'] != '') {$SELECT_PAR['list'] = $PAR['list'];} else {$SELECT_PAR['list'] = 'users';} //v3.32

		$LIST[$SELECT_PAR['list']] = db_select('users', $SELECT_PAR);
	//e($LIST[$SELECT_PAR['list']] );

		$select .= select_build($LIST[$SELECT_PAR['list']]['DATA'], $SELECT_PAR['list'], 'id', 'name', $field_name . "-" . $id, $AC[$field_name], $blank=false);

			
	/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR");

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $select,
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);

		set_function("type_selector_list", $field_name);
		return $return;
	}

	function type_sys_selector_list($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		$id			= $AC['id'];
		$list_name 	= $PAR['list'];
	
		if (isset($PAR['new'])) { 
			$select_id = $field_name . "-" . $id;

			$DROP_LIST = $LIST[$list_name]['DATA'];
			
			if (isset($PAR['key'])) {
				$drop_key = $PAR['key'];
			} else {
				if (!is_array(current($DROP_LIST))) {$DROP_LIST = sys_array($DROP_LIST);} // updated 3.28 to allow simple array list
		
				$drop_key = 'id';
			}	

			if (strstr($AC[$field_name],'||')) {$SELECTED = explode('||',$AC[$field_name]);} else {$SELECTED[] = $AC[$field_name];}
			if ($PAR['multiple'] == 'true') {
				if (isset($PAR['size'])) {$multiple = $PAR['size'];} else {$multiple=true;}
			}
 			
			$select = select_build($DROP_LIST, $select_id, $drop_key, 'title_fr', $select_id, $SELECTED, $blank=false, $multiple);
		} else {
			if (isset($SELECT["pid_contents"])) {
				
				//$SELECT['pid_contents']['header'] = "<select name=\"$field_name" . "-" . "$id\"$size>";
				
				//$select .= $SELECT['pid_contents']['header'];
				
				//e(implode("",$SELECT['pid_contents']['OPTIONS']));
				//$select .= implode("",$SELECT['pid_contents']['OPTIONS']);
				//$select .= $SELECT['pid_contents']['footer'];

				//$return = $select;	
			} else {			
				if (isset($PAR['output'])) {$field_name = $PAR['output'];}	
				if (!isset($PAR['field'])) {$PAR['field'] = "name";}
				if (!isset($PAR['table'])) {$PAR['table'] = "contents";}
				
				if (isset($PAR['root'])) {
					if (!isset($LIST["drop_" . $list_name])) {  // optimisï¿½ le 2007-10-17 
						if (isset($PAR['db'])) {
							$TREE = tree($PAR['root'], 0, array('db' => $PAR['db']));
						} else {
							$TREE = tree2($PAR['root']);
						}
						
						$LIST["drop_" . $list_name]['DATA'] = tree_to_list("sel_list", $TREE);
					}
					
					$DROP = $LIST["drop_" . $list_name]['DATA'];
				} else {
					if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
					if (isset($PAR['db'])) {$SELECT_PAR['db'] = $PAR['db'];}
					if (!isset($LIST[$list_name])) {$LIST[$list_name] = db_select($PAR['table'], $SELECT_PAR);}
					$DROP = $LIST[$list_name]['DATA'];	
				}
		
				if (isset($PAR['cat'])) {
					$cat = "|";
				}
				
				if (isset($PAR['order'])) {$DROP = array_order($DROP, $PAR['order']);}
				if (isset($PAR['size'])) {$size = " size=\"" . $PAR['size'] . "\"";}
				if (isset($PAR['filter'])) {$FILTER = explode(",", $PAR['filter']);}
				
				$select  = "<select name=\"$field_name" . "-" . "$id\"$size>";
				//$SELECT['pid_contents']['header'] = $select;
	
				if ($PAR['none'] != "false") {$select .= "<option value=\"\"$selected> </option>";}
				
				foreach($DROP as $key => $DLIST) {
					if (!isset($PAR['filter']) || (isset($PAR['filter']) && !in_array($DLIST['type'], $FILTER))) {
						if (!isset($PAR['allowed']) || (isset($PAR['allowed']) && is_allowed($DLIST['allowed']))) {				
							$selected = "";	
		
							if ($AC[$field_name] == $DLIST[$PAR['field']] || $AC[$field_name] == $cat . $DLIST['id'] . $cat || ($PAR['arr'] == "true" && $AC[$field_name] == $key)) {
								$selected = " selected";
							}
			
							if (isset($PAR['spacer'])) {$spacer = spacer($DLIST['level']);}
						
							if ($PAR['arr'] == "true") {  //look for array list	
								$label 	= $DLIST;
								$id  	= $key;
							} else {
								if ($key != "") {
									if (isset($PAR['parent'])) {
										if ($DROP[substr($DLIST['pid'], 1, -1)]['name'] != "") {
											$parent = $DROP[substr($DLIST['pid'], 1, -1)][lang("label")] . " - ";
										} else {
											$parent = "ROOT - ";
										}
										
										$pid = " ($key)";	
									}
									
									$label 	= $parent . $DLIST[$PAR['field']] . $pid;
									$id  	= $cat . $DLIST['id'] . $cat;
									
									if (isset($PAR['value'])) {// patch pour images
										//if (is_numeric($AC[$field_name])) {
										//	$id = $DLIST['id'];
										//} else {
											$id = $DLIST[$PAR['name']];
										//}
									}
								} else if ($key == "0" && $field_name == "pid") { // patch pour root
									$id = "|0|";
									$label 	= "SCORPIO";
								}				
							}	
							
							if ($label != "") {
								$select .= "<option value=\"$id\"$selected>$spacer$label</option>";
								//$SELECT['pid_contents']['OPTIONS'][$id] = "<option value=\"$id\">$spacer$label</option>";
							}
						}
					}
				}
				
				$select .= "</select>";
				
				reset($DROP);
			}		
		}	
			
	/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		if ($TYPE_PAR['par_form']) {$file_name = 'form_par_new';} else {$file_name = 'form_items_new';}
	
		$form_file_html 		= t_load_file($file_name, $file_name, true);	
		$form_selector_html 	= t_set_block ($file_name, 'SELECTOR');

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $select,
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);

		set_function("type_selector_list", $field_name);
		return $return;
	}

	function type_valuefromarray ($AC="", $html="", $par="", $field_name="", $TYPE_PAR="") {
		global $LIST;
		
		$PAR = explode_par($par);

		if (isset($LIST[$PAR['list']])) {
			$return = $LIST[$PAR['list']]['DATA'][$AC[$field_name]];
		}
	
		return $return;
	}

	function type_sys_admin($AC="", $html="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $SCORPIO;
		
		$PAR = explode_par($par);	

		$page 		= qs_load();
		$list_name 	= $AC['list_name'];
		$id 			= $AC['id'];
		$table  		= $AC['table'];
		$pid			= explode_pid($AC['pid']);

	/// delete
		if ((!isset($PAR['delete']) && is_allowed(5)) || (isset($PAR['delete']) && is_allowed($PAR['delete']))) {
			$action = $list_name . "_$table" . "_del=$id";
			$message = 'Voulez-vous vraiment supprimer cet item (' . $id . ' - ' . addslashes($AC[lang('label')]) . ') ?';
			$redirect = "$page&$action";
			
			if ($PAR['mod'] == 'products')  {$redirect .= '&mod=products';}
			
			$return .= "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_delete.png\" border=\"0\" alt=\"SUPPRIMER\" onclick=\"valid_delete('$message','$redirect');\" onMouseOver=\"this.style.cssText='cursor:hand'\" >";
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
			$page 		= qs_load();
			//$action	= "&" . $list_name . "_cat_id=" . $pid . "&" . $list_name . "_item_id=" . $id . "&" . $list_name . "_$table" . "_edit=$id";
			$action	= "&" . $list_name . "_$table" . "_edit=$id";
			$return .= "<a href=\"$page&$action\">" . I_EDIT . " </a>";
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

	function type_custom($AC="", $html="", $par="", $field_name="", $TYPE_PAR="") {
		set_function("type_custom", $AC['name']);
		return $return;
	}
	function type_text_input($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		$PAR 			= explode_par($par);
		
		if ($PAR['ac'] == "true") {$source = $AC[$field_name];} else {$source = $HTML[$field_name];}
 
		$content	= format_rte($source,1);
		$content 	= str_replace('"', "''", $content);

		$id 			= "-" . $AC['id'];
		
		if (isset($PAR['format']) && $PAR['format'] == 'float') {$content = number_format($content, 2, '.', '');}
		if (isset($PAR['size'])) {$size = " size=\"" . $PAR['size'] . "\"";}
		if (isset($PAR['class'])) {$class = " class=\"" . strtoupper($PAR['class']) . "\"";}

		if (isset($PAR['type'])) {
			$type_begin 	= "textarea";
			$value_outside 	= $content;
			$type_end   	= "</textarea>";
			if (isset($PAR['cols'])) {$cols = " cols=\"" . $PAR['cols'] . "\"";}
			if (isset($PAR['rows'])) {$rows = " rows=\"" . $PAR['rows'] . "\"";}
		} else {
			$type_begin 	= "input";
			$value_inside 	= " value=\"$content\"";
		}
		
		$return = "<$type_begin name=\"$field_name$id\" $value_inside$size$cols$rows$class>$value_outside$type_end";			

		set_function("type_text_input", $field_name);
		return $return;
	}
	
	function type_sys_calendar($AC="", $html="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $SCORPIO;
		
		$PAR = explode_par($par);
		
		$id 		= $AC['id'];
		$value 		= $AC[$field_name];
		
		if (isset($PAR['date_def']) && ($value == 0 || $value == '')) { //v3.25
			$value = TIME + ($PAR['date_def'] * 24 * 60 * 60);
		}
		
		if (isset($PAR['format'])) {  // mettre tout ca dans une fonction pour reusabilite
			$date_str = $PAR['format'];  //'Y-m-d\ H\hi\'
		} else {
			$date_str = 'Y-m-d'; 
		}
			
		$date_output = date($date_str, $value); //'Y-m-d\ \- \  H\ \h i \ \: \  s'
			
		if (is_allowed(5)) { //ï¿½ mettre dans les types
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/calendar.js");
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/calendar-setup.js"); //added calendar/ 3.15
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/lang/calendar-" . lang() . ".js");
			$SCORPIO->set_css_link("calendar-win2k-1");
			
			$inputfield 		= $field_name . "-" . $AC['id'];
			$outputfield 		= "output-" . $field_name . "-" . $AC['id'];
			$imggif_fullpath	= SCORPIO_TYPES_PATH . "calendar/img.gif"; 
			$trigger 			= "trigger-" . $field_name . "-" . $AC['id'];
			if ($PAR['showtime'] == 1) {$showtime = true;} else {$showtime = false;}
			
			if ($PAR['daformat'] != "") {$daformat = "daFormat	   :    \"" . $PAR['daformat'] . "\",";}
			
			$content = "	
					<input type=\"hidden\" size=\"15\" name=\"$inputfield\" id=\"$inputfield\" value=\"$value\" readonly=\"1\" />
					<img src=\"$imggif_fullpath\" name=\"$trigger\" id=\"$trigger\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
					onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />
		
					<script type=\"text/javascript\">
						Calendar.setup({
							inputField     :    \"$inputfield\",     // id of the input field
							displayArea	   :	\"$outputfield\",
							ifFormat       :    \"%s\",      // format of the input field\"%B %e, %Y\",
							$daformat
							button         :    \"$trigger\",  // trigger for the calendar (button ID)
							date           :    $value,  
							singleClick    :    true,
							showsTime	   :    \"$showtime\"
						});
					</script>
					";	
	
		
			/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
				$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
				$form_rte_html 		= t_set_block("form_items_new", "CALENDAR");
		
				$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")],
									"FIELD_DATE_ID" 	=> $outputfield, 
									"FIELD_DATE_OUTPUT" => $date_output, 
									"FIELD_VALUE" 		=> $content,
									"NAME"				=> $inputfield,
									);	
				
				$return	 			= set_var($form_rte_html, $FORM_VARS);
			
							
			
		} else {
			$return = $date_output;
		}
		
			
		set_function("type_calendar", $AC['name']);
		return $return;
	}

	function type_sys_textarea($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;

		$PAR 				= explode_par($par); 

		if ($PAR['ac'] == "true") {$source = $AC[$field_name];} else {$source = $HTML[$field_name];}
 
		$content			= format_rte($source,1);
		$content 			= str_replace('"', "''", $content);
		if (!isset($PAR['width'])) {$width = 38;}
		if (!isset($PAR['height'])) {$height = 5;}
		
		$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
		$form_input_html 	= t_set_block ("form_items_new", "TEXTAREA");

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $content,
							"NAME"				=> $field_name . "-" . $AC['id'],
							"WIDTH"				=> $width, 
							"HEIGHT"			=> $height, 
							);	
		
		$return	 			= set_var($form_input_html, $FORM_VARS);					

		set_function("type_sys_textarea", $field_name);
		return $return;
	}

	function type_youtube($AC="", $html="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;

		$PAR 				= explode_par($par);
		
		$content			= format_rte($AC[$field_name],1);
		
		if (is_allowed(5)) {
			if ($PAR['ac'] == "true") {$source = $AC[$field_name];} else {$source = $HTML[$field_name];}
	 
			$width 				= $PAR['width'];
			
			$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
			$form_input_html 	= t_set_block ("form_items_new", "INPUT");
	
			$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
								"FIELD_VALUE" 		=> $content,
								"NAME"				=> $field_name . "-" . $AC['id'],
								"SIZE"				=> $width, 
								"MAX"				=> "",
								"TYPE"				=> "text", // password
								);	
			
			$return	 			= set_var($form_input_html, $FORM_VARS);					
		} else {
			$return = "<object width=\"425\" height=\"350\"><param name=\"movie\" value=\"http://www.youtube.com/v/" . $content . "\"></param><embed src=\"http://www.youtube.com/v/" . $content . "\" type=\"application/x-shockwave-flash\" width=\"425\" height=\"350\"></embed></object>";
		}
		
		set_function("type_youtube", $field_name);
		return $return;
	}

	function type_sys_rte($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $SCORPIO;
		
		$PAR = explode_par($par);
		
		if (isset($PAR['access'])) {$access = $PAR['access'];} else {$access = 5;}	
			
		if (is_allowed($access)) {			
			static $rte_count = 1;
			
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "rte/richtext.js");
			$SCORPIO->set_css_link("rte");
	
			if (isset($PAR['field'])) {
				$field_name = $PAR['field'];
			}
			
			if (isset($PAR['width'])) {$width = $PAR['width'];} else {$width = 490;}
			if (isset($PAR['height'])) {$height = $PAR['height'];} else {$height = HTML_HEIGHT;}
			
			$content	= format_rte($HTML[$field_name],1);
			$content 	= addslashes($content);
			$id			= $AC['id'];
			$rte_id 	= $field_name . "-" . $id;

			$content	= "
				<div class=\"RTE_FIELD\">
					<script language=\"JavaScript\" type=\"text/javascript\">
						function submitForm() {
							updateRTEs();
							return true; 
						}

						initRTE(\"themes/default/images/rte/\", \"" . SCORPIO_TYPES_PATH . "rte/\", \"themes/default/css/\");
					</script>
					<script language=\"JavaScript\" type=\"text/javascript\">
						writeRichText('$rte_id', '$content', $width, $height, true, false);
					</script>
				</div>
			";
			
		/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
			$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
			$form_rte_html 		= t_set_block("form_items_new", "HTML");
	
			$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
								"FIELD_VALUE" 		=> $content,
								"NAME"				=> $field_name . "-" . $AC['id'],
								);	
			
			$return	 			= set_var($form_rte_html, $FORM_VARS);			
			
		} else {
			$return	= $HTML[$field_name];
		}
		

		set_function("type_sys_rte", $field_name);
		return $return;
	}	

	function type_rte_box($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $SCORPIO;

		$PAR = explode_par($par);
		
		$file_path = SCORPIO_CONTENTS_PATH . "html.php";

		if (file_exists($file_path)) {
			include($file_path);
		} else {
			set_message("file not found" . $PAR['file'], "fichier <b>$file_path</b> introuvable", 1);
		}
		
		set_function("type_rte_box", $AC['name']);
		return $return;
	}

	function type_sys_selector_image($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);
	
		$id = $AC['id'];
		
		if (isset($PAR['db_field'])) {$field_name = $PAR['db_field'];} else {$field_name = "img";}
		if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
		if (!isset($LIST['selector_image'])) {$LIST[$list_name] = db_select("files", $SELECT_PAR);}
		
		$DROP = $LIST[$list_name]['DATA'];	
		$DROP = array_order($DROP, lang('label'));
		
		if (isset($PAR['filter'])) {$FILTER = explode(",", $PAR['filter']);}
		
		$field_id = $field_name . "-" . $id;
		
		$select  = "<select name=\"$field_id\"$size onchange=\"image_switch(this.value,'preview_$field_id')\">";
		
		if ($PAR['none'] != "false") {$select .= "<option value=\"\"$selected> </option>";}
		
		foreach($DROP as $key => $DLIST) {
			$selected = "";	

			if ($AC[$field_name] == $DLIST['name']) {
				$selected = " selected";
			}
	
			$value = $DLIST['name'];
			$label = $DLIST[lang('label')];
			
			$select .= "<option value=\"$value\"$selected>$label</option>";
		}
		
		$select .= "</select>";
		$content = $select;	

	/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
		$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
		$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR_IMAGES");
		
		$IMG_NAME = explode(".", $AC[$field_name]);

		$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 		=> $content,
							"IMAGE_PREVIEW" 	=> "<img src=\"files/" . $IMG_NAME[0] . "_m." . $IMG_NAME[1] . "\" id=\"preview_$field_id\" border=\"0\"/>",
							"NAME"				=> $field_name . "-" . $AC['id'],
							);	
		
		$return	 			= set_var($form_selector_html, $FORM_VARS);
		
		reset($DROP);

		set_function("type_selector_image", $field_name);
		return $return;
	}

	function type_sys_pid($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		if (isset($PAR['access'])) {$access = $PAR['access'];} else {$access = 5;}	
			
		if (is_allowed($access)) {	
			if (in_array("pid_contents",$SELECT)) {
					
			
			} else {
				$id			= $AC['id'];
				$list_name 	= "contents";
				
				//$SELECT[] = "pid_contents";
					
				if (isset($PAR['output'])) {$field_name = $PAR['output'];}	
				if (!isset($PAR['field'])) {$PAR['field'] = lang("label");}
				
				if (isset($PAR['root'])) {
					if (!isset($LIST["drop_" . $list_name])) {  // optimisï¿½ le 2007-10-17 
						if (isset($PAR['db'])) {
							$TREE = tree($PAR['root'], 0, array('db' => $PAR['db']));
						} else {
							$TREE = tree2($PAR['root']);
						}
						
						$LIST["drop_" . $list_name]['DATA'] = tree_to_list("sel_list", $TREE);
					}
					
					$DROP = $LIST["drop_" . $list_name]['DATA'];
				} else {
					if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
					if (isset($PAR['db'])) {$SELECT_PAR['db'] = $PAR['db'];}
					if (!isset($LIST[$list_name])) {$LIST[$list_name] = db_select($PAR['table'], $SELECT_PAR);}
					$DROP = $LIST[$list_name]['DATA'];	
				}
				
				if (isset($PAR['order'])) {$DROP = array_order($DROP, $PAR['order']);}// else {$DROP = array_order($DROP, 'pid');}
				if (isset($PAR['size'])) {$size = " size=\"" . $PAR['size'] . "\"";}
				
				$select  = "<select name=\"$field_name" . "-" . "$id\"$size>";
		
				if ($PAR['none'] != "false" && $PAR['mode'] != 'simple') {$select .= "<option value=\"\"$selected> </option>";}
				
				foreach($DROP as $key => $DLIST) {
					if (!in_array($DLIST['type'], $LIST['pid_filter']['DATA'])) {
						if (!isset($PAR['allowed']) || (isset($PAR['allowed']) && is_allowed($DLIST['allowed']))) {				
							$selected = "";	
		
							if ($AC[$field_name] == $DLIST[$PAR['field']] || $AC[$field_name] == "|" . $DLIST['id'] . "|" || ($PAR['arr'] == "true" && $AC[$field_name] == $key)) {
								$selected = " selected";
								$selected_ok = true;
							}
			
							$spacer = spacer($DLIST['level']);
						
							if ($PAR['arr'] == "true") {  //look for array list	
								$label 	= $DLIST;
								$id  	= $key;
							} else {
								if ($key != "") {
									if ($DROP[substr($DLIST['pid'], 1, -1)]['name'] != "") {
										$parent = $DROP[substr($DLIST['pid'], 1, -1)][lang("label")] . " - ";
									} else {
										$parent = "ROOT - ";
									}
									
									$pid = " ($key)";	
										
									if ($PAR['mode'] == 'simple')  {$parent = ''; $pid = '';} 
									
									$label 	= $parent . $DLIST[$PAR['field']] . $pid;
									$id  	= "|" . $DLIST['id'] . "|";
									
									if (isset($PAR['value'])) {// patch pour images
										//if (is_numeric($AC[$field_name])) {
										//	$id = $DLIST['id'];
										//} else {
											$id = $DLIST[$PAR['name']];
										//}
									}
								} else if ($key == "0" && $field_name == "pid") { // patch pour root
									$id = "|0|";
									$label 	= "SCORPIO";
								}				
							}	
							
							
							
							if ($label != "") {
								$select .= "<option value=\"$id\"$selected>$spacer$label</option>";
							}
						}
					}
				}
				
				if (!$selected_ok) { //added v3.30 to have a parent in all cases (for update routine)
					$id = $AC['pid'];
					$select .= "<option value=\"$id\"  selected>$id -- WATCH OUT</option>";
				}
				
				$select .= "</select>";
				$content = $select;	
				
				reset($DROP);
			}
			
		/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
			$form_file_html 		= t_load_file("form_items_new", "form_items_new", true);	
			$form_selector_html 	= t_set_block ("form_items_new", "SELECTOR");
	
			$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
								"FIELD_VALUE" 		=> $content,
								"NAME"				=> $field_name . "-" . $AC['id'],
								);	
			
			$return	 			= set_var($form_selector_html, $FORM_VARS);
		} else {
			//$return = "{EMPTY}";
		}

		set_function("type_sys_pid", $field_name);
		return $return;
	}

	function type_sys_input($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;

		$PAR 				= explode_par($par);

		if ($PAR['ac'] == "true") {$source = $AC[$field_name];} else {$source = $HTML[$field_name];}
		if ($PAR['type'] == "password") {$type = "password";} else {$type = "text";}
 
		$content			= format_rte($source,1);
		$content 			= str_replace('"', "''", $content);
		$width 				= $PAR['width'];

	/// FILL TEMPLATE		
		$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
		$form_input_html 	= t_set_block ("form_items_new", "INPUT");
		

		$FORM_VARS	= array("FIELD_LABEL"			=> $TYPE_PAR[lang("label")], 
							"FIELD_VALUE" 			=> $content,
							"NAME"					=> $field_name . "-" . $AC['id'],
							"SIZE"					=> $width, 
							"MAX"					=> "",
							"TYPE"					=> $type, // password
							//"FIELD_ADMIN_NAME"		=> $field_admin,
							//"FIELD_ADMIN_VALUE"		=> $field_admin,
							);	
		
		$return	 			= set_var($form_input_html, $FORM_VARS);					

		set_function("type_testinput", $field_name);
		return $return;
	}

	function type_selector_image($AC="", $HTML="", $par="", $field_name="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);
		
		$id = $AC['id'];
		
		if (isset($PAR['db_field'])) {$field_name = $PAR['db_field'];} else {$field_name = "img";}
		if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
		if (!isset($LIST['selector_image'])) {$LIST[$list_name] = db_select("files", $SELECT_PAR);}
		
		$DROP = $LIST[$list_name]['DATA'];	
		$DROP = array_order($DROP, lang('label'));
		
		if (isset($PAR['filter'])) {$FILTER = explode(",", $PAR['filter']);}
		
		$select  = "<select name=\"$field_name" . "-" . "$id\"$size>";
		
		if ($PAR['none'] != "false") {$select .= "<option value=\"\"$selected> </option>";}
		
		foreach($DROP as $key => $DLIST) {
			$selected = "";	

			if ($AC[$field_name] == $DLIST['name']) {
				$selected = " selected";
			}
	
			$value = $DLIST['name'];
			$label = $DLIST[lang('label')];
			
			$select .= "<option value=\"$value\"$selected>$label</option>";
		}
		
		$select .= "</select>";
		$return = $select;	
		
		reset($DROP);

		set_function("type_selector_image", $field_name);
		return $return;
	}
	
	function type_filesize($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);

		$return = humansize($AC[$field_name],"b");
		
		set_function("type_filesize", $AC['name']);
		return $return;
	}

	function type_filetype($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);

		switch ($AC[$field_name]) {
			case "image/pjpeg":
			case "image/jpeg":
				$return = "jpg";
				break;	
				
			case "application/pdf":
				$return = "pdf";
				break;	
				
			case "application/vnd.ms-excel":
				$return = "xls";
				break;	
	
			case "image/png":
			case "image/x-png":
				$return = "png";
				break;		
				
			default:
				$return = "inc";
				break;					
													
		}
		
		set_function("type_filetype", $AC['name']);
		return $return;
	}
	
/*	function type_calendar($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		global $SCORPIO;
		
		$PAR = explode_par($par);
		
		$id 		= $AC['id'];
		$depart 	= $AC['depart'];
		
		if (isset($PAR['format'])) {  // mettre tout ca dans une fonction pour reusabilite
			$date_str = $PAR['format'];  //'Y-m-d\ H\hi\:s'
		} else {
			$date_str = 'Y-m-d';
		}
			
		if (is_allowed(5)) { //ï¿½ mettre dans les types
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/calendar.js");
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/calendar-setup.js"); //added calendar/ 3.15
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/lang/calendar-en.js");
			$SCORPIO->set_css("calendar-win2k-1");

			//faut mettre absolument 'date' pour la valeur actuelle
			
			$html = "	
					<input type=\"text\" size=\"6\" name=\"depart-$id\" id=\"depart-$id\" value=\"$depart\" readonly=\"1\" />
					<img src=\"contents/calendrier/img.gif\" id=\"f_trigger-$id\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
					onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />
		
					<script type=\"text/javascript\">
						Calendar.setup({
							inputField     :    \"depart-$id\",     // id of the input field
							ifFormat       :    \"%s\",      // format of the input field\"%B %e, %Y\",
							button         :    \"f_trigger-$id\",  // trigger for the calendar (button ID)
							date           :    $depart,  // trigger for the calendar (button ID)
							singleClick    :    true
						});
					</script>
					";	
			
			$return = $html;
		} else {
			$return = date($date_str, $depart); //'Y-m-d\ \- \  H\ \h i \ \: \  s'
		}
		
			
		set_function("type_calendar", $AC['name']);
		return $return;
	}*/

	function type_virtual($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
		
		set_function("type_virtual", $AC['name']);
		return $return;
	}	
	
	function type_page($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);
		$CORE['MAIN']['title'] 			= $AC[lang('label')];
		$CORE['MAIN']['desc_fr'] 		= $AC[lang('label')];
		$CORE['MAIN'][lang('desc')] 	= $AC[lang('desc')];
		$CORE['MAIN']['title_content'] 	= $PAR['title'];
		$CORE['MAIN']['title_image'] 	= $PAR['title_image'];
		//$CORE['MAIN']['HTML']			= $html;
		
		$CORE['MAIN']['name'] 			= $AC['name'];
		$CORE['MAIN']['id'] 			= $AC['id'];
		$CORE['MAIN']['pid'] 			= substr($AC['pid'], 1, -1);
		$CORE['MAIN']['parent_name']	= $LIST['contents']['DATA'][$CORE['MAIN']['pid']][lang('label')];
		$CORE['MAIN']['layout'] 		= $PAR['layout'];
		$CORE['MAIN']['back'] 			= $PAR['back'];
		$CORE['MAIN']['back_repeat'] 	= $PAR['back_repeat'];
		$CORE['MAIN']['construction'] 	= $PAR['construction'];
		$CORE['MAIN']['title_hide'] 	= $PAR['title_hide'];
		$CORE['MAIN']['page_layout'] 	= $PAR['page_layout'];
		$CORE['MAIN']['use_other'] 		= $PAR['use_other'];
		
		set_function("type_page", $AC['name']);
		return $return;
	}		
	
	function type_container($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
		
		set_function("type_container", $AC['name']);
		
		return ;
	}
	
	function type_layout($AC="", $html="", $par="") {
		global $CORE;
		
		$PAR = explode_par($par);
		
		set_function("type_layout", $AC['name']);
		
		return ;
	}	
		
	function type_include_html($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);

	/// SYS & CONTENTS PATH		// updated on v3.20
		if ($PAR['sys'] == 1) {
			if ($PAR['content'] == 1) {
				$path = SCORPIO_CONTENTS_PATH;
			} else {
				$path = SCORPIO_TEMPLATES_PATH;
			}
		} else {
			if ($PAR['content'] == 1) {
				$path = SITE_CONTENTS_PATH;
			} else {
				$path = SITE_TEMPLATES_PATH;
			}
		}
			
	/// MODULE PATH 3.12
		if ($PAR['mod'] != "") {
			$mod_path = "mod_" . $PAR['mod'] . "/";
		}	

	/// DIR PATH
		if ($PAR['dir'] != "") {
			$dir_path = $PAR['dir'] . "/";
		}
		
		$file_path = $path . $mod_path . $dir_path . $PAR['file'] . ".html";

		if (file_exists($file_path)) {
			$return = implode(file($file_path));	
		} else {
			set_message("file not found " . $PAR['file'], "html - fichier <b>$file_path</b> introuvable", 1);
		}
		
		set_function("type_include_html", $AC['name']);
		
		return $return;
	}

	function type_include_php($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);

		if (isset($PAR['abs_path'])) {
			$path = $PAR['abs_path'];
		} else {
		/// SYS PATH	
			if ($PAR['sys'] == 1) {
				$path = SCORPIO_CONTENTS_PATH;
			} else {
				$path = SITE_CONTENTS_PATH;
			}
		
		/// MODULE PATH 3.12
			if ($PAR['mod'] != "") {
				$mod_path = "mod_" . $PAR['mod'] . "/";
			}	
	
		/// DIR PATH
			if ($PAR['dir'] != "") {
				$dir_path = $PAR['dir'] . "/";
			}	
		}		
		
		$file_path = $path . $mod_path . $dir_path . $PAR['file'] . ".php";

		if (file_exists($file_path)) {
			include($file_path);
		} else {
			set_message("file not found" . $PAR['file'], "fichier <b>$file_path</b> introuvable", 1);
		}
		
		set_function("type_include_php", $AC['name']);
		return $return;
	}

	function type_main_content($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
	
		set_function("type_main_content", $AC['name']);
		
		$return = $CORE['MAIN']['HTML'];
		
		return $return;
	}

	function type_page_content($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
	
		set_function("type_page_content", $AC['name']);
		
		$return = $CORE['PAGE']['HTML'];
		
		return $return;
	}

	function type_menu($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);

		if($PAR['new']) {
			global $SCORPIO;

			$SCORPIO->set_js(SCORPIO_JS_PATH . "chrome.js",1);
			$SCORPIO->set_css_link("chromestyle");

			$PAGES = tree2(236,-1,array('TYPES' => array(0,1), 'status' => 1, 'allowed'=>1, 'gen'=>2));

			foreach($PAGES['CHILDS'] as $FIRST_GEN) {
				if (!strstr($FIRST_GEN['par'],'menu:'))  {
					$rel_drop = '';
				//e($FIRST_GEN);
					if (isset($FIRST_GEN['CHILDS'])) {
						$count++;

						$second_gen_li .= '<div id="dropmenu' . $count . '" class="dropmenudiv" style="">';

						foreach($FIRST_GEN['CHILDS'] as $SECOND_GEN) {
							if ($SECOND_GEN['label_fr'] != '') {
								$second_gen_li .= '<a href="?p=' . $SECOND_GEN['name'] . '">' . $SECOND_GEN['label_fr'] . '</a>';
							}
						}

						$second_gen_li .= '</div>';

						$rel_drop = "rel=\"dropmenu$count\"";

						$page_url = '#';
					} else {
						$page_url = '?p=' . $FIRST_GEN['name'];
					}

					if ($FIRST_GEN['label_fr'] != '') {
						$first_gen_li .= '<li><a href="' . $page_url . '" ' . $rel_drop . '>' . $FIRST_GEN['label_fr'] . '</a></li>';
					}
				}
			}

			$return = '
					<div class="chromestyle" id="chromemenu">
						<ul>
						'

						. $first_gen_li .

						'</ul>
					</div>
						'

						. $second_gen_li .

						'
					<script type="text/javascript">
						cssdropdown.startchrome("chromemenu")
					</script>

					<br />
					<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			';

		} else {



		$parent_id	= substr($LIST['contents']['DATA'][PAGE_ID]['pid'], 1, -1);
		//$pages_id 	= data_switch("contents", "pages");
		//$RES 		= tree($pages_id,-1,array('TYPES' => array(0,1), 'status' => 1, 'allowed'=>1));

	/// USE TEMPLATE (enfin en criss) v3.34
		if (isset($PAR['template'])) {
			//if (isset($PAR['menu'])) { $menu = $PAR['menu'];	} else { $menu = 'menu_1'}
			$menu_html 		= t_load_file($PAR['template'], $PAR['template']);	
			$item_html 		= t_set_block ($PAR['template'], 'MENU_ITEM');	
			$block_html 	= t_set_block ($PAR['template'], 'MENU');		
		}

	/// check for css name
		if (isset($PAR['css'])) {
			$css_name = "MENU_" . strtoupper($PAR['css'])	;
		} else {
			$css_name = "MENU";
		};

	/// first gen pages	
		$pages_id 	= data_switch("contents", "pages");
				$RES 		= tree2($pages_id,-1,array('TYPES' => array(0,1), 'status' => 1, 'allowed'=>1, 'gen'=>1));
		$PAGES_LIST = $RES['CHILDS'];
		$PAGES_IDS 	= array_flip_multi($PAGES_LIST, "id");

	/// pages from selected
		if (in_array($parent_id, $PAGES_IDS) && $parent_id != $pages_id) {
			$page_id = $parent_id;
		} else {
			$page_id = PAGE_ID;
		}

		if ($PAR['level'] > 1 || $PAR['level'] == "") {		
					$TREE_RES 	= tree2($page_id,0,array('TYPES' => array(0,1), 'status' => 1, 'allowed'=>1, 'gen'=>2));
			$CHILD_LIST = $TREE_RES['CHILDS'];		
		}

	/// insert child list in menu list
		foreach($PAGES_LIST as $PAGE) {
			$GENRE[$PAGE['id']] = $PAGE;
		}
		
		$GENRE = array_flip(array_keys($GENRE));
		$pos = $GENRE[$page_id];
		
				if ($PAR['childs_only'] == true) {
					$PAGES_LIST = $CHILD_LIST;
			//e($PAGES_LIST);
				} else {
		array_splice($PAGES_LIST, $pos+1, 0, $CHILD_LIST);	
				}
						

		foreach($PAGES_LIST as $ROW) {
			$ROW_PAR = explode_par($ROW['par']);
	//e($PAR['menu']);
	//e('---' . $ROW_PAR['menu']);  
	
			if ($PAR['menu'] == $ROW_PAR['menu']) {
				if ($ROW['type'] == 1 && $ROW_PAR['menu'] != "false") { //criss de patch
						//e($ROW);
							if (($ROW_PAR['admin'] != false && !isset($ROW_PAR['admin'])) || ($ROW_PAR['admin'] == false && $ROW['allowed'] < 2)) {
					if ($ROW['id'] == PAGE_ID || $ROW['id'] == $parent_id) { // || $ROW['pid'] == PAGE_ID or parent for l1 act facile juste checker avec pid
						$status = "ACT";
					} else {
						$status = "NO";
					}
					
					$div_fix = div_fix();
					
					if (is_allowed(6)) {$fastediturl = url(I_EDIT, '?p=admin_pages&pageslist_cat_id=' . $ROW['id']);}
					
					if (isset($PAR['template'])) {
						$style 		=  "class=\"$css_name" . "_L" . $ROW['level'] . "_$status\"";
						$row_html  .= set_var($item_html, 'ITEM', "<a href=\"?p=" . $ROW['name'] . "\" $style>" . $ROW[lang('label')] . "</a>");	
					} else {
									$div_id = strtolower($css_name) . "_l" . $ROW['level'] . '_'  . $ROW['name'] . '_' . $ROW['id'];

						if (isset($ROW_PAR['url'])) {
										$RETURN[] = "\n<div id=\"$div_id\" class=\"$css_name" . "_L" . $ROW['level'] . "_$status$div_fix\">\n$fastediturl<a href=\"" . $ROW_PAR['url'] . "\">" . $ROW[lang('label')] . "</a>\n</div>";
						} else {
										$RETURN[] = "\n<div id=\"$div_id\" class=\"$css_name" . "_L" . $ROW['level'] . "_$status$div_fix\">\n$fastediturl<a href=\"?p=" . $ROW['name'] . "\">" . $ROW[lang('label')] . "</a>\n</div>";
						}						
					}
				}			
			}
		}
				}
		
		if ($PAR['sep'] == 1) {
			array_pop($RETURN);
			e($RETURN);		
		}
		
		if (isset($PAR['template'])) {
			$return = set_var($block_html, 'MENU_ITEM', $row_html);	
		} else {
			$return = implode("\n", $RETURN);
			$return = "\n<div class=\"$css_name\">$return\n</div>";			
		}
		}


		set_function("type_menu", $AC['name']);

		return $return;
	}

	function type_flash($AC="", $html="", $par="", $field_name="") { /// 2007-03-27 ///
		global $CORE;
		
		$PAR = explode_par($par);

		if ($PAR['lang'] == 'true') {$file = lang($PAR['file']);} else {$file = $PAR['file'];}
		
		$topbr			= br($PAR['topbr']);
		$botbr			= br($PAR['botbr']);
		$width		 	= $PAR['width'];
		$height 		= $PAR['height'];
		$taille 		=  'width="'.$width.'" height="'.$height.'"';
		if (!isset($_GET['p'])) {$_GET['p'] = "accueil";}
		if (isset($PAR['align'])) {$align = "text-align:" . $PAR['align'] . ";";} else {$align = "text-align:center;";}
		//$p 				= "?p=" . $_GET['p'] . "&status=1";
		//$r = "?r=" . shuffle_id(6);
		$file_pathname	= SITE_SWF_PATH . "$file.swf";
		
		if (file_exists($file_pathname)) {
			$return = 	"<div style=\"$align\">$topbr
							<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" $taille>
							<param name=\"movie\" value=\"$file_pathname$p$r\" />
							<param name=\"wmode\" value=\"transparent\">
							<param name=\"quality\" value=\"high\" />
							<embed src=\"$file_pathname$p$r\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" wmode=\"transparent\" type=\"application/x-shockwave-flash\" $taille></embed>
							</object>$botbr
						 </div>
						";
	
			return $return;			
		} else {
			set_message("flash not found", "flash <b>$file_pathname</b> introuvable", 1);
		}				
		
		set_function("type_menu", $AC['name'] . "|$file");			
	}

	function type_login_process($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
		
		$previous = "?" . $CORE['SESSION']['previous_url'];
		
		if (isset($CORE['POST']['b_login'])) {
			$SESSION = new session();
			
			$username = $_POST['username']; //$CORE['POST_VAR']['username'];
			$password = $_POST['password']; //$CORE['POST_VAR']['password'];
			$user_id = $SESSION->login($username,$password);
			
			if ($user_id != 0) {
				$session_id = $SESSION->create_session($user_id);
				$result = $SESSION->create_session_db($session_id);
				
				if ($result == 1) {
					$_SESSION['id'] = $session_id;
				} else {
					echo "cannot create db session";
					exit;
				}
				
				header("Location:$previous");
			}	
		}
		
		if (isset($CORE['POST']['b_logout'])) {
			unset($_SESSION['id']);
			header("Location:$previous");
		}			
			
		set_function("type_login_process", $AC['name']);
		return $return;
	}

	function type_image($AC="", $HTML="", $par="", $field_name="") { //repatenter les div la dedans
		global $CORE;

		$PAR = explode_par($par);

		$file_name = $PAR['file'];		
//e($HTML);
		if (isset($PAR['output_ext'])) {$output_ext = '.' . $PAR['output_ext'];} else {$output_ext = '.jpg';} //v3.25
		if (isset($PAR['output_field'])) {$output_field = $HTML[$PAR['output_field']] . $output_ext;} else {$output_field = $HTML[$field_name];} //v3.25
//e($output_field);
		if ($PAR['files'] == "true" && trim($output_field) != "") {
			$path 		= $AC['path'];
			$file_name 	= trim($output_field);
			
			if ($path == "") {$path = $PAR['path'];} // patch

			if (isset($PAR['size'])) {
				$file_pathname = SITE_FILES_PATH . $path . substr_replace($file_name, '_' . $PAR['size'], -4, 0);
			} else {
				$file_pathname = SITE_FILES_PATH . $path . $file_name;
			}		
		} else if ($PAR['files'] == "1") { //patch 3.08
			$file_pathname = "files/$file_name";
			$div_fix = div_fix();
		} else {
			$file_pathname = "themes/default/images/$file_name";
		}

		if (isset($PAR['url'])) {
			$url_begin	= "<a href=\"" . $PAR['url'] . "\">";
			$url_end	= "</a>";
		}
	//e($file_pathname);
		if (file_exists($file_pathname) && $file_name != "") {
			if (isset($PAR['width'])) {$width =  "width=\"" . $PAR['width'] . "\"";}
			if (isset($PAR['height'])) {$height =  "height=\"" . $PAR['height'] . "\"";}
			if (isset($PAR['border'])) {$border =  "border=\"" . $PAR['border'] . "\"";} else {$border =  "border=\"0\"";}
			if (isset($PAR['align'])) {$align =  "align=\"" . $PAR['align'] . "\"";}
			//if (isset($PAR['class'])) {$class =  " class=\"" . strtoupper($PAR['class']) . "\"";}
			if (isset($PAR['style'])) {$style =  " style=\"" . strtoupper($PAR['style']) . "\"";}
				
			if (isset($PAR['nodiv'])) {
				$return = 	"$url_begin<img src=\"$file_pathname\" alt=\"$file_name\" $style $width $height $border $align/>$url_end";	
			} else {
				//$return = 	"<div$div_fix$class>$url_begin<img src=\"$file_pathname\" alt=\"$file_name\" $style $width $height $border $align/>$url_end</div>";
				$return = 	"$url_begin<img src=\"$file_pathname\" alt=\"$file_name\" $style $width $height $border $align/>$url_end";
			}
			
			if (isset($PAR['protect'])) {
				if ($PAR['protect'] != 'true') {
					$protect_img_path = SITE_IMAGES_PATH . $PAR['protect'];	
				} else {
					$protect_img_path = SITE_IMAGES_PATH . "protect.gif";
				}
				
				list($img_width, $img_height) = getimagesize($file_pathname);
				
				$img_width = $img_width . 'px';
				$img_height = $img_height . 'px';
				
				$return = 	"<div style=\"position:relative;width:$img_width;height:$img_height;display:block;overflow:hidden\">
								
									$return
								<div style=\"top:0px;left:0px;position:absolute;width:$img_width;height:$img_height;background-image:url($protect_img_path);\">
									
								</div>	
								
							</div>";
			}			
				
		} else {
			if ($file_name != "" && DEBUG) {
				set_message("image not found - $file_name", "image <b>$file_name</b> introuvable dans " . $AC['label_fr'] . "- $file_pathname", 1);
			}
		}	
			
		set_function("type_image", $file_name);
		return $return;		
	}	

	function type_content_spacer($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
			
		$height 	= $PAR['height'];
		$return 	= "<div style=\"height:$height;float:left;position:relative\">&nbsp;</div>";
		
		set_function("type_content_spacer", $AC['name']);
		return $return;
	}

	function type_page_title($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);

		if ($CORE['MAIN']['title_content'] != "false") {
			$title 	= $CORE['MAIN']['title'];
		
			if ($CORE['MAIN']['title_image'] != "") {
				$img = $CORE['MAIN']['title_image'];
				$file_pathname = "themes/default/images/" . $CORE['MAIN']['title_image'];
				$title 	= "<img src=\"$file_pathname\" alt=\"$img\" $width $height $border $align/>";
				//$background_url = "themes/default/images/" . $CORE['MAIN']['title_image'];
				//$background = " style=\"background-image:url($background_url)\"";
			}
				
			if(is_allowed(6)) {' ' . $title_edit = url(I_EDIT . ' ', "?p=admin_pages&pageslist_cat_id=" . $CORE['MAIN']['id'] );}	
				
			$return = "<div class=\"PAGE_TITLE\"$background>$title_edit$title</div>";		
		}	
		
		set_function("type_page_title", $AC['name']);
		return $return;
	}

	function type_page_message($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
			
		foreach($CORE['DEBUG']['MESSAGES'] as $bug => $message) {
			if ($bug != "") {
				$return .= $message;
			}		
		}
		
		set_function("type_page_message", $AC['name']);
		return $return;
	}
	
	function type_url($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
		
		$id 		= $AC['id'];	

		if ($PAR['ac'] == "false") {
			$SOURCE = $HTML;
		} else {
			$SOURCE = $AC;
		}		

		if (isset($PAR['label'])) {
			$label = $SOURCE[$PAR['label']];
		} else {
			$label = $SOURCE[$field_name];
		}

		if ($PAR['type'] == "zoom") {
			$path 		= $PAR['path'];
			if (isset($PAR['output_ext'])) {$ext = '.' . $PAR['output_ext'];}
			if (isset($PAR['output_field'])) {$src = $AC[$PAR['output_field']] . $ext;} else {$src = $AC[$field_name];}
							
			$return 	= "<a href=\"files/$path$src\" target=\"_blank\">$label</a>";
		} else {
			if (isset($PAR['field'])) {$id = $AC[$PAR['field']];}

			$list_name 	= $AC['list_name'];	
			$pid 		= substr($AC['pid'], 1, -1);
			
			if (isset($_GET[$list_name . "_cat_expand"])) {
				$list_expand = "&$list_name" . "_cat_expand=" . $_GET[$list_name . "_cat_expand"];
			}
	
			if (isset($PAR['list_name'])) {
				if ($PAR['type'] == "cat") {
					$path 	= $PAR['list_name'] .  "_cat_id=" . $id . $list_expand;
				} else {
					$path 	= $PAR['list_name'] .  "_cat_id=" . $pid . "&" . $PAR['list_name'] .  "_item_id=" . $id . $list_expand;
				}
			} else {
				if ($PAR['type'] == "cat") {
					$path 	= $list_name .  "_cat_id=" . $id . $list_expand;
				} else {
					if ($PAR['cat'] == 'false') {
						$path 	= $list_name . "_item_id=" . $id . $list_expand;						
					} else {
						$path 	= $list_name . "_cat_id=" . $pid . "&" . $list_name .  "_item_id=" . $id . $list_expand;						
					}
					

				}	
			}

			if (isset($PAR['page'])) {
				$page 	= $PAR['page'];
			} else {
				$page 	= $CORE['GET']['p'];
			}	
			
			if ($pid < 0) {
				$pid = 0;
			}
	
			$return = "<a href=\"?p=$page&$path\">$label</a>";		
		}
		
		set_function("type_page_url", $AC['name']);
		return $return;
	}

	function type_makeurl($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);

		if (isset($PAR['files'])) {$files = 'files/';}
		if (isset($PAR['field'])) {$href = $AC[$PAR['field']];} else {$href = $AC[$field_name];}
		if (isset($PAR['label'])) {$label = $HTML[$PAR['label']];} else {$label = $HTML[$field_name];}
		if (isset($PAR['target'])) {$target = $PAR['target']; $target = " target=\"_$target\"";}		

		
		if (strstr($href, "@")) {		
			$return = "<a href=\"mailto:$href\">$label</a>";
		} else {
			if ($href != "" && $label != "") {
				$return = "<a href=\"$files$href\"$target>$label</a>";
			}		
		}

		set_function("type_page_makeurl", $AC['name']);
		return $return;
	}

	function type_spacer($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		$PAR = explode_par($par);

		$return = spacer($AC['level'], $char="-") . $HTML[$field_name];
		
		set_function("type_spacer", $field_name);
		return $return;
	}	

	function type_rte($AC="", $HTML="", $par="", $field_name="", $TYPE='', $field_name_func='') {
		global $CORE;
		global $SCORPIO;
	//e($field_name_func);	
		$PAR = explode_par($par);
		
		if (isset($PAR['access'])) {$access = $PAR['access'];} else {$access = 5;}	
			
		if (is_allowed($access)) {			
			static $rte_count = 1;
			
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "rte/richtext.js");
			$SCORPIO->set_css_link("rte");

			if (isset($PAR['field'])) {
				$field_name = $PAR['field'];
			}
			
			if (isset($PAR['width'])) {$width = $PAR['width'];} else {$width = HTML_WIDTH;}
			if (isset($PAR['height'])) {$height = $PAR['height'];} else {$height = HTML_HEIGHT;}
			
			$content	= format_rte($HTML[$field_name],1);
			$content 	= addslashes($content);
			$id			= $AC['id'];
			$rte_id 	= $field_name . "-" . $id;

			$return	= "
				<div class=\"RTE_BACK\">
					<script language=\"JavaScript\" type=\"text/javascript\">
						function submitForm() {
							updateRTEs();
							return true; 
						}

						initRTE(\"themes/default/images/rte/\", \"" . SCORPIO_TYPES_PATH . "rte/\", \"themes/default/css/\");
					</script>
					<script language=\"JavaScript\" type=\"text/javascript\">
						writeRichText('$rte_id', '$content', $width, $height, true, false);
					</script>
				</div>
			";
		} else {
			$return	= $HTML[$field_name];
		}
		
		$rte_count++;
		
		set_function("-------------type_rte", $field_name);
		return $return;
	}	

	function type_selector_list($AC="", $HTML="", $par="", $field_name="") { // faut tout rï¿½ï¿½crire ca criss
		global $CORE;
		global $LIST;
		global $SELECT;
		
		$PAR = explode_par($par);

		$id			= $AC['id'];
		$list_name 	= $PAR['list'];
		
		if (isset($SELECT["pid_contents"])) {
			
			//$SELECT['pid_contents']['header'] = "<select name=\"$field_name" . "-" . "$id\"$size>";
			
			//$select .= $SELECT['pid_contents']['header'];
			
			//e(implode("",$SELECT['pid_contents']['OPTIONS']));
			//$select .= implode("",$SELECT['pid_contents']['OPTIONS']);
			//$select .= $SELECT['pid_contents']['footer'];
			
				
				
			//$return = $select;	
		} else {			
			if (isset($PAR['output'])) {$field_name = $PAR['output'];}	
			if (!isset($PAR['field'])) {$PAR['field'] = "name";}
			
			if (isset($PAR['root'])) {
				if (!isset($LIST["drop_" . $list_name])) {  // optimisï¿½ le 2007-10-17 
					if (isset($PAR['db'])) {
						$TREE = tree($PAR['root'], 0, array('db' => $PAR['db']));
					} else {
						$TREE = tree2($PAR['root']);
					}
					
					$LIST["drop_" . $list_name]['DATA'] = tree_to_list("sel_list", $TREE);
				}
				
				$DROP = $LIST["drop_" . $list_name]['DATA'];
			} else {
				if (isset($PAR['cat_root'])) {$SELECT_PAR['pid'] = $PAR['cat_root'];}
				if (isset($PAR['db'])) {$SELECT_PAR['db'] = $PAR['db'];}
				if (!isset($LIST[$list_name])) {$LIST[$list_name] = db_select($PAR['table'], $SELECT_PAR);}
				$DROP = $LIST[$list_name]['DATA'];	
			}
	
			if (isset($PAR['cat'])) {
				$cat = "|";
			}
			
			if (isset($PAR['order'])) {$DROP = array_order($DROP, $PAR['order']);}
			if (isset($PAR['size'])) {$size = " size=\"" . $PAR['size'] . "\"";}
			if (isset($PAR['filter'])) {$FILTER = explode(",", $PAR['filter']);}
			
			$select  = "<select name=\"$field_name" . "-" . "$id\"$size>";
			//$SELECT['pid_contents']['header'] = $select;

			if ($PAR['none'] != "false") {$select .= "<option value=\"\"$selected> </option>";}
			
			foreach($DROP as $key => $DLIST) {
				if (!isset($PAR['filter']) || (isset($PAR['filter']) && !in_array($DLIST['type'], $FILTER))) {
					if (!isset($PAR['allowed']) || (isset($PAR['allowed']) && is_allowed($DLIST['allowed']))) {				
						$selected = "";	
	
						if ($AC[$field_name] == $DLIST[$PAR['field']] || $AC[$field_name] == $cat . $DLIST['id'] . $cat || ($PAR['arr'] == "true" && $AC[$field_name] == $key)) {
							$selected = " selected";
						}
		
						if (isset($PAR['spacer'])) {$spacer = spacer($DLIST['level']);}
					
						if ($PAR['arr'] == "true") {  //look for array list	
							$label 	= $DLIST;
							$id  	= $key;
						} else {
							if ($key != "") {
								if (isset($PAR['parent'])) {
									if ($DROP[substr($DLIST['pid'], 1, -1)]['name'] != "") {
										$parent = $DROP[substr($DLIST['pid'], 1, -1)][lang("label")] . " - ";
									} else {
										$parent = "ROOT - ";
									}
									
									$pid = " ($key)";	
								}
								
								$label 	= $parent . $DLIST[$PAR['field']] . $pid;
								$id  	= $cat . $DLIST['id'] . $cat;
								
								if (isset($PAR['value'])) {// patch pour images
									//if (is_numeric($AC[$field_name])) {
									//	$id = $DLIST['id'];
									//} else {
										$id = $DLIST[$PAR['name']];
									//}
								}
							} else if ($key == "0" && $field_name == "pid") { // patch pour root
								$id = "|0|";
								$label 	= "SCORPIO";
							}				
						}	
						
						if ($label != "") {
							$select .= "<option value=\"$id\"$selected>$spacer$label</option>";
							//$SELECT['pid_contents']['OPTIONS'][$id] = "<option value=\"$id\">$spacer$label</option>";
						}
					}
				}
			}
			
			$select .= "</select>";
			//$SELECT['pid_contents']['footer'] = "</select>";

			$return = $select;	
			
			reset($DROP);
		}

		set_function("type_selector_list", $field_name);
		return $return;
	}	

	function type_date($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		$PAR = explode_par($par);

		if ($AC[$field_name] != 0 && $AC[$field_name] != '') {
			if (isset($PAR['str'])) {
				$date_str = $PAR['str'];  //'Y-m-d\ H\hi\:s'
			} else {
				$date_str = 'Y-m-d\ H\hi';
			}
			
			$return = date($date_str, $AC[$field_name]); //'Y-m-d\ \- \  H\ \h i \ \: \  s'
		} else {
			$return = '';		
		}
		
		set_function("type_spacer", $field_name);
		return $return;
	}	
		
	function type_content_new_under($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		$PAR 		= explode_par($par);

		$page 		= qs_load();
		$list_name 	= $AC['list_name'];
		$pid 		= $AC['id'];
		$action 	= $list_name . "_add=$pid";
		$html 		= $HTML[$field_name];

		$return 	= "<a href=\"$page&$action\"><b>+</b></a> $html";			

		set_function("type_content_new_under", $field_name);
		return $return;
	}		
		
	function type_content_duplicate($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		$PAR 			= explode_par($par);

		$page 			= qs_load();
		$list_name 		= $AC['list_name'];
		$id 			= $AC['id'];
		$table  		= $AC['table'];
		$action 		= $list_name . "_$table" . "_dup=$id";
		$html 			= $HTML[$field_name];

		$return 		= "<a href=\"$page&$action\"><b>%</b></a> $html";

		set_function("type_content_duplicate", $field_name);
		return $return;
	}

	function type_structs_export($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="")  {
		global $CORE;
		$PAR 		= explode_par($par);

			//?p=process&m=structs_export&l=list_name&id=3
		$page 		= '?p=admin_structs_ie';
		$mode 		= '&m=structs_export';
		$list	 	= '&name=' . $AC['name'];
		$id 		= '&id=' . $AC['id'];		
		
		$html 		= $HTML[$field_name];

		$return 	= "<a href=\"$page&$mode$list$id\"><b>S</b></a> $html";			

		set_function("type_structs_export", $field_name);
		return $return;
	}

	function type_structs_import($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="")  {
		global $CORE;
		$PAR 		= explode_par($par);

			//?p=process&m=structs_export&l=list_name&id=3
		$page 		= '?p=admin_structs_ie';
		$mode 		= '&m=structs_importlist';
		$list	 	= '&name=' . $AC['name'];
		$id 		= '&id=' . $AC['id'];		
		
		$html 		= $HTML[$field_name];

		$return 	= "<a href=\"$page$mode$list$id\"><b>I</b></a> $html";			

		set_function("type_structs_import", $field_name);
		return $return;
	}

	function type_content_tree_duplicate($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		$PAR 		= explode_par($par);

		$page 		= qs_load();
		$list_name 	= $AC['list_name'];
		$id 		= $AC['id'];
		$action 	= $list_name . "_treedup=$id";
		$html 		= $HTML[$field_name];

		$return 	= "<a href=\"$page&$action\"><b>T</b></a> $html";			

		set_function("type_content_tree_duplicate", $field_name);
		return $return;
	}
	
	function type_content_delete($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		$PAR 		= explode_par($par);
		
		$page 		= qs_load();
		$list_name 	= $AC['list_name'];
		$id 		= $AC['id'];
		$table  	= $AC['table'];
		$action 	= $list_name . "_$table" . "_del=$id";
		$html 		= $HTML[$field_name];

		$return 	= "<a href=\"$page&$action\"><b>X</b></a> $html";			

		set_function("type_content_delete", $field_name);
		return $return;
	}	
	
	function type_selector_multi($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;
		$PAR = explode_par($par);

		$id			= $AC['id'];
		$list_name 	= $PAR['list'];
		$MULTI 		= tree2(0,0, array('status'=>1, 'allowed'=>true));
		$MULTI 		= tree_to_list("sertarien", $MULTI);

		if (isset($PAR['size'])) {
			$size = " size=\"" . $PAR['size'] . "\"";
		}

		$select = "<select name=\"$field_name" . "-" . "$id\"$size multiple>";

		foreach($MULTI as $key => $DLIST) {
			if (!isset($PAR['allowed']) || (isset($PAR['allowed']) && is_allowed($DLIST['allowed']))) {				
				$selected = "";	
		
				if ($AC[$field_name] == $DLIST['id']) {
					$selected = " selected";
				}
				
				$name = $DLIST['name'];
				$id = $DLIST['id'];			
	
				$select .= "<option value=\"$id\"$selected>$name</option>";
			}
		}
		
		$select .= "</select>";
		$return = $select;	

		set_function("type_selector_list", $field_name);
		return $return;
	}		

	function type_content_admin($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
			
		if ($CORE['DEBUG']['MESSAGES']['USER'] != "") {
			foreach($CORE['DEBUG']['MESSAGES']['USER'] as $message) {
				$return .= "<div class=\"PAGE_MESSAGE\">$message</div>";
			}
		}
		
		if (is_allowed(6) && $CORE['DEBUG']['MESSAGES']['ADMIN'] != "") {
			foreach($CORE['DEBUG']['MESSAGES']['ADMIN'] as $message) {
				$return .= "<div class=\"PAGE_MESSAGE_ADMIN\">$message</div>";
			}		
		}
		
		set_function("type_page_message", $AC['name']);
		return $return;
	}

	function type_group($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
				
		set_function("type_group", $AC['name']);
		return $return;
	}
	
	function type_field($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);
		
		if (!isset($PAR['table'])) {$PAR['table'] = "contents";}
		if (!isset($PAR['field'])) {$PAR['field'] = "name";}
		
		if (!isset($LIST[$PAR['table']])) {
			$LIST[$PAR['table']] 	= db_select($PAR['table']);
		}	
				
		$return = $LIST[$PAR['table']]['DATA'][$AC[$field_name]][$PAR['field']];
		
		set_function("type_field", $AC['name']);
		return $return;
	}	

	function type_parent_selector($AC="", $html="", $par="", $field_name="") {
		global $CORE;
		global $LIST;
		
		$PAR = explode_par($par);
		
		if (!isset($PAR['table'])) {$PAR['table'] = "contents";}
		if (!isset($PAR['field'])) {$PAR['field'] = "name";}
		
		if (!isset($LIST[$PAR['table']])) {
			$LIST[$PAR['table']] 	= db_select($PAR['table']);
		}	
				
		$return = $LIST[$PAR['table']]['DATA'][$AC[$field_name]][$PAR['field']];
		
		set_function("type_field", $AC['name']);
		return $return;
	}
	
	function type_hide($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);

		if (!isset($PAR['access'])) {$PAR['access'] = 5;}
		
		if (!is_allowed($PAR['access'])) {
			$return = "";
		} else {
			$return = $HTML[$field_name];
		}
		
		set_function("type_field", $AC['name']);
		return $return;
	}	
	
	function type_content_title($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);

		$return = $LIST['contents']['DATA'][substr($AC['pid'], 1, -1)][lang('label')];
		
		set_function("type_field", $AC['name']);
		return $return;
	}
	
	function type_iframe($AC="", $HTML="", $par="", $field_name="") { // a refaire
		global $CORE;
		global $LIST;

		$PAR = explode_par($par); 
		
		$file_name	= $PAR['file'];
		$width 		= $PAR['width'];
		$height 	= $PAR['height'];
		
		if ($PAR['align'] != "") {$align = " align=\"" . $PAR['align'] . "\"";}
	
		if (isset($PAR['url'])) {
			$file_path = "http://" . $PAR['url'];
		} else {
			if (strstr($file_name, ".com")) {		
				if (substr($file_name, 0, 11) != 'http://www.') {
					$file_name = "http://www." . $file_name;
				}
				
				$file_path = $file_name;
			} else {
				$file_path = SITE_CONTENTS_PATH . $file_name;
			}
		}
		
		if (!strstr($file_path, "?")) {
			$file_path .= "?scorpio=true";
		} else {
			$file_path .= "&scorpio=true";
		}

		//if (file_exists($file_path)) {   // pour dans la nouvelle version, vï¿½rifier si le content existe... faire une function qui valide un path
			//$file_path = $file_path . "?p=" . $_GET['p'];
			$return = "<iframe width=\"$width\" height=\"$height\"$align frameborder=\"0\" scrolling=\"no\" src=\"$file_path\"></iframe>";
		//} else {
		//	set_message("file not found " . $PAR['file'], "iframe - fichier <b>$file_path</b> introuvable", 1);
		//}
	
		set_function("type_iframe", $AC['name']);
		return $return;
	}	
	
	function type_popurl($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		
		$PAR = explode_par($par);
		
		$id 		= $AC['id'];	
		$label 		= $HTML[$field_name];

//		if ($PAR['type'] == "zoom") {
			$path 		= $PAR['path'];
			$image 		= "name=$path" . $AC[$field_name];				
//			$return 	= "<a href=\"files/$path$src\" target=\"_blank\">$label</a>";
//		} else {
//			if (isset($PAR['field'])) {$id = $AC[$PAR['field']];}
//			if (isset($PAR['label'])) {$label = $AC[$PAR['label']];}
//			
//			$list_name 	= $AC['list_name'];	
//			$pid 		= substr($AC['pid'], 1, -1);
//	
//			if (isset($PAR['list_name'])) {
//				$path = $PAR['list_name'] .  "_item_id=" . $id;
//			} else {
//				if ($PAR['type'] == "cat") {
//					$path 	= $list_name .  "_cat_id=" . $id;
//				} else {
//					$path 	= $list_name .  "_cat_id=" . $pid . "&" . $list_name .  "_item_id=" . $id;
//				}	
//			}
//	
//			if (isset($PAR['page'])) {
//				$page 	= $PAR['page'];
//			} else {
//				$page 	= $CORE['GET']['p'];
//			}	
//			
//			if ($pid < 0) {
//				$pid = 0;
//			}
//	
			$return = "<a href=\"?p=pop_image&$image\" target=\"_blank\">$label</a>";		
//		}
		
		set_function("type_page_url", $AC['name']);
		return $return;
	}	
	
	function type_math($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);
		
		$total = 0;
		$FIELDS = $PAR['fields'];
		
		switch ($PAR['type']) {
			case "mult"	:
				$total = $AC[$FIELDS[0]] * $AC[$FIELDS[1]];
			break;
		} 
		
		$return = $total;

		return $return;
	}
	
	function type_store($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);
		
		$store = &$CORE['VARS'][$PAR['tempvar']];
			
		switch ($PAR['type']) {
			case "add"	:
				$store += $HTML[$PAR['fields']];
			break;
		} 
	
		$return = $store;

		return $return;
	}
	
/*	function type_addtocart($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);

		$id = $AC['id'];
		$name = $AC[lang('label')];
		$list_name = $AC['list_name'];
		
		
		if (isset($CORE['POST'][$list_name . "_addtocart"])) {
			$ADDTOCART  = $CORE['POST'];
	
			$DB 		= new db();
			$time 		= time();
			
			$quantity 	= $CORE['POST']['quantity'];
			$color 		= $CORE['POST']['color'];
			$size 		= $CORE['POST']['size'];
			$label 		= $CORE['POST']['label'];
		
//			"name" =>$name,"type" =>$PAR['type'],"par" =>$PAR['par'],,"allowed" =>$PAR['allowed'],"status" =>$PAR['status']

			$INSERT = array("pid" =>"|1700|","label_fr" =>$label, "quantity" =>$quantity, "note" =>$color . $size, "cdate" =>$time,"mdate" =>$time,"order" =>$PAR['order'],"owner" =>$CORE['USER']['id']);
	
			$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
			$val_item = "'" . implode("','", array_map('addslashes', array_values($INSERT))) . "'";
			
			$query = "INSERT INTO `cart` ( $val_column ) VALUES ( $val_item);";
//			//echo $query."<br>";
			$DB->query($query);
			$id = mysql_insert_id();
		}
		
		
		$b_label = lang_arr(array("ajouter au panier", "add to cart"));
		$button = "
					<form action=\"\" method=\"post\"  name=\"form_addtocart\">
						<input name=\"id\" type=\"hidden\" value=\"$id\" />
						<input name=\"label\" type=\"hidden\" value=\"$name\" />
						Quantitï¿½ : <input name=\"quantity\" type=\"text\" size=\"5\" />
						Grandeur : <input name=\"size\" type=\"text\" size=\"10\" />
						Couleur : <input name=\"color\" type=\"text\" size=\"10\" />
						<input name=\"boutiquelist_addtocart\" type=\"submit\" id=\"submit_boutique_addtocart\" value=\"$b_label\">
					</form>";
		
		
		$return = $button;

		return $return;
	}*/
	
	function type_moreinfos($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;
		global $LIST;

		$PAR = explode_par($par);
		
		$infos = $AC[lang("label")];
		
		$return = "<form action=\"?p=contact_form\" method=\"post\" name=\"form_contact\"\">"
				. "		<input name=\"infos\" type=\"hidden\" value=\"$infos\">"
				. "		<center><input name=\"prout\" id=\"schlack\" type=\"submit\" value=\"" . lang_arr(array("JE VEUX DES INFORMATIONS SUR CE PRODUIT", "I WANT MORE DETAILS ON THIS PRODUCT")) . "\">"
				. "</form>";

		return $return;
	}	
	
	function type_video($AC="", $HTML="", $par="", $field_name="") {
		global $CORE;

		$PAR = explode_par($par);

		$file_name = $PAR['file'];		

		if ($PAR['files'] == "true" && trim($HTML[$field_name]) != "") {
			$path 		= $AC['path'];
			$file_name 	= trim($HTML[$field_name]);
			
			if ($path == "") {$path = $PAR['path'];} // patch	
		} else {
			$file_pathname = "files/$file_name";
		}

		if (file_exists($file_pathname) && $file_name != "") { //
			$return =   "<OBJECT id=\"VIDEO\" width=\"400\" height=\"300\" 
								style=\"position:relative;\"
								CLASSID=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\"
								type=\"application/x-oleobject\">
							<PARAM NAME=\"URL\" VALUE=\"$file_pathname \" >
							<PARAM NAME=\"SendPlayStateChangeEvents\" VALUE=\"True\">
							<PARAM NAME=\"AutoStart\" VALUE=\"False\">
							<PARAM name=\"uiMode\" value=\"full\">
							<PARAM name=\"PlayCount\" value=\"1\">
						</OBJECT> ";
		} else {
			if ($file_name != "") {
				set_message("image not found - $file_name", "image <b>$file_name</b> introuvable dans " . $AC['label_fr'] . "- $file_pathname", 1);
			}
		}	
			
		set_function("type_video", $file_name);
		return $return;		
	}					
?>