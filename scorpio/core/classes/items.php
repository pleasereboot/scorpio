<?php 

	/* SCORPIO engine - class_items.php - v3.29			*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2009-01-09	 						*/	
	/* YYY						163/220					*/

	class items {
		var $CORE;
 		var $DB;
		var $TABLES;
		var $LIST;
		var $TEMPLATES;
		var $SCORPIO;
		
		var $listname;	//holds list name
		var $PAR; 		//holds content par that will update seed after seed load but before listen to allow by content settings
		var $SEED; 		//holds seed from db
		var $SEED_ORI; 	//holds untouched seed from db		
		
		var $QUERY_INI;	//holds the query ini infos		
//		var $QUERY;		//holds the query itself as an array for easy update
//		var $PARENT_INI;//holds the parent ini infos
//		var $PARENT; 	//holds the parent item
		var $RESULTS; 	//holds data from results
		var $DATA; 		//holds data from results
//		var $RS; 		//holds active rs
		var $LISTEN; 	//holds the listen() results			
		var $html; 		//holds parse results
	
//		var $TREE; 		//holds tree
//		var $TREE_TEMP; //holds tree temp
//		var $TREE_LIST; //holds tree list		
		
		function items($PAR="") {
			$this->CORE 		= &$GLOBALS['CORE'];
			$this->LIST 		= &$GLOBALS['LIST'];
			$this->SCORPIO 		= &$GLOBALS['SCORPIO'];
			$this->TEMPLATES 	= &$GLOBALS['TEMPLATES'];
			$this->TABLES		= $this->CORE['TABLES'];
			$this->PAR			= $PAR;
			$this->listname		= $PAR['list'];
			
		/// PREPEND
			$this->prepend();
			
		}
	
		function prepend() {
			$this->seed_load();
			$this->par_load();
			$this->listen();
			$this->data_load();
		}	
	
		function seed_load($seed = '') {
			if ($seed == '') {$seed = $this->listname;}
			
			$INI = array('id' => $seed, 'type' => 3);
			
			$this->SEED = db_select('sys_seeds', $INI, true);
			$this->SEED_ORI = $this->SEED;
			
			return $this->SEED;
		}
	
		function par_load($seed = '') {
			$this->SEED = array_merge($this->SEED, $this->PAR);
			
			return $this->PAR;
		}
	
		function listen() {
			foreach ($_GET as $key => $id) {
				list($listname, $action) = explode('_', $key);
				
				if ($listname == $this->listname) {
					switch ($action) {
					/// ACTIONS	
						case 'edit':
							$this->LISTEN['item_id'] = $id;
							//$this->LISTEN['mode'] = 'edit'; 
							e('edit');
						break;						
						case 'copy':
							e('copy');
						break;	
						case 'del':
							e('del');
						break;						
						case 'add':
							e('add');
						break;						
						
					/// LIST						
						
						case 'id':
							$this->LISTEN['item_id'] = $id;  
						break;
						
					}
						 
				}
			}
			

			//if (isset($_GET[$this->listname . '_id'])) 		{$this->LISTEN['item_id']		= $_GET[$this->listname . '_id'];}
			if (isset($_GET[$this->listname . '_start'])) 	{$this->LISTEN['start'] 		= $_GET[$this->listname . '_start'];}
			if (isset($_GET[$this->listname . '_limit'])) 	{$this->LISTEN['limit'] 		= $_GET[$this->listname . '_limit'];}
			if (isset($_GET[$this->listname . '_expand'])) 	{$this->LISTEN['expand']		= $_GET[$this->listname . '_expand'];}
			if (isset($_GET[$this->listname . '_mode'])) 	{$this->LISTEN['mode']			= $_GET[$this->listname . '_mode'];}
			if (isset($_GET[$this->listname . '_order'])) 	{$this->LISTEN['query_order']	= $_GET[$this->listname . '_order'];}
			if (isset($_GET[$this->listname . '_dir'])) 	{$this->LISTEN['order_dir']		= $_GET[$this->listname . '_dir'];}
			
			if ($this->SEED['parent_list'] != "") {
				if (isset($_GET[$this->SEED['parent_list'] . '_id'])) {
					$this->LISTEN['root'] = $_GET[$this->SEED['parent_list'] . '_id'];
				}
			}			
			
			$this->SEED = array_merge($this->SEED, $this->LISTEN);
		}	
	
		function data_load() {
			$SEED = &$this->SEED;
			
	//e($SEED['parent_list']);		
		///	INI		
//			$list_order_dir	= $PAR['order_dir'];
//			$list_page		= $PAR['page'];
//			$list_new 		= $PAR['new'];
//			$list_allowed	= $PAR['allowed'];
//			$list_status	= $PAR['status'];
//			$list_gen		= $PAR['gen'];
//			$list_where		= $PAR['where'];
//			$list_altern	= $PAR['altern'];
//			$list_sys_form	= $PAR['sys_form'];
//			$list_ci_name	= $PAR['ci_name'];
//			$list_select	= $PAR['select'];
//			$list_group		= $PAR['group'];	
				
				
			if ($SEED['root'] != "") {if (!is_numeric($SEED['root'])) {$SEED['root'] = data_switch("contents", $SEED['root']);}}
	
			$INI['edit_return']	= $PAR['edit_return'];
	
		/// CATS LIST		
//			$CAT_PAR					= array("gen" => $list_cat_expand, "allowed" => $list_allowed, "status" => $list_status,);
//			$CAT_TREE					= tree($list_cat_id, "", $CAT_PAR);
//			$ALIST['CATS']				= tree_to_list($list_name, $CAT_TREE);	
			
		/// PREPARE QUERY INI
			$this->QUERY_INI = $this->SEED;
			$this->QUERY_INI['order'] = $this->SEED['query_order']; //changer un ou lautre 
		
			switch ($this->SEED['mode']) {
				case 'list';
					if ($this->SEED['show_all'] == 1) {
						unset($this->QUERY_INI['pid']);
					} else {
						$this->QUERY_INI['pid'] = $this->SEED['root'];   // to conform with old db_select
					}
					
					unset($this->QUERY_INI['item_id']);
					unset($this->QUERY_INI['id']);
				break;
				case 'zoom';
					$this->QUERY_INI['id'] = $this->SEED['item_id'];   // to conform with old db_select
					unset($this->QUERY_INI['pid']);
				break;				
				
			}

		/// RUN
			$this->RESULTS = db_select($this->SEED['table'], $this->QUERY_INI);
			
			$this->DATA = &$this->RESULTS['DATA'];

			$this->LIST[$this->listname] = &$this->RESULTS;
		}	
	
		function parse() {
		/// INI	
			$ALIST 			= $this->LIST[$this->listname];
			$INI			= &$ALIST['INI'];	
			$TYPES			= $this->LIST['types']['DATA'];
			//$ITEMS_LIST 	= $ALIST[strtoupper($PAR['type'])];
			$ITEMS_LIST 	= $ALIST['DATA'];
			$lang 			= $this->LIST['lang']['DATA'][$this->CORE['SESSION']['lang']]; // lang update
	
			//$parent			= $PAR['list'];
			$parse_count 	= 0; 
			$t_mode			= strtoupper($this->SEED['mode']);
	
			if (!isset($PAR['parse_start'])) {$PAR['parse_start'] = 0;}    //v3.25
			if (!isset($PAR['parse_limit'])) {$PAR['parse_limit'] = 1000;} //v3.25
			
			/// ROW STRUCTURE
				$rs_name = $this->QUERY_INI['co_' . $this->QUERY_INI['mode']] . '_' . $this->QUERY_INI['mode'];
				$rs_id = data_switch("contents", $rs_name);
			
				if (isset($ITEMS_LIST)) {
				/// TEMPLATE
					if ($this->SEED['mode'] == "edit") {
						$t_file_html	= t_load_file("form_items_new", "form_items_new", true);
						$t_list_html	= t_set_block("form_items_new", "SYSTEM_EDIT");			
					} else {
						//if (!isset($PAR['template'])) {$PAR['template'] = "defaultlist";}
						if ($this->SEED['t_sys']) {$sys = true;} else {$sys = false;}
						if ($this->SEED['t_mod']) {$content_path = 'mod_' . $this->SEED['t_mod'] . "/themes/default/templates/";}
						//if ($list_mode == 'edit' && $PAR['type'] == 'cats') {$t_mode = 'LIST';} else {$t_mode = strtoupper($list_mode);}
						
						$t_name = $this->SEED['t_' . $this->SEED['mode']];

						$t_file_html	= t_load_file($t_name, $t_name, $sys, $content_path);
						$t_block_html	= t_set_block($t_name, strtoupper($this->SEED['t_type']) . "_" . $t_mode . "_ROW");
						
//						if ($INI['altern'] == "true") {
//							$t_block2_html	= t_set_block($t_name, strtoupper($this->SEED['t_type']) . "_" . $t_mode . "_ROW2");
//						}
						
						//if (isset($this->SEED['more'])) {$t_more_html	= t_set_block($t_name, "ITEMS_MORE");}
						
						$t_list_html	= t_set_block($t_name, strtoupper($this->SEED['t_type']) . "_" . $t_mode);
					}
		
					if ($rs_id) {
						$RS_RES = tree($rs_id, 0, array('status'=>1, 'allowed'=>true));
						$RS = $RS_RES['CHILDS'];	
					} else {	
						set_message("load rs", "row structure <b>$rs_name</b> dans <b>$list_name</b> est inexistant", 1);		
					}

				/// LOOP THEM ALL  ////// POURRAIT PAS PASSER PAR CONTENT ????
					$row2 = 1;
					
					//$DB = new db($INI['db']);
					
					//$META = $DB->metadata($INI['table']);
		
//					foreach ($META as $this_field) {  // added v3.22
//						$FIELDS[] = $this_field['name'];
//					}
//					
//					$FIELDS_KEYS = array_flip($FIELDS);  // added v3.22
					
					foreach($ITEMS_LIST as $ITEM) {				
//						if ($parse_count >= $PAR['parse_start'] && $parse_count < ($PAR['parse_start'] + $PAR['parse_limit'])) {  //v3.25
							$HTML = $ITEM;
							$ITEM['list_name'] = $this->listname;
							$ITEM_PAR = explode_par($ITEM['par']);
//				
//							if (($ITEM_PAR['hidden'] == "" && $INI['type'] != "cats") || is_allowed($ITEM_PAR['hidden'])) {
								if (isset($RS)) {
									foreach($RS as $key=>$RS_FIELD) {
										$field_name 		= $RS_FIELD['name'];
										$field_name_func 	= $RS_FIELD['name'];
										$FIELD_PAR			= explode_par($RS_FIELD['par']);
//										$FIELDSADD_RS[$RS_FIELD['name']] = $RS_FIELD['id'];
//										unset($FIELDS_KEYS[$field_name]);  // added v3.22

//									///	LANGUAGE SELECTION	
										if (isset($ITEM[$RS_FIELD['name'] . "_" . $lang])) {
											$HTML[$RS_FIELD['name']] = $ITEM[$RS_FIELD['name'] . "_" . $lang];
											$field_name_func = $RS_FIELD['name'] . "_" . $lang;
										}	
//									
										foreach ($RS_FIELD['CHILDS'] as $TYPE) {
											$type_name	= str_replace('type_', 'co_', $TYPES[$TYPE['type']]['function']); // to comply with new_checkout
							//e($type_name);				
											
											$par 		= $TYPE['par'];
											$RS_PAR		= explode_par($par);
//											$ADMIN_TYPES[$TYPE['id']] = $TYPE;
//											$PROUT[$RS_FIELD['name']][$TYPE['id']] = $TYPE['name']; // 3.23 for admin structs
//											
											if (isset($RS_PAR['function'])) {$type_name = $RS_PAR['function'];} //v3.20 custom types
//				
											if (function_exists($type_name)) { 
												$TYPE_INI = array('PAR' => explode_par($par), 'PAR_FIELD' => $FIELD_PAR, 'af' => $field_name, 'av' => $ITEM[$field_name], 'uv' => &$HTML[$field_name], 'AR' => $ITEM, 'UR' => &$HTML, 'SEED' => &$this->SEED, 'CO' => $TYPE, 'listname' => $this->listname, 'field_name_func' => $field_name_func,);
										//e($TYPE_INI);	
												$HTML[$field_name] = @call_user_func($type_name, $TYPE_INI) . "\n"; //$ITEM, &$HTML, $par, $field_name_func, $TYPE
											} else {
												if (trim($type_name) != '') { //v3.25 gossait pas mal
													set_message("function_$type_name", "la function $type_name n'existe pas - content name : $field_name", 1);
												}
											}					
										}
//									
//										$class_name		= $RS_FIELD['class'];
//				
//									/// CAPTION CODE // peut servir pour debuger les contents
////										$caption 		= $FIELD_PAR['caption'];
////									
////										if ($caption != "" && is_allowed($caption)) {  //exploder a keke part dautre
////											$caption_text = $RS_FIELD[lang("label")];
////											$HTML[$field_name] = "$caption_text" . $HTML[$field_name];
////										}							
////										
////										if ($class_name != "") {
////											$class = strtoupper($class_name);
////											$HTML[$field_name] = "\n<div class=\"$class\">" . $HTML[$field_name] . "</div>";
////										}
									}
								}

//								if ($list_mode == "edit") {
//									foreach ($FIELDSADD_RS as $used_key  => $value) {
//										$block_html .= $HTML[$used_key];
//									}
//									
//									reset($FIELDSADD_RS);
//								} else {					
//									if ($INI['altern'] == "true" && $row2 == -1) {
//										$row2 *= -1;
//										$block_html .= set_var($t_block2_html, $HTML);
//									} else {
//										$row2 *= -1;
										$block_html .= set_var($t_block_html, $HTML);
//									}
//								}
//							}
//						}
						
						$parse_count++;			
					}
					
					reset($ITEMS_LIST);
			
				/// ADD FORM IF ALLOWED
//					if (is_allowed(5) && $block_html != "" && ($PAR['form'] != "0" || $list_mode == "edit")) { // 
//						if ($INI['edit_return'] == 1) {
//							$NEW_QS = $CORE['QS'];
//							array_pop($NEW_QS);
//							$form_start = BR . url('Voir les détails du document', qs_load($NEW_QS)) . BR;
//							//e($page_url);
//						}			
//					
//						$form_start .= "<form action=\"$page\" method=\"post\" name=\"form_$list_name\" onsubmit=\"return submitForm();\">"
//									 . "	<input name=\"$list_name" . "_type\" type=\"hidden\" value=\"" . $PAR['type'] . "\">";
//						$form_end	.= "	<center><input name=\"$list_name" . "_update\" type=\"submit\" id=\"submit_$list_name\" value=\"METTRE A JOUR\"></center>"
//									//. "	<input name=\"reset_$list_name\" type=\"reset\" id=\"reset_$list_name\" value=\"RESET\"></center>"  
//									 . "</form>";
//									
//		
//					
//						$t_list_html 	= set_var($t_list_html, "FORM_BEGIN", $form_start);
//						$t_list_html 	= set_var($t_list_html, "FORM_END", $form_end);
//					}
					
				/// ADD MORE
//					if (isset($PAR['more']) && $list_mode != "edit") { 
//						$more_label 	= lang_arr($PAR['more']);
//						$more_page 		= $PAR['more_page'];
//						
//						$more_url		= "<a href=\"?p=$more_page\">$more_label</a>";
//					
//						$t_more_html 	= set_var($t_more_html, "MORE_URL", $more_url);
//						$t_list_html 	= set_var($t_list_html, "ITEMS_MORE", $t_more_html);
//					}		
//							
//					if ($list_mode == "edit") {
//						$return = set_var($t_list_html, "FORM_CONTENT", $block_html);	
//					} else {
						$return = set_var($t_list_html, strtoupper($this->SEED['t_type']) . "_" . $t_mode . "_ROW", $block_html);			
//					}						
				} else {
//					if ($PAR['no_item_show'] != "false") { // me semble que ca la pas rap
//						$return = "<div style=\"clear:both;\">" . lang_arr(array("Aucun item trouvé", "No items found"))  . "</div>";
//					}
				}
		
			/// ADD ITEM OR CAT
//				if (is_allowed(5) && $PAR['add'] != "false") {
//					if (isset($INI['new'])) {$new_list = $INI['new'];} else {$new_list = $list_name;}
//						if ($PAR['type'] == "items") {		
//							$return = "<br /><a href=\"?p=" . $INI['page'] . "&" . $new_list . "_" . $INI['table'] . "_new=true&new_cat_id=" . $INI['cat_id'] . "\"><font style=\"font-size:smaller;\">AJOUTER UN ITEM</font></a><br /><br />" . $return;
//						} else if ($PAR['edit_cats'] != "false") {
//							$return = "<br /><a href=\"?p=admin_cats&catslist_cat_id=" . $INI['root'] . "\"><font style=\"font-size:smaller;\">MODIFIER-AJOUTER UNE CATÉGORIE</font></a><br /><br />" . $return;
//						}
//					}
		
			/// ADD STRUCT
//				if (isset($CORE['GET']["rs_add"]) && is_allowed(6)) {
//					unset($CORE['QS']["rs_add"]);
//		
//					$page 			= qs_load();
//					$pid 			= 36;
//					$field_name 	= $CORE['GET']["rs_add"];
//		
//					$FIELD_PAR 		= array();
//		
//					$new_id = contents_add($pid, $field_name, $FIELD_PAR);
//					
//					$SCORPIO->clear_cache(1);
//					$SCORPIO->last_updated();
//		
//					header("Location:$page");				
//				}		
//		
//				if (isset($CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id"]) && is_allowed(6)) {
//					unset($CORE['QS'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id"]);
//					unset($CORE['QS'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name"]);
//		
//					$page 			= qs_load();
//					$pid 			= $CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id"];
//					$parent_name 	= $LIST['contents']['DATA'][$pid]['name'];
//					$field_name 	= $CORE['GET'][$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name"];
//		
//					$FIELD_PAR 		= array();
//					$SUBFIELD_PAR	= array('type' => 74, 'allowed' => 5);
//					
//					$new_id = contents_add($pid, $field_name, $FIELD_PAR);
//					contents_add($new_id, $field_name . "_input", $SUBFIELD_PAR);
//					
//					$SCORPIO->clear_cache(1);
//					$SCORPIO->last_updated();
//		
//					header("Location:$page");				
//				}	
//				
//				if (isset($CORE['POST']["fields_update"])) {
//					$UPDATE = $CORE['POST'];
//					$DB_FIELDS = new db();
//		
//					array_pop($UPDATE);
//		
//					foreach($UPDATE as $field => $field_value) {
//						list($field_name, $field_id) = explode("-", $field);
//						
//						if ($field_name == "status" && $field_value == 2) {
//							contents_delete($field_id,$query_table);
//						} else {	
//							$field_value = addslashes($field_value);				
//							$query = "UPDATE `contents` SET `$field_name` = '$field_value' WHERE `id` = '$field_id';"; 
//							$DB_FIELDS->query($query);
//						}	
//					}				
//					
//					$page = qs_load();			
//					header("Location:$page");
//				}
//					
//				if (is_allowed(6)  && $PAR['struct'] != "false") {
//					$FIELDS_UNUSED = array_flip($FIELDS_KEYS);
//					$page 			= qs_load();
//		
//					$FIELDS_ADD[] = "<div class=\"MENU_GOD_SWITCH\">";
//					$FIELDS_ADD[] = "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"fields_update\" id=\"fields_update\">";
//					$FIELDS_ADD[] = "<table border=\"0\">";
//					$FIELDS_ADD[] = "<tr><td colspan=\"7\">";
//					
//					if ($rs_id == "") {
//						$FIELDS_ADD[] =	"add <a href=\"$page&rs_add=$rs_name\"><font style=\"font-size:smaller;\">$rs_name</font></a>";
//						$FIELDS_ADD[] = "</td></tr>";
//						$FIELDS_ADD[] = "</table>";	
//						$FIELDS_ADD[] = "</form>";
//						$FIELDS_ADD[] = "</div>";
//					} else {
//						$FIELDS_ADD[] = "edit <a href=\"?p=admin_structs&structslist_cat_id=$rs_id\" target=\"_blank\"><font style=\"font-size:smaller;\">$rs_name</font></a>"; 		
//						$FIELDS_ADD[] = "</td></tr>";
//		
//					/// IN DB LIST
//						foreach ($FIELDS as $to_soude) {
//							$FIELDS_ADD[] = "<tr>";
//							
//							if (isset($CORE['GET'][$list_name . "_" . $INI['table'] . "_edit"])) {$edit_url = "&" . $list_name . "_" . $INI['table'] . "_edit=" . $CORE['GET'][$list_name . "_" . $INI['table'] . "_edit"];}
//			
//							if (in_array($to_soude,$FIELDS_UNUSED)) {
//								$FIELDS_ADD[] = "<td><a href=\"$page&" . $list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id=" . $rs_id . "&" . $list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name=" . $to_soude . $edit_url . "\"> + </a></td><td colspan=\"6\"><b>" . $to_soude . "</b> (in db)</td>";
//							} else {
//								foreach ($PROUT[$to_soude] as $prout_key => $prout_value) {
//									$struct_rows .= 
//									"<tr>"
//									. "<td><a href=\"$page&" . $list_name . "_contents_del=" . $ADMIN_TYPES[$prout_key]['id'] . $edit_url . "\"> X </a></td>"
//									. "<td><input name=\"label_fr-" . $prout_key . "\" id=\"label_fr-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['label_fr'] . "\" size=\"10\"/></td>"
//									. "<td>" . select_build($TYPES, "selector_types", 'id', 'name', "type-" . $prout_key, $ADMIN_TYPES[$prout_key]['type'], true) . "</td>"
//									. "<td><input name=\"par-" . $prout_key . "\" id=\"par-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['par'] . "\" size=\"12\"/></td>"
//									. "<td><input name=\"order-" . $prout_key . "\" id=\"order-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['order'] . "\" size=\"3\"/></td>"
//									. "<td><input name=\"allowed-" . $prout_key . "\" id=\"allowed-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['allowed'] . "\" size=\"1\"/></td>"									
//									. "<td><input name=\"status-" . $prout_key . "\" id=\"status-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['status'] . "\" size=\"1\"/></td>"
//									. "</tr>";
//								}						
//											
//								$FIELDS_ADD[] =   "<td valign=\"top\"><a href=\"$page&" . $list_name . "_contents_del=" . $FIELDSADD_RS[$to_soude] . $edit_url . "\"> X </a></td>" 
//												. "<td valign=\"top\"><a href=\"?p=admin_structs&structslist_cat_id=" . $FIELDSADD_RS[$to_soude] . "\" target=\"_blank\"> $to_soude</a> (in db)</td>"
//												. "<td><table>$struct_rows</table></td>";
//												
//								$struct_rows = '';	
//							}
//						}
//						
//						$FIELDS_ADD[] = "</tr>";
//						$FIELDS_ADD[] = "<tr><td colspan=\"3\">---------</td></tr>";
//			
//					/// ADMIN IN RS LIST			
//						foreach ($FIELDSADD_RS as $field_key  => $field_value) {
//							$FIELDS_ADD[] = "<tr>";
//						
//							if (!in_array($field_key,$FIELDS)) {
//								foreach ($PROUT[$field_key] as $prout_key => $prout_value) {
//									$struct_rows .= 
//									"<tr>"
//									. "<td><a href=\"$page&" . $list_name . "_contents_del=" . $ADMIN_TYPES[$prout_key]['id'] . $edit_url . "\"> X </a></td>"
//									. "<td><input name=\"label_fr-" . $prout_key . "\" id=\"label_fr-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['label_fr'] . "\" size=\"10\"/></td>"
//									. "<td>" . select_build($TYPES, "selector_types", 'id', 'name', "type-" . $prout_key, $ADMIN_TYPES[$prout_key]['type'], true) . "</td>"
//									. "<td><input name=\"par-" . $prout_key . "\" id=\"par-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['par'] . "\" size=\"12\"/></td>"
//									. "<td><input name=\"order-" . $prout_key . "\" id=\"order-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['order'] . "\" size=\"3\"/></td>"
//									. "<td><input name=\"allowed-" . $prout_key . "\" id=\"allowed-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['allowed'] . "\" size=\"1\"/></td>"									
//									. "<td><input name=\"status-" . $prout_key . "\" id=\"status-" . $prout_key . "\" type=\"text\" value=\"" . $ADMIN_TYPES[$prout_key]['status'] . "\" size=\"1\"/></td>"
//									. "</tr>";
//								}						
//											
//								$FIELDS_ADD[] =   "<td valign=\"top\"><a href=\"$page&" . $list_name . "_contents_del=" . $FIELDSADD_RS[$field_key] . $edit_url . "\"> X </a></td>" 
//												. "<td valign=\"top\"><a href=\"?p=admin_structs&structslist_cat_id=" . $FIELDSADD_RS[$field_key] . "\" target=\"_blank\"> $field_key</a> (in db)</td>"
//												. "<td><table>$struct_rows</table></td>";
//												
//								$struct_rows = '';	
//								$FIELDS[] = $field_key;
//							}	
//						}
//						
//						$FIELDS_ADD[] = "</tr>";
//						$FIELDS_ADD[] = "<tr><td colspan=\"3\">---------</td></tr>"; 
//			
//					/// ADMIN NOT IN RS LIST			
//						$ADMIN_ARR = array("admin","img","img_sel","html","label","desc","custom1","custom2","custom3","custom4","custom5","custom6");
//			
//						foreach ($ADMIN_ARR as $admin_struct) {
//							if (!in_array($admin_struct,$FIELDS)) {
//								$FIELDS_ADD[] = "<tr>";
//								$FIELDS_ADD[] = "<td><a href=\"$page&" .$list_name . '_' . $PAR['type'] . $list_mode . "_newfield_id=" . $rs_id . "&" . $list_name . '_' . $PAR['type'] . $list_mode . "_newfield_name=" . $admin_struct . $edit_url . "\"> + </a></td><td colspan=\"6\"><b>" . $admin_struct . "</b></td>";
//								$FIELDS[] = $admin_struct;
//								$FIELDS_ADD[] = "</tr>";
//							}		
//						}
//			
//						$FIELDS_ADD[] = "<tr><td colspan=\"7\"><input name=\"fields_update\" type=\"submit\" id=\"fields_update\" value=\"GO\"></td></tr>";			
//						$FIELDS_ADD[] = "</table>";	
//						$FIELDS_ADD[] = "</form>";
//						$FIELDS_ADD[] = "</div>";
//					}
//								
//					$fields_add .= implode("", $FIELDS_ADD); 
//					$return = $fields_add . $return;	
//				}
			//}
			
			$this->html = $return;
			
			return $return;	
		}	
			
	}

?>