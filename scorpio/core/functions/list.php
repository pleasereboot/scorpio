<?php
	/* SCORPIO engine - functions_list.php - v3.31		*/
	/* created on 2006-12-09	 						*/
	/* updated on 2007-05-07	 						*/
	/* KAMELOS MARKETING INC	1038/445/594			*/

	function list_ini($PAR="") {
		global $LIST;
		global $TEMPLATES;
		global $CORE;
		global $SCORPIO;

	///	INI
		$list_name 				= $PAR['list'];
		$list_table 			= $PAR['table'];
		$list_root				= $PAR['root'];
		$list_db				= $PAR['db'];
		$list_limit				= $PAR['limit'];
		$list_item_id			= $PAR['item_id'];
		$list_order				= $PAR['order'];
		$list_order_dir			= $PAR['order_dir'];
		$list_page				= $PAR['page'];
		$list_new 				= $PAR['new'];
		$list_allowed			= $PAR['allowed'];
		$list_status			= $PAR['status'];
		$list_gen				= $PAR['gen'];
		$list_where				= $PAR['where'];
		$list_altern			= $PAR['altern'];
		$list_sys_form			= $PAR['sys_form'];
		$list_ci_name			= $PAR['ci_name'];
		$list_select			= $PAR['select'];
		$list_group				= $PAR['group'];
		$list_in_groups			= $PAR['in_groups'];
		$list_in_types			= $PAR['in_types'];
		$list_db_prefix			= $PAR['db_prefix'];
		$list_new_pid			= $PAR['new_pid'];

		if ($PAR['mode'] != "")	{$list_mode = $PAR['mode'];}
		if ($list_table == "")		{$list_table = "contents";}
		if ($list_root == "") {
			/*$list_root = "0";*/
		} else {
			if (!is_numeric($list_root)) {
				$list_root = data_switch("contents", $list_root);
			}

			$list_new_pid = $list_root;
		}
		if ($list_limit == "") 		{$list_limit = "10";}
		if ($list_order == "") 	{$list_order = "order";}
		if ($list_db == "") 		{$list_db = 0;}
		//if ($list_select != "") 	{$list_order = "order";}

		if (isset($_GET[$list_name . "_cat_id"])) {$list_cat_id = $_GET[$list_name . "_cat_id"];} else {$list_cat_id = $list_root;}

		$list_new_pid = $list_cat_id;

		if (isset($_GET[$list_name . "_item_id"])) {$list_item_id = $_GET[$list_name . "_item_id"];} else {if (isset($_GET[$list_name . "_" . $list_table . "_edit"])) {$list_item_id = $_GET[$list_name . "_" . $list_table . "_edit"];}}
		if (isset($_GET[$list_name . "_items_start"])) {$list_start = $_GET[$list_name . "_items_start"];} else{$list_start = 0;}
		if (isset($_GET[$list_name . "_item_limit"])) {$list_limit = $_GET[$list_name . "_item_limit"];}

		if (isset($_GET[$list_name . "_cat_expand"])) {
			$list_cat_expand = $_GET[$list_name . "_cat_expand"];
		} else {
			if ($list_gen == "") {
				$list_cat_expand = 2;
			} else {
				$list_cat_expand = $list_gen;
			}
		}

		if ($list_mode == "") {
			if ($list_item_id == "") {
				$items_mode = "list";
				$cats_mode = "list";
			} else {
				$items_mode = "zoom";
				$cats_mode = "list";
			}
		} else {
			$items_mode = $list_mode;
			$cats_mode = "list";
		}

		//if ($items_mode == 'zoom') {unset($list_group);} //v3.26
		if (isset($PAR['cats_mode'])) {}

		$DB = new db($list_db);

		$ALIST				= &$LIST[$list_name];
		$INI				= &$ALIST['INI'];

		$INI = $PAR;

		$INI						= &$ALIST['INI'];
		$INI['table']			= $list_table;
		$INI['root']				= $list_root;
		$INI['cat_id']			= $list_cat_id;
		$INI['item_id']			= $list_item_id;
		$INI['mode']			= $list_mode;
		$INI['cats_mode']		= $cats_mode;
		$INI['items_mode']		= $items_mode;
		$INI['cat_expand']		= $list_cat_expand;
		$INI['list_start']		= $list_start;
		$INI['list_limit']		= $list_limit;
		$INI['order']			= $list_order;
		$INI['allowed']			= $list_allowed;
		$INI['status']			= $list_status;
		$INI['page']			= $list_page;
		$INI['new']				= $list_new;
		$INI['db']				= $list_db;
		$INI['where']			= $list_where;
		$INI['altern']			= $list_altern;
		$INI['sys_form']		= $list_sys_form;
		$INI['ci_name']			= $list_ci_name;
		$INI['in_groups']		= $list_in_groups;
		$INI['in_types']		= $list_in_types;
		$INI['db_prefix']		= $list_db_prefix;
		$INI['new_pid']			= $list_new_pid;

		$INI['edit_return']	= $PAR['edit_return'];
		$INI['show_all']		= $PAR['show_all'];

	/// LOOK FOR POST
	 // UPDATE
		if (isset($CORE['POST'][$list_name . "_update"])) {
			$UPDATE = $CORE['POST'];
	//e($UPDATE);

			unset($CORE['POST'][$list_name . "_update"]);
			$table_type = $UPDATE[$list_name . "_type"];
			if ($table_type == "cats") {$query_table = "contents";} else {$query_table = $list_table;}

			$return_path = $CORE['POST']['return_path'];

			array_shift($UPDATE);
			array_pop($UPDATE);


			//unset($UPDATE['return_path']);

			if ($list_ci_name != "") {
				$ci_name = $PAR['ci_name'] . "_ci";
				$ci_id = data_switch("contents", $ci_name);

				if ($ci_id) {
					$CI_RES = tree($ci_id, 0, array('status'=>1, 'allowed'=>true));
					$CI = $CI_RES['CHILDS'];

					foreach ($CI as $ci_key => $CI_FIELD) {
						$CI_INDEX[$CI_FIELD['name']] = $ci_key;
					}
				} else {
					set_message("load rs", "row structure <b>$rs_name</b> dans <b>$list_name</b> est inexistant", 1);
				}
			}

			$FILED_FIELDS = $DB->table_show($query_table);

			foreach ($FILED_FIELDS as $TABLE_FIELD) {
				$VALID[] = $TABLE_FIELD['Field'];
			}

			foreach($UPDATE as $field => $field_value) {
				list($field_name, $field_id) = explode("-", $field);

				$AR[$field_name] = $field_value;

				if ($field_name == "status" && $field_value == 2) {
					contents_delete($field_id,$query_table);
				} else {
					$uv = $field_value;

					if (isset($CI_INDEX[$field_name])) {
						foreach ($CI[$CI_INDEX[$field_name]]['CHILDS'] as $TYPE) {
							$type		= $TYPE['type'];
							$type_name	= $LIST['types']['DATA'][$type]['name']; //$type_name	= 'ci_' . $LIST['types']['DATA'][$type]['name'];
							$par 		= $TYPE['par'];
							$RS_PAR		= explode_par($par);

							if (function_exists($type_name)) {
								$TYPE_INI = array('PAR' => $RS_PAR, 'af' => $field_name, 'av' => $field_value, 'uv' => &$uv, 'AR' => $AR);
								@call_user_func($type_name, &$TYPE_INI);
							} else {
								set_message("function_$type_name", "la function $type_name n'existe pas - content name : $field_name", 1);
							}
						}
					}

					if (in_array(lang($field_name), $VALID)) {
						$field_name = lang($field_name);
					}

					if (is_array($field_value)) {
						if ($field_name == 'allowed') {
							$uv = implode(',', $field_value);
						} else {
							$uv = implode('||', $field_value);
						}
					}

					if (!in_array($field_name, array('styles'))) { //v3.33 for custom or admin type
						$field_value = addslashes($uv);
						$query = "UPDATE `$query_table` SET `$field_name` = '$field_value' WHERE `id` = $field_id";
	//e($query);
						$DB->query($query);
					}
				}

				$page = qs_load();
			}

			$SCORPIO->clear_cache(1);
			$SCORPIO->last_updated();

			if ($return_path != '') {
				$page = $return_path;
			}

			header("Location:$page");	// je la comprends pas celle la
		}

		static $dup_done = 0;

		if (is_allowed(5)) {
			if (isset($CORE['GET'][$list_name . "_add"]) && $dup_done != 1) {
				unset($CORE['QS'][$list_name . "_add"]);
				$page 			= qs_load();
				$pid 			= $CORE['GET'][$list_name . "_add"];
				$parent_name 	= $LIST['contents']['DATA'][$pid]['name'];

				contents_add($pid, "New", $PAR);

				$SCORPIO->clear_cache(1);
				$SCORPIO->last_updated();

				$dup_done = 1;

				header("Location:$page");
				exit;
			}

			if (isset($CORE['GET'][$list_name . "_contents" . "_dup"]) && $dup_done != 1) {
				unset($CORE['QS'][$list_name . "_contents" . "_dup"]);

				$id 			= $CORE['GET'][$list_name . "_contents" . "_dup"];
				$original_name 	= $LIST['contents']['DATA'][$id]['name'];

				contents_duplicate($id, "$original_name", $PAR, "contents");
				$page 			= qs_load();

				$SCORPIO->last_updated();

				$dup_done = 1;

				header("Location:$page");
			}

			if (isset($CORE['GET'][$list_name . "_" . $list_table . "_dup"]) && $list_table != "contents" && $dup_done != 1) {
				unset($CORE['QS'][$list_name . "_" . $list_table . "_dup"]);

				$id 			= $CORE['GET'][$list_name . "_" . $list_table . "_dup"];
				$original_name 	= $LIST['contents']['DATA'][$id]['name'];

				if($CORE['GET']['mod'] == 'products') {
					$DUP = new doc($id);

					$DUP->saveas($DUP->DOC['type']);
				} else {
				contents_duplicate($id, "$original_name", $PAR, $list_table);
				}

				$page 			= qs_load();

				$SCORPIO->last_updated();

				$dup_done = 1;

				header("Location:$page");
				exit;
			}

			if (isset($CORE['GET'][$list_name . "_treedup"]) && $dup_done != 1) {
				unset($CORE['QS'][$list_name . "_treedup"]);
				$page 			= qs_load();
				$id 			= $CORE['GET'][$list_name . "_treedup"];

				contents_tree_duplicate($id);

				$SCORPIO->last_updated();

				$dup_done = 1;

				//header("Location:$page");
			}

			if (isset($CORE['GET'][$list_name . "_contents" . "_del"])) {
				unset($CORE['QS'][$list_name . "_contents" . "_del"]);
				$page 			= qs_load();
				$id 			= $CORE['GET'][$list_name . "_contents" . "_del"];

				contents_delete($id, "contents", $PAR);

				$SCORPIO->last_updated();

				header("Location:$page");
			}

			if (isset($CORE['GET'][$list_name . "_" . $list_table . "_del"]) && $list_table != "contents") {
				unset($CORE['QS'][$list_name . "_" . $list_table . "_del"]);
				$page 			= qs_load();
				$id 			= $CORE['GET'][$list_name . "_" . $list_table . "_del"];

				if($CORE['GET']['mod'] == 'products') {
					$CLEAN = new doc();

					$CLEAN->delete($id);

				} else {
					contents_delete($id, $list_table, $PAR);
				}



				$SCORPIO->last_updated();

				header("Location:$page");
			}

			if (isset($CORE['GET'][$list_name . "_" . $list_table . "_edit"]) && $list_table != "contents") {
				//unset($CORE['QS'][$list_name . "_" . $list_table . "_edit"]);

				$INI['system_edit'] = 1;
			}
		}

	/// CATS LIST
		$CAT_PAR					= array("gen" => $list_cat_expand, "allowed" => $list_allowed, "status" => $list_status,);
		$CAT_TREE					= tree2($list_cat_id, "", $CAT_PAR);
		$ALIST['CATS']				= tree_to_list($list_name, $CAT_TREE);

	/// ITEMS LIST
		$INI['SELECT_LIST'] 	= array('pid' => $list_cat_id, 'db_prefix' => $db_prefix, 'limit' => $list_limit, 'start' => $list_start, 'db' => $list_db, 'order' => $list_order, 'status' => $list_status, 'allowed' => $list_allowed, 'order_dir' => $list_order_dir, 'where' => $list_where, 'fields' => $list_select, 'group' => $list_group, 'in_groups' => $list_in_groups, 'in_types' => $list_in_types,);
		$INI['SELECT_ZOOM'] 	= array('id' => $list_item_id, 'db_prefix' => $db_prefix, 'status' => $list_status, 'allowed' => $list_allowed, 'db' => $list_db);

		if ($INI['show_all'] == 'true') {unset($INI['SELECT_LIST']['pid']);} //v3.25

		if ($items_mode == "list") { // ne contient aucune donnees
			$LIST_TEMP		= db_select($list_table, $INI['SELECT_LIST']);
		} else {
			$LIST_TEMP		= db_select($list_table, $INI['SELECT_ZOOM']);
		}

	/// LOOK FOR NEW  (ne devrait pas aller plus haut ?)
		if (is_allowed(5)) {
			if (isset($CORE['GET'][$list_name . "_" . $list_table . "_new"]) && $list_table != "contents") {
				unset($CORE['QS'][$list_name . "_" . $list_table . "_new"]);
				unset($CORE['GET'][$list_name . "_" . $list_table . "_new"]); //sinon exe 2 x le add

				$THIS 		= current($LIST_TEMP['DATA']);
				$id 		= $THIS['id'];

				$PAR['pid'] = $CORE['GET']['new_cat_id'];
				$new_id 	= contents_new("$original_name", $PAR, $list_table);

				$page 		= "?p=$list_page&" . $list_name . "_cat_id=" . $PAR['pid'] . '&' . $list_name . '_' . $list_table . '_edit=' . $new_id;
				header("Location:$page");
				exit;
			}
		}

		$ALIST['ITEMS']				= $LIST_TEMP['DATA'];
		$ALIST['INI']				= array_merge($ALIST['INI'], $LIST_TEMP['INI']);

		return print_r($ALIST,1);
	}

	function list_parse($PAR="") {
		global $LIST;
		global $TEMPLATES;
		global $CORE;
		global $SCORPIO;

	/// INI
		if (!isset($PAR['type'])) {$PAR['type'] = "items";}

		$list_name 		= $PAR['list'];
		$ALIST 			= &$LIST[$list_name];
		$INI			= &$ALIST['INI'];
		$TYPES			= &$LIST['types']['DATA'];
		$ITEMS_LIST 	= $ALIST[strtoupper($PAR['type'])];
		$lang 			= $LIST['lang']['DATA'][$CORE['SESSION']['lang']]; // lang update
		$parent			= $PAR['list'];
		$parse_count 	= 0;
		$cols_count 	= 1;

		if (!isset($PAR['parse_start'])) {$PAR['parse_start'] = 0;}    //v3.25
		if (!isset($PAR['parse_limit'])) {$PAR['parse_limit'] = 1000;} //v3.25

		if ($PAR['splash'] == 1 && !isset($_GET[$list_name . "_cat_id"])) { // SHOW NO RESULTS IF SPLASH v3.25

		} else {
			if (isset($INI['system_edit']) || $PAR['edit'] == 1) {
				$list_mode = "edit";
			} else {
				if ($PAR['type'] == "items") {if (isset($PAR['items_mode'])) {$list_mode = $PAR['items_mode'];} else {$list_mode = $INI['items_mode'];}}
				if ($PAR['type'] == "cats") {if (isset($PAR['cats_mode'])) {$list_mode = $PAR['cats_mode'];} else {$list_mode = $INI['cats_mode'];}}
			}

		/// PARENT
			if ($PAR['parent'] != "") {
				array_shift($ITEMS_LIST);

				if (count($ITEMS_LIST) == 0) {
					unset($ITEMS_LIST);
				}
			}

		/// ROW STRUCTURE
			if (!isset($PAR['rs_name'])) {$PAR['rs_name'] = "defaultlist";}

			if (($list_mode == "zoom" || $list_mode == "edit") && $PAR['type'] != "cats") { // patch
				$rs_name = $PAR['rs_name'] . "_" . $PAR['type'] . "_" . $list_mode;
			} else {
				$rs_name = $PAR['rs_name'] . "_" . $PAR['type'];
			}

			$rs_id = data_switch("contents", $rs_name);

			if (isset($ITEMS_LIST)) {
			/// TEMPLATE
				if ($list_mode == "edit" && $PAR['type'] != "cats") {
					$t_file_html	= t_load_file("form_items_new", "form_items_new", true);
					$t_list_html	= t_set_block("form_items_new", "SYSTEM_EDIT");
				} else {
					if (!isset($PAR['template'])) {$PAR['template'] = "defaultlist";}
					if ($PAR['sys']) {$sys = true;} else {$sys = false;}
					if ($PAR['mod']) {$content_path = $PAR['mod'] . "/themes/default/templates/";}
					if ($list_mode == 'edit' && $PAR['type'] == 'cats') {$t_mode = 'LIST';} else {$t_mode = strtoupper($list_mode);}

					$t_file_html	= t_load_file($PAR['template'], $PAR['template'], $sys, $content_path);

					$t_block_sep_html = t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . $t_mode . "_SEP"); //v3.32

					if (isset($PAR['col_num'])) {
						$t_cols_html	= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . $t_mode . "_COL");
						$t_block_html	= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . $t_mode . "_ROW");
					} else {
						$t_block_html	= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . $t_mode . "_ROW");
					}


					if ($INI['altern'] == "true") {
						$t_block2_html	= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . $t_mode . "_ROW2");
					}

					if (isset($PAR['more'])) {$t_more_html	= t_set_block($PAR['template'], "ITEMS_MORE");}

					$t_list_html	= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . $t_mode);
				}

				if ($rs_id) {
					$RS_RES = tree2($rs_id, 0, array('status'=>1, 'allowed'=>true));
					$RS = $RS_RES['CHILDS'];
				} else {
					set_message("load rs", "row structure <b>$rs_name</b> dans <b>$list_name</b> est inexistant", 1);
				}

			/// LOOP THEM ALL  ////// POURRAIT PAS PASSER PAR CONTENT ????
				$row2 = 1;
				$items_total = count($ITEMS_LIST);
				$items_left  = $items_total;

				$DB = new db($INI['db']);

				$META = $DB->metadata($INI['table']);

				foreach ($META as $this_field) {  // added v3.22
					$FIELDS[] = $this_field['name'];
				}

				$FIELDS_KEYS = array_flip($FIELDS);  // added v3.22

				foreach($ITEMS_LIST as $ITEM) {
					if ($parse_count >= $PAR['parse_start'] && $parse_count < ($PAR['parse_start'] + $PAR['parse_limit'])) {  //v3.25
						$HTML = $ITEM;
						$ITEM['list_name'] = $list_name;
						$ITEM_PAR = explode_par($ITEM['par']);

						if (($ITEM_PAR['hidden'] == "" && $INI['type'] != "cats") || is_allowed($ITEM_PAR['hidden'])) {
							if (isset($RS)) {
								foreach($RS as $key=>$RS_FIELD) {
									$field_name 		= $RS_FIELD['name'];
									$field_name_func 	= $RS_FIELD['name'];
									$FIELD_PAR			= explode_par($RS_FIELD['par']);
									$FIELDSADD_RS[$RS_FIELD['name']] = $RS_FIELD['id'];

									unset($FIELDS_KEYS[$field_name]);  // added v3.22

								///	LANGUAGE SELECTION
									if (isset($ITEM[$RS_FIELD['name'] . "_" . $lang])) {
										$HTML[$RS_FIELD['name']] = $ITEM[$RS_FIELD['name'] . "_" . $lang];
										$field_name_func = $RS_FIELD['name'] . "_" . $lang;
									}

									foreach ($RS_FIELD['CHILDS'] as $TYPE) {
										$type_name	= $TYPES[$TYPE['type']]['function'];
										$par 		= $TYPE['par'];
										$RS_PAR		= explode_par($par);
										$ADMIN_TYPES[$TYPE['id']] = $TYPE;
										$PROUT[$RS_FIELD['name']][$TYPE['id']] = $TYPE['name']; // 3.23 for admin structs

										if (isset($RS_PAR['function'])) {$type_name = $RS_PAR['function'];} //v3.20 custom types

										if (function_exists($type_name)) {
											$HTML[$field_name] = @call_user_func($type_name, $ITEM, &$HTML, $par, $field_name_func, $TYPE) . "\n";
										} else {
											if (trim($type_name) != '') { //v3.25 gossait pas mal
												set_message("function_$type_name", "la function $type_name n'existe pas - content name : $field_name", 1);
											}
										}
									}

									$class_name		= $RS_FIELD['class'];

								/// CAPTION CODE // peut servir pour debuger les contents
									$caption 		= $FIELD_PAR['caption'];

									if ($caption != "" && is_allowed($caption)) {  //exploder a keke part dautre
										$caption_text = $RS_FIELD[lang("label")];
										$HTML[$field_name] = "$caption_text" . $HTML[$field_name];
									}

									if ($class_name != "") {
										$class = strtoupper($class_name);
										$HTML[$field_name] = "\n<div class=\"$class\">" . $HTML[$field_name] . "</div>";
									}
								}
							}

							if ($list_mode == "edit") {
								foreach ($FIELDSADD_RS as $used_key  => $value) {
									$block_html .= $HTML[$used_key];
								}

								reset($FIELDSADD_RS);
							} else {
								if (isset($PAR['col_num']) && $t_mode != 'ZOOM' ) {  // && $PAR['type'] != 'items'
									$cols_html .= set_var($t_cols_html, $HTML);
							//e($PAR['type'],1);
							//e($cols_count . ' - ' . $items_left,1);
									if ($cols_count == $PAR['col_num'] || $items_left == 1) {
										if ($INI['altern'] == "true" && $row2 == -1) {
											$row2 *= -1;
											$block_html .= set_var($t_block2_html, strtoupper($PAR['type']) . "_" . $t_mode . "_COL", $cols_html);
										} else {
											$row2 *= -1;
											$block_html .= set_var($t_block_html, strtoupper($PAR['type']) . "_" . $t_mode . "_COL", $cols_html);
										}

										$cols_html = '';
										$cols_count = 1;
									} else {
										$cols_count++;
									}
								} else {
									if ($INI['altern'] == "true" && $row2 == -1) {
										$row2 *= -1;
										$block_html .= set_var($t_block2_html, $HTML);
									} else {
										$row2 *= -1;
										$block_html .= set_var($t_block_html, $HTML);
									}
								}

								if ($items_left > 1) {
									// if ($PAR['sep'] == 'hr') {
										// $block_html .= '<hr />';
									// }

									if ($PAR['sep'] == true) {

										$block_html = set_var($block_html, strtoupper($PAR['type']) . "_" . $t_mode . "_SEP", $t_block_sep_html);
									}

									$items_left--;
								}
							}
						}
					}

					$parse_count++;
				}

				reset($ITEMS_LIST);

			/// ADD FORM IF ALLOWED
				if (is_allowed(5) && $block_html != "" && ($PAR['form'] != "0" || $list_mode == "edit")) { //
					if ($INI['edit_return'] == 1) {
						//$NEW_QS = $CORE['QS'];
						//array_pop($NEW_QS);
						$form_start = BR . url('Voir les détails du document', '?p=prod_documents&' . $list_name . '_item_id=' . $ITEM['id']) . BR;
					}

					if ($_GET['live'] == 'true') {
						$onsubmit = "onsubmit=\"live_php('live_content','?p=live_contents&live=true&method=post&live_id=" . $_GET['live_id'] . "' ,'post',this);";
					} else {
						$onsubmit = "onsubmit=\"return submitForm();\"";
					}

					$form_start .= "<form action=\"$page\" method=\"post\" name=\"form_$list_name\" $onsubmit\">"
								 . "	<input name=\"$list_name" . "_type\" type=\"hidden\" value=\"" . $PAR['type'] . "\">";
					$form_end	.= "	<center><input name=\"$list_name" . "_update\" type=\"submit\" id=\"submit_$list_name\" value=\"METTRE A JOUR\"></center>"
								//. "	<input name=\"reset_$list_name\" type=\"reset\" id=\"reset_$list_name\" value=\"RESET\"></center>"
								 . "</form>";



					$t_list_html 	= set_var($t_list_html, "FORM_BEGIN", $form_start);
					$t_list_html 	= set_var($t_list_html, "FORM_END", $form_end);
				} else { //REMOVE TAG IF FORM IS NOT PARSED v3.33
					$t_list_html 	= set_var($t_list_html, array("FORM_BEGIN" => '', "FORM_END" => ''));

				}

			/// ADD MORE
				if (isset($PAR['more']) && $list_mode != "edit") {
					$more_label 	= lang_arr($PAR['more']);
					$more_page 		= $PAR['more_page'];

					$more_url		= "<a href=\"?p=$more_page\">$more_label</a>";

					$t_more_html 	= set_var($t_more_html, "MORE_URL", $more_url);
					$t_list_html 	= set_var($t_list_html, "ITEMS_MORE", $t_more_html);
				}

				if ($list_mode == "edit") {
					$return = set_var($t_list_html, "FORM_CONTENT", $block_html);
				} else {
					$return = set_var($t_list_html, strtoupper($PAR['type']) . "_" . strtoupper($list_mode . "_ROW"), $block_html);
				}

			} else {
				if ($PAR['no_item_show'] != "false") { // me semble que ca la pas rap
					$return = "<div style=\"clear:both;\">" . lang_arr(array("Aucun item trouvé", "No items found"))  . "</div>";
				}
			}

		/// ADD ITEM OR CAT
			if (is_allowed(5) && $PAR['add'] != "false") {
				if (isset($INI['new'])) {$new_list = $INI['new'];} else {$new_list = $list_name;}
				if (isset($PAR['new_name'])) {$new_name = $PAR['new_name'];} else {$new_name = 'AJOUTER UN ITEM';}
		//e($new_name);
				if ($PAR['type'] == "items") {
					$return = "<br /><a href=\"?p=" . $INI['page'] . "&" . $new_list . "_" . $INI['table'] . "_new=true&new_cat_id=" . $INI['new_pid'] . "\"><font style=\"font-size:smaller;\">$new_name</font></a><br /><br />" . $return;
				} else if ($PAR['edit_cats'] != "false") {
					$return = "<br /><a href=\"?p=admin_cats&catslist_cat_id=" . $INI['root'] . "\"><font style=\"font-size:smaller;\">MODIFIER-AJOUTER UNE CATÉGORIE</font></a><br /><br />" . $return;
				}
			}

		/// ADD STRUCT
			if (isset($CORE['GET']["rs_add"]) && is_allowed(6)) {
				unset($CORE['QS']["rs_add"]);

				$page 			= qs_load();
				$pid 			= 36;
				$field_name 	= $CORE['GET']["rs_add"];

				$FIELD_PAR 		= array();

				$new_id = contents_add($pid, $field_name, $FIELD_PAR);

				$SCORPIO->clear_cache(1);
				$SCORPIO->last_updated();

				header("Location:$page");
			}

			if (isset($CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id"]) && is_allowed(6)) {
				unset($CORE['QS'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id"]);
				unset($CORE['QS'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name"]);

				$page 			= qs_load();
				$pid 			= $CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id"];
				$parent_name 	= $LIST['contents']['DATA'][$pid]['name'];
				$field_name 	= $CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name"];

				$FIELD_PAR 		= array();

				switch ($CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name"]) {    //v3.32

					case 'admin':
						$FIELD_PAR				= array('order' => 100);
						$SUBFIELD_PAR	= array('type' => 85, 'allowed' => 5);
					break;

					case 'pid':
						$FIELD_PAR				= array('order' => 200);
						$SUBFIELD_PAR	= array('type' => 75, 'allowed' => 5);
					break;

					case 'allowed':
						$FIELD_PAR				= array('order' => 1200);
						$SUBFIELD_PAR	= array('type' => 98, 'allowed' => 5);
					break;

					default:
						$SUBFIELD_PAR	= array('type' => 74, 'allowed' => 5);
				}

				$new_id = contents_add($pid, $field_name, $FIELD_PAR);
				contents_add($new_id, $field_name . "_input", $SUBFIELD_PAR);

				$SCORPIO->clear_cache(1);
				$SCORPIO->last_updated();

				header("Location:$page");
			}

			if (isset($CORE['POST']["fields_update"])) {
				$UPDATE = $CORE['POST'];
				$DB_FIELDS = new db();

				array_pop($UPDATE);

				foreach($UPDATE as $field => $field_value) {
					list($field_name, $field_id) = explode("-", $field);

					if ($field_name == "status" && $field_value == 2) {
						contents_delete($field_id,$query_table);
					} else {
						$field_value = addslashes($field_value);
						$query = "UPDATE `contents` SET `$field_name` = '$field_value' WHERE `id` = '$field_id';";
						$DB_FIELDS->query($query);
					}
				}

				$page = qs_load();
				header("Location:$page");
			}

			if (is_allowed(6)  && $PAR['struct'] != "false") {
				$FIELDS_UNUSED = array_flip($FIELDS_KEYS);
				$page 			= qs_load();

				$FIELDS_ADD[] = "<div class=\"MENU_GOD_SWITCH\">";
				$FIELDS_ADD[] = "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"fields_update\" id=\"fields_update\">";
				$FIELDS_ADD[] = "<table border=\"0\">";
				$FIELDS_ADD[] = "<tr><td colspan=\"7\">";

				if ($rs_id == "") {
					$FIELDS_ADD[] =	"add <a href=\"$page&rs_add=$rs_name\"><font style=\"font-size:smaller;\">$rs_name</font></a>";
					$FIELDS_ADD[] = "</td></tr>";
					$FIELDS_ADD[] = "</table>";
					$FIELDS_ADD[] = "</form>";
					$FIELDS_ADD[] = "</div>";
				} else {
					$FIELDS_ADD[] = "edit <a href=\"?p=admin_structs&structslist_cat_id=$rs_id\" target=\"_blank\"><font style=\"font-size:smaller;\">$rs_name</font></a>";
					$FIELDS_ADD[] = "</td></tr>";

				/// IN DB LIST
					foreach ($FIELDS as $to_soude) {
						$FIELDS_ADD[] = "<tr>";

						if (isset($CORE['GET'][$list_name . "_" . $INI['table'] . "_edit"])) {$edit_url = "&" . $list_name . "_" . $INI['table'] . "_edit=" . $CORE['GET'][$list_name . "_" . $INI['table'] . "_edit"];}

						if (in_array($to_soude,$FIELDS_UNUSED)) {
							$FIELDS_ADD[] = "<td><a href=\"$page&" . $list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id=" . $rs_id . "&" . $list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name=" . $to_soude . $edit_url . "\"> + </a></td><td colspan=\"6\"><b>" . $to_soude . "</b> (in db)</td>";
						} else {
							foreach ($PROUT[$to_soude] as $prout_key => $prout_value) {
								$struct_rows .=
								"<tr>"
								. "<td><a href=\"$page&" . $list_name . "_contents_del=" . $ADMIN_TYPES[$prout_key]['id'] . $edit_url . "\"> X </a></td>"
								. "<td><input name=\"label_fr-" . $prout_key . "\" id=\"label_fr-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['label_fr'] . "\" size=\"10\"/></td>"
								. "<td>" . select_build($TYPES, "selector_types", 'id', 'name', "type-" . $prout_key, $ADMIN_TYPES[$prout_key]['type'], true) . "</td>"
								. "<td><input name=\"par-" . $prout_key . "\" id=\"par-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['par'] . "\" size=\"12\"/></td>"
								. "<td><input name=\"order-" . $prout_key . "\" id=\"order-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['order'] . "\" size=\"3\"/></td>"
								. "<td><input name=\"allowed-" . $prout_key . "\" id=\"allowed-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['allowed'] . "\" size=\"1\"/></td>"
								. "<td><input name=\"status-" . $prout_key . "\" id=\"status-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['status'] . "\" size=\"1\"/></td>"
								. "</tr>";
							}

							$FIELDS_ADD[] =   "<td valign=\"top\"><a href=\"$page&" . $list_name . "_contents_del=" . $FIELDSADD_RS[$to_soude] . $edit_url . "\"> X </a></td>"
											. "<td valign=\"top\"><a href=\"?p=admin_structs&structslist_cat_id=" . $FIELDSADD_RS[$to_soude] . "\" target=\"_blank\"> $to_soude</a> (in db)</td>"
											. "<td><table>$struct_rows</table></td>";

							$struct_rows = '';
						}
					}

					$FIELDS_ADD[] = "</tr>";
					$FIELDS_ADD[] = "<tr><td colspan=\"3\">---------</td></tr>";

				/// ADMIN IN RS LIST
					foreach ($FIELDSADD_RS as $field_key  => $field_value) {
						$FIELDS_ADD[] = "<tr>";

						if (!in_array($field_key,$FIELDS)) {
							foreach ($PROUT[$field_key] as $prout_key => $prout_value) {
								$struct_rows .=
								"<tr>"
								. "<td><a href=\"$page&" . $list_name . "_contents_del=" . $ADMIN_TYPES[$prout_key]['id'] . $edit_url . "\"> X </a></td>"
								. "<td><input name=\"label_fr-" . $prout_key . "\" id=\"label_fr-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['label_fr'] . "\" size=\"10\"/></td>"
								. "<td>" . select_build($TYPES, "selector_types", 'id', 'name', "type-" . $prout_key, $ADMIN_TYPES[$prout_key]['type'], true) . "</td>"
								. "<td><input name=\"par-" . $prout_key . "\" id=\"par-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['par'] . "\" size=\"12\"/></td>"
								. "<td><input name=\"order-" . $prout_key . "\" id=\"order-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['order'] . "\" size=\"3\"/></td>"
								. "<td><input name=\"allowed-" . $prout_key . "\" id=\"allowed-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['allowed'] . "\" size=\"1\"/></td>"
								. "<td><input name=\"status-" . $prout_key . "\" id=\"status-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['status'] . "\" size=\"1\"/></td>"
								. "</tr>";
							}

							$FIELDS_ADD[] =   "<td valign=\"top\"><a href=\"$page&" . $list_name . "_contents_del=" . $FIELDSADD_RS[$field_key] . $edit_url . "\"> X </a></td>"
											. "<td valign=\"top\"><a href=\"?p=admin_structs&structslist_cat_id=" . $FIELDSADD_RS[$field_key] . "\" target=\"_blank\"> $field_key</a> (in db)</td>"
											. "<td><table>$struct_rows</table></td>";

							$struct_rows = '';
							$FIELDS[] = $field_key;
						}
					}

					$FIELDS_ADD[] = "</tr>";
					$FIELDS_ADD[] = "<tr><td colspan=\"3\">---------</td></tr>";

				/// ADMIN NOT IN RS LIST
					$ADMIN_ARR = array("admin","img","img_sel","html","label","desc", 'styles',"custom1","custom2","custom3","custom4","custom5","custom6");

					foreach ($ADMIN_ARR as $admin_struct) {
						if (!in_array($admin_struct,$FIELDS)) {
							$FIELDS_ADD[] = "<tr>";
							$FIELDS_ADD[] = "<td><a href=\"$page&" .$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id=" . $rs_id . "&" . $list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name=" . $admin_struct . $edit_url . "\"> + </a></td><td colspan=\"6\"><b>" . $admin_struct . "</b></td>";
							$FIELDS[] = $admin_struct;
							$FIELDS_ADD[] = "</tr>";
						}
					}

					$FIELDS_ADD[] = "<tr><td colspan=\"7\"><input name=\"fields_update\" type=\"submit\" id=\"fields_update\" value=\"GO\"></td></tr>";
					$FIELDS_ADD[] = "</table>";
					$FIELDS_ADD[] = "</form>";
					$FIELDS_ADD[] = "</div>";
				}

				$fields_add .= implode("", $FIELDS_ADD);
				$return = $fields_add . $return;
			}
		}

		if (isset($PAR['data_only']) && $list_mode != "edit") {$return = $HTML; e($HTML); }

		return $return;
	}

	function list_new($PAR="") {
		global $LIST;
		global $TEMPLATES;
		global $CORE;

		if (is_allowed(5)) {
		/// INI
			$list_name 	= $PAR['list'];
			$ALIST 		= &$LIST[$list_name];
			$INI		= &$ALIST['INI'];

		/// TEMPLATE
			if (!isset($PAR['template'])) {$PAR['template'] = "defaultlist";}
			if ($PAR['sys']) {$sys = true;} else {$sys = false;}

			$t_file_html	= t_load_file($PAR['template'], $PAR['template'], $sys);
			$t_block_html	= t_set_block($PAR['template'], "ITEMS_NEW");

		}

		return $return;
	}

	function list_nav($PAR="") {
		global $LIST;
		global $TEMPLATES;
		global $CORE;

		$list_name 	= $PAR['list'];

		if ($PAR['splash'] == 1 && !isset($_GET[$list_name . "_cat_id"])) { // SHOW NO RESULTS IF SPLASH v3.25

		} else {
			$DB = new db();

			$ALIST 		= &$LIST[$list_name];
			$INI		= &$ALIST['INI'];

			if (!isset($PAR['type'])) {$PAR['type'] = "items";}

			$cat_id						= $INI['cat_id'];
			$item_id 					= $INI['item_id'];
			$list_start 				= $INI['list_start'];
			$list_limit 				= $INI['list_limit'];
			$list_type					= $PAR['type'];
			$root_id 					= $INI['root'];
			$list_table 				= $INI['table'];
			$list_order 				= $INI['order'];

		/// GET TOTAL ITEMS
			if ($list_type != "cats") {
				$SELECT_NAV 			= $INI['SELECT_LIST'];
				unset($SELECT_NAV['limit'], $SELECT_NAV['start']);
				$SELECT_NAV['index'] 	= "1";
				//$SELECT_NAV['db_prefix'] 	= $INI['db_prefix'];
				$ITEMS_TOTAL 			= db_select($list_table, $SELECT_NAV);
				$list_total 			= $ITEMS_TOTAL['INI']['list_total'];
			}

			$nav_page				= $CORE['GET']['p'];
			if (isset($_GET['m'])) {$nav_page .= '&m=' . $_GET['m'];} //3.29

			if ($list_type == "items") {
				if ($list_total > 0) {
				/// TEMPLATE
					if (isset($INI['system_edit'])) {
						$t_file_html	= t_load_file("form_items_new", "form_items_new", true);
					} else {
						if (!isset($PAR['template'])) {$PAR['template'] = "defaultlist";}
						if ($PAR['sys']) {$sys = true;} else {$sys = false;}

						$t_file_html	= t_load_file($PAR['template'], $PAR['template'], $sys);
					}

				/// ITEMS NAVIGATION
					if ($_GET['type'] != '') {$doc_type = '&type=' . $_GET['type'];}  //prod patch

					$nav_cat_url				= $list_name . "_cat_id=$cat_id" . $doc_type;
					$nav_item_url				= $list_name . "_item_id";

					if (!isset($item_id)) {
						$list_mode = "list";

					/// NAV FIRST
						if ($list_start <= 0) {
							$nav_first 			= " " . lang_arr(array("PREMIER", "FIRST")) . " ";
						} else {
							$nav_first_url 		= $list_name . "_$list_type" . "_start=0";
							$nav_first 			= "<a href=\"?p=$nav_page&$nav_cat_url&$nav_first_url\"> " . lang_arr(array("PREMIER", "FIRST")) . " </a>";
						}

					/// NAV PREV
						if ($list_start >= $list_limit) {
							$nav_prev_url 		= $list_name . "_$list_type" . "_start=" . ($list_start - $list_limit);
							$nav_prev 			= "<a href=\"?p=$nav_page&$nav_cat_url&$nav_prev_url\"> " . lang_arr(array("PRÉCÉDENT", "PREVIOUS")) . " </a>";
						} else {
							$nav_prev 			= " " . lang_arr(array("PRÉCÉDENT", "PREVIOUS")) . " ";
						}

					/// NAV NEXT
						if ($list_start <= ($list_total - $list_limit)) {
							$nav_next_url 		= $list_name . "_$list_type" . "_start=" . ($list_start + $list_limit);
							$nav_next 			= "<a href=\"?p=$nav_page&$nav_cat_url&$nav_next_url\"> " . lang_arr(array("SUIVANT", "NEXT")) . " </a>";
						} else {
							$nav_next 			= " " . lang_arr(array("SUIVANT", "NEXT")) . " ";
						}

					/// NAV LAST
						if ($list_start < ($list_total - $list_limit + 1)) {
							$nav_last_url 		= $list_name . "_$list_type" . "_start=" . ($list_total - $list_limit + 1);
							$nav_last 			= "<a href=\"?p=$nav_page&$nav_cat_url&$nav_last_url\"> " . lang_arr(array("DERNIER", "LAST")) . " </a>";
						} else {
							$nav_last 			= " " . lang_arr(array("DERNIER", "LAST")) . " ";
						}

					/// NAV POSITION
						$nav_start_label = $list_start + 1;

						if (($list_start + $list_limit) > $list_total) {
							$nav_end_label = $list_total;
						} else {
							$nav_end_label = $list_start + $list_limit;
						}

						$nav_position = "$nav_start_label - $nav_end_label / $list_total";

					/// set var
						$NAV_LIST['ITEMS_RETURN_URL'] 	= "?p=$nav_page&$nav_cat_url";
						$NAV_LIST['ITEMS_RETURN_LABEL'] = "LISTE COMPLETE";

						$NAV_LIST['NAV_FIRST'] 			= $nav_first;
						$NAV_LIST['NAV_PREV'] 			= $nav_prev;
						$NAV_LIST['NAV_NEXT'] 			= $nav_next;
						$NAV_LIST['NAV_LAST'] 			= $nav_last;
						$NAV_LIST['NAV_POSITION'] 		= $nav_position;

						$t_block_html					= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . strtoupper($list_mode) . "_NAV");
						$return						   .= set_var($t_block_html, $NAV_LIST);
					} else {
						$list_mode = "zoom";

						$NAV_INFO 					= array_neighbor($ITEMS_TOTAL['DATA'], $item_id);
						$items_position 			= $NAV_INFO[2];

						if (isset($INI['system_edit'])) { //3.29
							$nav_edit_url .= $list_name . '_' . $list_table . '_edit';

							$NAV_LIST['NAV_PREV'] 		= "<a href=\"?p=" . "$nav_page&$nav_cat_url&$nav_item_url=" . $NAV_INFO[0] . "&$nav_edit_url=" . $NAV_INFO[0] . "\"> " . lang_arr(array("PRÉCÉDENT", "PREVIOUS")) . " </a>";
							$NAV_LIST['NAV_NEXT'] 		= "<a href=\"?p=" . "$nav_page&$nav_cat_url&$nav_item_url=" . $NAV_INFO[1] . "&$nav_edit_url=" . $NAV_INFO[1] . "\"> " . lang_arr(array("SUIVANT", "NEXT")) . " </a>";
							$NAV_LIST['NAV_RETURN'] 	= "<a href=\"?p=" . "$nav_page&$nav_cat_url\">" . lang_arr(array("RETOUR A LA LISTE", "RETURN TO LIST")) . " </a>";
						} else {
							$NAV_LIST['NAV_PREV'] 		= "<a href=\"?p=" . "$nav_page&$nav_cat_url&$nav_item_url=" . $NAV_INFO[0] . "\"> " . lang_arr(array("PRÉCÉDENT", "PREVIOUS")) . " </a>";
							$NAV_LIST['NAV_NEXT'] 		= "<a href=\"?p=" . "$nav_page&$nav_cat_url&$nav_item_url=" . $NAV_INFO[1] . "\"> " . lang_arr(array("SUIVANT", "NEXT")) . " </a>";
							$NAV_LIST['NAV_RETURN'] 	= "<a href=\"?p=" . "$nav_page&$nav_cat_url\">" . lang_arr(array("RETOUR A LA LISTE", "RETURN TO LIST")) . " </a>";
						}

						if (isset($INI['system_edit'])) {
							$t_block_html	= t_set_block("form_items_new", "ITEMS_ZOOM_NAV");
						} else {
							$t_block_html		= t_set_block($PAR['template'], strtoupper($PAR['type']) . "_" . strtoupper($list_mode) . "_NAV");
						}

						$return			   .= set_var($t_block_html, $NAV_LIST);
					}
				} else {
					//set_message("function_$list_nav", "la base <b>" . $INI['table'] . "</b> ne contient aucune donnÃ©es", 1);
				}
			} else if ($list_type == "cats") {
				$NAV = array();

				if (isset($PAR['catlist'])) {$catlist = $PAR['catlist'];} else {$catlist = "contentslist";}

				$this_cat_pid	= substr($LIST["contents"]['DATA'][$cat_id]['pid'], 1, -1);

				while ($this_cat_pid != $root_id && $cat_id != $root_id) {
					array_unshift($NAV, "<a href=\"?p=$nav_page&" . $catlist . "_cat_id=$this_cat_pid\">" . $LIST["contents"]['DATA'][$this_cat_pid]['label_fr'] . "</a>");
					$this_cat_pid 	= substr($LIST["contents"]['DATA'][$this_cat_pid]['pid'], 1, -1);
				}

	//			if ($PAR['parent'] == "" && $PAR['parent'] != "false") {;
	//
	//				array_unshift($NAV, "<a href=\"?p=$nav_page&" . $catlist . "_cat_id=$root_id\">" . $LIST["contents"]['DATA'][$root_id]['label_fr'] . "</a>");
	//			}

				if ($PAR['parent'] != "" && $PAR['parent'] != "false") {;
					array_unshift($NAV, "<a href=\"?p=" . $PAR['parent'] . "\">" . $LIST["contents"]['DATA'][$root_id]['label_fr'] . "</a>");
				}

				$root_page_id 		= data_switch("contents", $PAR['page']);
				$root_page_label   	= $LIST["contents"]['DATA'][$root_page_id]['label_fr'];

				if ($PAR['page'] != "") {
					array_unshift($NAV, "<a href=\"?p=" . $PAR['page'] . "\">" . $root_page_label . "</a>"); //page
				}

				if ($cat_id != $root_id) {
					$NAV[] 		= "<a href=\"?p=$nav_page&" . $catlist . "_cat_id=$cat_id\">" . $LIST["contents"]['DATA'][$cat_id]['label_fr'] . "</a>";
				}

				$nav = 'NAVIGATION -> ' . implode(" -> ", $NAV);

				if (isset($PAR['sys'])) {$sys = $PAR['sys'];}
				if ($PAR['mod']) {$content_path = $PAR['mod'] . "/themes/default/templates/";}

				$t_file_html		= t_load_file($PAR['template'], $PAR['template'], $sys, $content_path);
				$t_cat_nav_html		= t_set_block($PAR['template'], "CATS_NAV");
				$nav_html 			= set_var($t_cat_nav_html, "CATS_NAV", $nav);

				$return .= $nav_html;
			}
		}

		set_function("type_cat_zoom", $list_name);
		return $return;
	}

	function content($id, $level=0) {
		global $LIST;
		global $TEMPLATES;
		global $CORE;


		$spacer 		= spacer($level*2, " ");
		$spacer_html	= spacer($level*4, " ");

		$CONTENTS		= &$LIST['contents']['DATA'];
		$CHILDS 		= tree2($id,0, array('status'=>1, 'allowed'=>true));
		$AC 			= &$CONTENTS[$id];

		if ($AC['type'] != 0) {	 //v3.16 patch pour enlever le message 0 in types, fadra trouver autre chose parempe
			$type_name 		= list_search("types", "id", $AC['type'], "function");
		}

		$content_name 	= $AC['name'];
		$PAR			= $AC['par']; // a faire exploder avant denvoyer dans les functions
		$EXPLODED_PAR	= explode_par($AC['par']); // a faire exploder avant denvoyer dans les functions

		$template_name	= $AC['template'];
		$block_name		= $AC['block'];
		$class_name		= $AC['class'];

		if (isset($CHILDS['CHILDS'])) {
			foreach($CHILDS['CHILDS'] as $CHILD) {
				if ($CHILD['type'] != 1 && $level == 0) { // pour pas parser les sous pages, chu fort | ajoutï¿½ le == 0 pour parser la class de la premiere page
					$html .= content($CHILD['id'],$level) . "\n";
					$count++;
				}
			}
		}

		if (isset($EXPLODED_PAR['function'])) {$type_name = $EXPLODED_PAR['function'];} //v3.20 custom types

		if (function_exists($type_name)) {
			$html .= @call_user_func($type_name, $AC, $html, $AC['par']) . "\n";
		} else {
			if (trim($type_name) != '') { //v3.25 gossait pas mal
				set_message("function_$type_name", "la function $type_name n'existe pas - content name : $field_name", 1);
			}
		}

		if (isset($AC)) {
			foreach($AC as $key=>$value) {
				$TAC[strtoupper($key)] = $value;
			}
		}

		$level++;

	/// BLOCK CODE IN THERE
		$html = set_var($html,$TAC);



		if ($class_name != "") {
			if ($AC['name'] == "middle_center" && $CORE['MAIN']['back'] != "") {
				if ($CORE['MAIN']['back'] == "none") {
					$style = " style=\"background-image:none;background-repeat:no-repeat;\"";
				} else {
					$back_file = $CORE['MAIN']['back'];
					$style = " style=\"background-image:url(themes/default/images/$back_file);background-repeat:no-repeat;\"";
				}
			}

			$class = strtoupper($class_name);

			$html = "\n$spacer<div id=\"$class_name\" class=\"$class\"$style$div_fix>\n$spacer_html$html$spacer</div>";


		}

		if (isset($EXPLODED_PAR['title_content']))  {
			if ($EXPLODED_PAR['title_content'] != 'true')  {
				$content_class = strtoupper($EXPLODED_PAR['title_content']);
			} else {
				$content_class = 'CONTENT_TITLE';
			}

			if(is_allowed(6)) {' ' . $title_edit = url(I_EDIT . ' ', "?p=admin_contents&contentslist_cat_id=$id");}

			$html = "\n$spacer<div class=\"" . $content_class . "\"$style$div_fix>" . $title_edit . $AC[lang('label')] . "</div>\n" . $html;
		}

		$CORE['DEBUG']['CONTENTS'][] = "$content_name - $type_name";
		set_function("content", "$content_name | " . count($RESULTS));

		return $html;
	}

	function tree2($id, $level=0, $PAR="") {
		global $CHILDS_INDEX;
		global $LIST;
		global $CORE;

		$TYPES		= @to_array($PAR['TYPES']);
		$CONTENTS	= $LIST['tree_data']['DATA'][$id];

		$level++;

		if (!isset($PAR['allowed']) || (isset($PAR['allowed']) && is_allowed($CONTENTS['allowed']))) {
			if (!isset($PAR['status']) || (isset($PAR['status']) && $CONTENTS['status'] == 1)) {
				if (($TYPES == "") || ($TYPES != "" && in_array($CONTENTS['type'],$TYPES))) {
					$TREE			= $CONTENTS;
					$TREE['level']	= $level;
					$CORE['DEBUG']['tree2_count'] += 1;

					$CHILDS_IDS		= $CHILDS_INDEX[$id];

					if (!isset($PAR['gen']) || (isset($PAR['gen']) && $PAR['gen'] >= $level+1) ) {
						if (count($CHILDS_IDS)) {
							foreach ($CHILDS_IDS as $child_id) {
								$RESULTS = tree2($child_id, $level, $PAR);

								if ($RESULTS) {
									$CHILDS[$child_id] = $RESULTS;
								}
							}

							$TREE['CHILDS'] = $CHILDS;
						}
					}
				}
			}
		}

		return $TREE;
	}

	function get_childs2($id) {
		global $CHILDS_INDEX;
		//global $PARENTS_INDEX;

		$CHILDS = $CHILDS_INDEX[$id];

		return $CHILDS;
	}


	function tree($id=0, $level=0, $PAR="") {
		global $LIST;
		global $CORE;

		$TYPES = @to_array($PAR['TYPES']);
		$level++;

		if (isset($PAR['db'])) {
			if (!isset($LIST['contents_' . $PAR['db']])) {
				$LIST['contents_' . $PAR['db']] = db_select("contents", array('db' => $PAR['db']));
			}

			$CONTENTS = $LIST['contents_' . $PAR['db']]['DATA'];
		} else {
			$CONTENTS = $LIST['contents']['DATA'];
		}

		if ($id == 0) {$id = "0";}

		if (!isset($PAR['allowed']) || (isset($PAR['allowed']) && is_allowed($CONTENTS[$id]['allowed']))) {
			if (!isset($PAR['status']) || (isset($PAR['status']) && $CONTENTS[$id]['status'] == 1)) {
				if (($TYPES == "") || ($TYPES != "" && in_array($CONTENTS[$id]['type'],$TYPES))) { // || $CONTENTS[$id]['type'] == 0
					$CONTENTS[$id]['level']  = $level;
					$TREE = $CONTENTS[$id];

					if (!isset($PAR['gen']) || (isset($PAR['gen']) && $PAR['gen'] >= $level+1) ) {
						foreach ($CONTENTS as $CONTENT) {
							$CORE['DEBUG']['tree_count'] += 1;

							if ($CONTENT['id'] != substr($CONTENT['pid'], 1, -1)) {//v3.32
								if (in_array($id, explode("|", $CONTENT['pid']))) {
									$TREE_RES = tree($CONTENT['id'], $level, $PAR);
									if ($TREE_RES != "") {
										$TREE['CHILDS'][] = $TREE_RES;
									}
								}
							}
						}
					}
				}
			}
		}

		unset($CONTENTS[$id]);



		set_function("tree", "$id | " . @count($TREE['CHILDS']));
		return $TREE;
	}

	function get_childs($TREE, $root=0) {
		static $TEMP_LIST;

		if ($root == 1) {$TEMP_LIST = array();}

		$CHILD = $TREE;
		unset($CHILD['CHILDS']);

		$TEMP_LIST[$TREE['id']] = $CHILD;

		if (isset($TREE['CHILDS'])) {
			foreach ($TREE['CHILDS'] as $key => $ROW) {
				get_childs($ROW);
			}
		}

		return $TEMP_LIST;
	}

	function tree_to_list($list_name, $TREE, $cat=false) {
		global $LIST;

		$RETURN = get_childs($TREE, 1);

		set_function("tree_to_list", "$id | " . count($RETURN));
		return $RETURN;
	}

	function list_to_tree($LIST_TO_TREE) {
		//global $LIST;

		foreach($LIST_TO_TREE as $ROW) {
			e($ROW);
		}

		set_function("list_to_tree", "$id | ");
		return $RETURN;
	}


	function db_select($table, $PAR="", $data_only=false) { // $id=0, $pid="", $db=1, $index=false
		global $CORE;

		if ($table != "") {
			if (isset($PAR['db'])) {$db = $PAR['db'];} else {$db = 0;}
			if ($PAR['db_prefix'] != '') {$db_prefix = $PAR['db_prefix'];} else {$db_prefix = '';}

			$DB = new db($db);

			if (isset($PAR['id'])) {
				$id = $PAR['id'];

				if (is_numeric($PAR['id'])) {
					if ($id != 0) {$query_where = "WHERE `" . $db_prefix . "id` = '$id'";}
				} else {
					$query_where = "WHERE `" . $db_prefix . "name` = '$id'";
				}
			}

			if (isset($PAR['in'])) {
				$in = $PAR['in'];

				$query_where = "WHERE `" . $db_prefix . "id` IN ($in)";
			}

			if (isset($PAR['pid']) && $PAR['pid'] != "") {
				$pid = $PAR['pid'];

				if ($pid != "root") {
					if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}

					$query_where .= "$where `" . $db_prefix . "pid` LIKE '%|$pid|%'";
				}
			}

			if (isset($PAR['where']) && $PAR['where'] != "") {
				$where_and = $PAR['where'];

				if ($pid != "root") {
					if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}

					$query_where .= "$where $where_and";
				}
			}

			if (isset($PAR['in_groups'])) {
				if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}

				$GROUPS = to_array($PAR['in_groups']);

				foreach($GROUPS as $this_group) {
					$query_where .= " $where (`" . $db_prefix . "groups` LIKE '$this_group' ";
					$query_where .= " OR `" . $db_prefix . "groups` LIKE '$this_group||%' ";
					$query_where .= " OR `" . $db_prefix . "groups` LIKE '%||$this_group||%' ";
					$query_where .= " OR `" . $db_prefix . "groups` LIKE '%||$this_group')";
					$where = "AND";
				}
			}

			if (isset($PAR['in_types'])) {
				if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}

				$GROUPS = to_array($PAR['in_types']);

				foreach($GROUPS as $this_type) {
					$query_where .= " $where (`" . $db_prefix . "type` LIKE '$this_type' ";
					$query_where .= " OR `" . $db_prefix . "type` LIKE '$this_type||%' ";
					$query_where .= " OR `" . $db_prefix . "type` LIKE '%||$this_type||%' ";
					$query_where .= " OR `" . $db_prefix . "type` LIKE '%||$this_type')";
					$where = "AND";
				}
			}

			if (isset($PAR['order'])) {
				if ($PAR['order'] != 'false') {
					if (isset($PAR['order_dir'])) {
						$order_dir = strtoupper($PAR['order_dir']);
					} else {
						$order_dir = "ASC";
					}

					$order 			= $PAR['order'];
					$query_order 	= "ORDER BY `" . $db_prefix . "$order` $order_dir";
				}
			} else {
				$query_order 	= "ORDER BY `" . $db_prefix . "order` ASC";
			}

			if (isset($PAR['group'])) { //v3.25
				$group 			= $PAR['group'];
				$query_group 	= " GROUP BY `" . $db_prefix . "$group`";
			}

			if ($PAR['index'] != "") {$fields = "" . $db_prefix . "id," . $db_prefix . "pid";} else {$fields = "*";}
			if ($PAR['fields'] != "") {$fields = $PAR['fields'];}

			if ($PAR['allowed'] == 1) {
				if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}

				$groups = $CORE['USER']['allowed'];
				$query_groups = " $where `" . $db_prefix . "allowed` IN ($groups)";
			}

			if ($PAR['status'] == 1) {$query_status = " AND `" . $db_prefix . "status` = '1'";}
			if ($PAR['type'] != "") {$type = $PAR['type'];} else {$type = 1;}

			if (isset($PAR['limit'])) {
				$limit = $PAR['limit'];

				if (isset($PAR['start'])) {$start = $PAR['start'];} else {$start = 0;}

				$query_limit = " LIMIT $start,$limit";
			}

			$query_select 	= "SELECT $fields";
			$query_from 	= " FROM `$table`";

			$query = "--  list_db $table
						  $query_select
						  $query_from
						  $query_where
						  $query_group
						  $query_status
						  $query_groups
						  $private_query
						  $query_order
						  $query_limit
					 ";
		//e($query);
			$RESULTS = $DB->select($query, $type);

			if ($type != 3) {
				if (is_array($RESULTS['ROWS'])) {
					$CORE['LIST']['TABLES'][] 	= $table;
					$DATA['INI']['db'] 			= $db;
					$DATA['INI']['CC'][$table] 	= $RESULTS['rows_number'];
					$DATA['INI']['list_total'] 	= array_sum($DATA['INI']['CC']);
					$DATA['INI']['cc_total'] 	= array_sum($DATA['INI']['CC']);
					$DATA['INI']['query'] 		= format_rmspace($RESULTS['query']);
					$DATA['INI']['query_nav'] 	= "SELECT COUNT(*) $query_from $query_where $query_status $query_groups GROUP BY `" . $db_prefix . "id`";

					foreach ($RESULTS['ROWS'] as $id => $ROW) {
						if (!$data_only) {
							$ROW['level']			= 1;
							$ROW['table']			= $table;
						}

						$DATA['DATA'][$id] 		= $ROW;
						$IDS[$table][] 			= $id;
					}

					$DATA['FIELDS'] 			= array_keys($ROW);
					$DATA['IDS']				= $IDS;

					set_function("list_db", "$table | $value | $db | type:$type");
					return $DATA;
				} else {
					set_function("list_db", "$table | $value | $db | EMPTY");
				}
			} else {
				set_function("list_db", "$table | $value | $db | type:$type");
				return $RESULTS;
			}
		} else {
			set_function("list_db", "$table | $value | $db | NO TABLE");
		}
	}

	function data_switch($list, $value) {
		global $LIST;

		if (is_numeric($value)) {
			$result = $LIST[$list]['DATA'][$value]['name'];
		} else {
			$result = list_search($list, "name", $value, "id");
		}

		set_function("data_switch", "$list | $value | $result");
		return $result;
	}

	function list_search($list, $field_look, $value, $field_return) {
		global $LIST;

		$DATA = &$LIST[$list]['DATA'];

		$result = false;

		if(is_array($DATA)) {
			foreach ($DATA as $rid => $ROW) {
				if($ROW[$field_look] == $value) {
					if ($field_return == "root") {
						$result = $rid;
					} else {
						$result = $ROW[$field_return];
					}
				}
			}
		}

		if ($result == "") {
			if ($value != "all") { //v3.16 patch pour enlever le message ALL, fadra trouver autre chose parempe
				if (DEBUG) {set_message("list_search", "ne trouve pas <b>$value</b> sur la liste <b>$list</b>", true);}
			}

			$result = false;
		}

		set_function("list_search", "$list | $field_look | $value | $field_return");
		return $result;
	}

	function content_search($id="", $TYPE="", $allowed=true, $status=true) {
		global $LIST;

		$CONTENTS = $LIST['contents']['DATA'];

		if(is_array($CONTENTS)) {
			foreach ($CONTENTS as $CONTENT) {
				if (is_allowed($CONTENT['allowed']) && $CONTENT['status'] == 1) {
					if($id == "" || ($id != "" && in_array($id, explode("|", $CONTENT['pid'])))) {
						if ($TYPE == "" || ($TYPE != "" && in_array($CONTENT['type'], $TYPE))) {
							$ALL[] = $CONTENT;
						}
					}
				}
			}
		}

		set_function("content_search", "$list | $field_look | $value | $field_return");
		return $ALL;
	}

	function get_parent_row($id) {
		global $LIST;

		$parent_id		= substr($LIST['contents']['DATA'][$id]['pid'], 1, -1);
		$RETURN			= $LIST['contents']['DATA'][$parent_id];
		$RETURN['pid']	= parent_id;

		set_function("get_parent_row", "$id");
		return $RETURN;
	}

	function format_rte($content) {
		// Strip newline characters.
		$content = str_replace(chr(10), " ", $content);
		$content = str_replace(chr(13), " ", $content);
		// Replace single quotes.
		$content = str_replace(chr(145), chr(39), $content);
		$content = str_replace(chr(146), chr(39), $content);
		// Replace single quotes.
		//$content = str_replace('"', "''", $content);

		return $content;
	}

	function contents_add($pid, $name, $PAR) {
		global $CORE;

		$DB = new db();
		$time = time();

		if (!isset($PAR['type'])) {
			$PAR['type'] = 0;
		}

		if (!isset($PAR['label_fr'])) {
			$PAR['label_fr'] = $name;
		}

		if (!isset($PAR['label_en'])) {
			$PAR['label_en'] = $name;
		}
		if (!isset($PAR['allowed'])) {
			$PAR['allowed'] = 1;
		}
		if (!isset($PAR['owner'])) {
			$PAR['owner'] = $CORE['USER']['id'];
		}
		if (!isset($PAR['order'])) {
			$PAR['order'] = 1000;
		}

		if (!isset($PAR['status'])) {
			$PAR['status'] = 1;
		}

		$INSERT = array("pid" =>"|$pid|","name" =>$name,"type" =>$PAR['type'],"par" =>$PAR['par'],"label_fr" =>$PAR['label_fr'],"label_en" =>$PAR['label_en'],"cdate" =>$time,"mdate" =>$time,"order" =>$PAR['order'],"owner" =>$PAR['owner'],"allowed" =>$PAR['allowed'],"status" =>$PAR['status'],"class" =>$PAR['class']);

		$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
		$val_item = "'" . implode("','", array_map('addslashes', array_values($INSERT))) . "'";

		$query = "INSERT INTO `contents` ( $val_column ) VALUES ( $val_item);";
		//echo $query."<br>";
		$DB->query($query);
		$id = mysql_insert_id();

		set_function("contents_add", "$pid - $name");
		return $id;
	}

	function contents_new($name="", $PAR, $table="contents") {
		global $CORE;

		$DB = new db();
		$time = time();

		$query = "--  contents_copy
					  SELECT *
					  FROM `$table`

					  LIMIT 0,1
				 ";

		$RESULTS = $DB->select($query,3);



		if (is_array($RESULTS)) {
			$ORI = $RESULTS;

			foreach ($ORI as $field => $value) {
				$NEW[$field] = "";
			}

			unset($NEW['id']);

			if (isset($PAR['pid'])) {$NEW['pid'] = "|" . $PAR['pid'] . "|";} else {$NEW['pid'] = $ORI['pid'];}

			$NEW['name']     	= "new";
			$NEW['cdate'] 		= $time;
			$NEW['mdate'] 		= $time;

			$NEW['status'] 		= "1";
			$NEW['allowed'] 	= "1";
			$NEW['owner'] 		= $CORE['USER']['id'];
			$NEW['order'] 		= "1000";

			foreach ($PAR['FIELDS'] as $field => $value) {
				$NEW[$field] 	= $value;
			}

			$val_column 		= "`" . implode("`,`", array_keys($NEW)) . "`";
			$val_item 			= "'" . implode("','", array_map('addslashes', array_values($NEW))) . "'";

			$query = "INSERT INTO `$table` ( $val_column ) VALUES ( $val_item);";


			$DB->query($query);
			$id = mysql_insert_id();
		}

		return $id;
	}

	function contents_duplicate($id, $name="", $PAR="", $table="contents") {
		global $CORE;
		global $LIST;

		if ($PAR['db'] == "") {
			$db_from = 0;
			$db_to = 0;
		} else {
			$db_from = $PAR['db'];
			$db_to = $PAR['db'];
		}

	/// OVERIDES DEFAUKT IF FROM AND/OR TO DIFFERENT SITES
		if ($PAR['db_from'] != "") {$db_from = $PAR['db_from'];}
		if ($PAR['db_to'] != "") {$db_to = $PAR['db_to'];}

		//e("$db_from -> $db_to");

		$DB_FROM 	= new db($db_from);
		$DB_TO 		= new db($db_to);

		$time = time();

		$query = "--  contents_copy
					  SELECT *
					  FROM `$table`
					  WHERE `id` = '$id'
				 ";

		$RESULTS = $DB_FROM->select($query);

		if ($PAR['new'] == "true") {}

		if (is_array($RESULTS['ROWS'][$id])) {
			$COPY = $RESULTS['ROWS'][$id];
			unset($COPY['id']);

			if (isset($PAR['underscore'])) {$underscore = "_";}

			if (isset($COPY['name'])) 	  {$COPY['name']     = $underscore . $COPY['name'];}
			if (isset($COPY['label_fr'])) {$COPY['label_fr'] = $underscore . $COPY['label_fr'];}
			if (isset($COPY['label_en'])) {$COPY['label_en'] = $underscore . $COPY['label_en'];}

			$COPY['cdate'] = $time;
			$COPY['mdate'] = $time;

			$val_column 		= "`" . implode("`,`", array_keys($COPY)) . "`";
			$val_item 			= "'" . implode("','", array_map('addslashes', array_values($COPY))) . "'";

			$query = "INSERT INTO `$table` ( $val_column ) VALUES ( $val_item );";

			$DB_TO->query($query);
			$id = mysql_insert_id();
		}

		return $id;
	}

	function contents_tree_duplicate ($id, $pid="", $from="", $to="") {
		global $LIST;

		if ($from != "") {$db_from = $from;} else {$db_from = 0;}
		if ($to != "") {$db_to = $to;}	else {$db_to = 0;}

		$CONTENTS 	= &$LIST['contents']['DATA'];
		$root_pid 	= $pid;
		$DB			= new db($db_to);
		$TREE_RES 	= tree($id, 0, array('db' => $db_from));
		$TREE_LIST 	= tree_to_list("tree_duplicate", $TREE_RES);

		foreach ($TREE_LIST as $CONTENT) {
			if ($CONTENT['id'] == $id) {$underscore = 1;} else {unset($underscore);}

			$new_id = contents_duplicate($CONTENT['id'],"",array('underscore' => $underscore, 'db_from' => $db_from, 'db_to' => $db_to));

			$NEW_IDS[$CONTENT['id']] = $new_id;
			$OLD_IDS = array_flip($NEW_IDS);

			if ($root_pid != "") {
				$query = "UPDATE `contents` SET `pid` = '|$pid|' WHERE `id` = $new_id";
				$DB->query($query);
				$root_pid = "";
			}

			$PIDS = explode("|", $CONTENT['pid']);

			foreach ($PIDS as $this_pid) {
				if (in_array($this_pid, $OLD_IDS)) {
					$new_pid = str_replace("|" . $this_pid . "|",  "|" . $NEW_IDS[$this_pid] . "|", $CONTENT['pid']);
					$query = "UPDATE `contents` SET `pid` = '$new_pid' WHERE `id` = $new_id";
					$DB->query($query);
				}
			}
		}
	}

	function contents_delete($id, $table="contents", $PAR="") {
		global $CORE;

		if ($PAR['db'] == "") {
			$db = 0;
		} else {
			$db = $PAR['db'];
		}

		$DB = new db($db);

		if ($table == "files") {
			$LIST_TEMP		= db_select("files", array('id' => $id));
			$file_cname 	= $LIST_TEMP['DATA'][$id]['name'];
			$file_name		= substr($file_cname,0,-4);
			$file_ext		= substr($file_cname,-4);

			if (file_exists(SITE_FILES_PATH . $file_name . "" . $file_ext)) {unlink(SITE_FILES_PATH . $file_name . "" . $file_ext);}
			if (file_exists(SITE_FILES_PATH . $file_name . "_t" . $file_ext)) {unlink(SITE_FILES_PATH . $file_name . "_t" . $file_ext);}
			if (file_exists(SITE_FILES_PATH . $file_name . "_s" . $file_ext)) {unlink(SITE_FILES_PATH . $file_name . "_s" . $file_ext);}
			if (file_exists(SITE_FILES_PATH . $file_name . "_m" . $file_ext)) {unlink(SITE_FILES_PATH . $file_name . "_m" . $file_ext);}
		}

		$query = "DELETE FROM `$table` WHERE `id` ='$id';";
		//echo $query."<br>";
		$DB->query($query);
		$id = mysql_insert_id();

		return $id;
	}

	function list_from_dir($files_path) {
		global $CORE;
		global $LIST;

		$dir = "/tmp";

		$files_res  = opendir($files_path);

		while (false !== ($file_name = readdir($files_res))) {
		   $FILES_LIST[] = $file_name;
		}

		sort($FILES_LIST);

		return $FILES_LIST;
	}

	function field_add(&$ITEMS_LIST, $FIELDS) {
		global $CORE;
		global $LIST;

		$FIELDS = to_array($FIELDS);
		foreach ($ITEMS_LIST as $key => $ITEM) {
			foreach ($FIELDS as $field) {
				$ITEMS_LIST[$key][$field] = "";
			}
		}

		reset($ITEMS_LIST);

		return $ITEMS_LIST;
	}

	function list_data($list_name) {
		global $LIST;

		$data = $LIST[$list_name]['DATA'];

		if (!isset($data)) {$RETURN == false;}

		$RETURN = &$LIST[$list_name]['DATA'];

		return $RETURN;
	}

?>