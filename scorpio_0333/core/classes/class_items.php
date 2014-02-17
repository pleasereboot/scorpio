<?php

	/* SCORPIO - class_scorpio.php - v4.0		*/	
	/* created on 2009-03-23	 				*/
	/* updated on 2009-03-23	 				*/	
	/* YYY							29/0		*/

	
	class items {
		var $CORE;
		var $DB;
		var $DATA;
		var $HTML;

		var $SEED;
		var $LISTEN;
		var $INI;  		//INI after seeds and listen	
			
		var $ress_id;
		var $html;
	
	
	
		function items($id='') {
			$this->DB = new db();
			$this->CORE = &$GLOBALS['CORE'];
			
			if ($id != '') {
				$this->seed_load($id);
				// par
				// listen
				//$this->query_set($this->SEED);
			}

		}	
	

		function parse() {
			$rs_type = 'co_';
			
			if (count($this->DATA)) {
				$RS['ch_name'] = array('text_deco' => array( 'type' => 25, 'par' => 'style::bold' ));
			
			
			
				foreach($this->DATA as $AR) {
					$UR = array();
					
					if (count($RS)) {
						foreach($RS as $field_name => $RS_FIELD) {
							//e($field_name);
							//e($RS_FIELD);
							
							foreach($RS_FIELD as $type_name => $TYPE) {
								//e($TYPE['type']);
								$TYPE_PAR = $this->par_explode($TYPE['par']);

								echo $field_name_func = $rs_type . $type_name;

								if (function_exists($field_name_func)) {
									$TYPE_INI = array('af' => $field_name, 'av' => $AR[$field_name], 'uv' => &$UR[$field_name], 'AR' => $AR, 'UR' => &$UR,'PAR' => $PAR);
						e($TYPE_INI);
									@call_user_func($type_name, $TYPE_INI, &$HTML, $par, $field_name_func, $TYPE) . "\n";
								} else {
									if (trim($type_name) != '') { //v3.25 gossait pas mal
										set_message("function_$type_name", "la function $field_name_func n'existe pas - content name : $field_name", 1);
									}
								}
																
							}
							
						}
					
					}
				
				}
			
			
			}
			
			
		}

	
		function seed_load($id) {
			$I = new items();
			
			$query = 'SELECT * FROM scorpio_seeds WHERE seed_id = ' . $id;
					
			$I->quickdata($query);
			
			$this->SEED	= $I->DATA[0];
			$this->INI 		= $I->DATA[0];
			
			
		}
	
		// function query_set($QUERY) {
			// e($QUERY);
			
			// if(isset($QUERY['select'])) {
				// $query_select = 'SELECT ' . implode(', ', $QUERY['select']);
				
			// } else {
				// $query_select = 'SELECT * ';
				
			// }
			

				
			// $query_from = 'FROM ' . $QUERY['table'];
			
			
			// $query = "--  list_db $table
						  // $query_select					  
						  // $query_from
						  // $query_where
						  // $query_group
						  // $query_status
						  // $query_groups
						  // $private_query
						  // $query_order
						  // $query_limit ";				
			
			// e($query);
		// }
	
		
		function query($query) {
			$this->clear();
			$this->ress_id = $this->DB->query($query);
			
			$this->CORE['QUERIES'][] = $query;
			
			return $this->ress_id;
		}
		
		function data() {
			while($this->DB->next_record(MYSQL_ASSOC)) {
				$this->DATA[] = $this->DB->Record;						
			}	
								
			//$SELECT = stripslashes_deep($this->RESULTS);					
			return $this->DATA;	
		}
			
		function datatotable($header=true) {
			$PAR['headers'] = $header;
			
			$this->html = arraytotable($this->DATA, $PAR);
			
			return $this->html;
		}

		function quickdata($query) {
			$this->clear();
			$this->query($query);
			$this->data();
			
			return $this->DATA;
		}

		function quicktable($query) {
			$this->clear();
			$this->query($query);
			$this->data();
			$this->datatotable();
			
			return $this->html;
		}

		function clear() {
			unset($this->DATA);
			unset($this->ress_id);
			unset($this->html);
		}
		
		function par_explode($PAR) {
			if (strstr($PAR,"::")) {
				$PAR = constant_replace($PAR);
				$PAR = core_replace($PAR);
			
				$ARR_TEMP = explode("||",$PAR);
				
				while (list($prout, $TO_EXPLODE) = each($ARR_TEMP)) {
					list($key, $value) = explode("::",$TO_EXPLODE);
					
					if (strstr($value,",")) {
						$VALUE_ARR = explode(",",$value); 
					} else {
						$VALUE_ARR = $value;
					}
					
					$ARR[$key] = $VALUE_ARR;	
				}
					
				return $ARR;
			} else {
				$ARR[] = $PAR;
				
				return $ARR;
			}
		}		
		
		
		
	// }
	// function db_select($table, $PAR="", $data_only=false) { // $id=0, $pid="", $db=1, $index=false
		// global $CORE;

		// if ($table != "") {
			// if (isset($PAR['db'])) {$db = $PAR['db'];} else {$db = 0;}
			
			// $DB = new db($db);	
	
			// if (isset($PAR['id'])) {
				// $id = $PAR['id'];
			
				// if (is_numeric($PAR['id'])) {
					// if ($id != 0) {$query_where = "WHERE `id` = '$id'";}
				// } else {
					// $query_where = "WHERE `name` = '$id'";
				// }
			// }

			// if (isset($PAR['in'])) {
				// $in = $PAR['in'];
			
				// $query_where = "WHERE `id` IN ($in)";
			// }
	
			// if (isset($PAR['pid']) && $PAR['pid'] != "") {
				// $pid = $PAR['pid'];
			
				// if ($pid != "root") {
					// if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}
					
					// $query_where .= "$where `pid` LIKE '%|$pid|%'";
				// }
			// }

			// if (isset($PAR['where']) && $PAR['where'] != "") {
				// $where_and = $PAR['where'];
			
				// if ($pid != "root") {
					// if ($query_where == "") {$where = "WHERE";} else {$where = "AND";}
					
					// $query_where .= "$where $where_and";
				// }
			// }

			// if (isset($PAR['order'])) {
				// if (isset($PAR['order_dir'])) {
					// $order_dir = strtoupper($PAR['order_dir']);
				// } else {
					// $order_dir = "ASC";
				// }
				
				// $order 			= $PAR['order'];
				// $query_order 	= "ORDER BY `$order` $order_dir";
			// } else {
				// $query_order 	= "ORDER BY `order` ASC";
			// }

			// if (isset($PAR['group'])) { //v3.25
				// $group 			= $PAR['group'];
				// $query_group 	= " GROUP BY `$group`";
			// }

			// if ($PAR['index'] != "") {$fields = "id,pid";} else {$fields = "*";}
			// if ($PAR['fields'] != "") {$fields = $PAR['fields'];}
			// if ($PAR['allowed'] == 1) {$groups = $CORE['USER']['allowed']; $query_groups = " AND `allowed` IN ($groups)";}
			// if ($PAR['status'] == 1) {$query_status = " AND `status` = '1'";}
			// if ($PAR['type'] != "") {$type = $PAR['type'];} else {$type = 1;}

			// if (isset($PAR['limit'])) {
				// $limit = $PAR['limit'];
			
				// if (isset($PAR['start'])) {$start = $PAR['start'];} else {$start = 0;}
			
				// $query_limit = " LIMIT $start,$limit"; 
			// }
				
			// $query_select 	= "SELECT $fields";
			// $query_from 	= " FROM `$table`";			
				
			// $query = "--  list_db $table
						  // $query_select					  
						  // $query_from
						  // $query_where
						  // $query_group
						  // $query_status
						  // $query_groups
						  // $private_query
						  // $query_order
						  // $query_limit 				  
					 // ";
		// //e($query);	
			// $RESULTS = $DB->select($query, $type);	

			// if ($type != 3) {			
				// if (is_array($RESULTS['ROWS'])) {
					// $CORE['LIST']['TABLES'][] 	= $table;	
					// $DATA['INI']['db'] 			= $db;
					// $DATA['INI']['CC'][$table] 	= $RESULTS['rows_number'];
					// $DATA['INI']['list_total'] 	= array_sum($DATA['INI']['CC']);
					// $DATA['INI']['cc_total'] 	= array_sum($DATA['INI']['CC']);
					// $DATA['INI']['query'] 		= format_rmspace($RESULTS['query']);
					// $DATA['INI']['query_nav'] 	= "SELECT COUNT(*) $query_from $query_where $query_status $query_groups GROUP BY `id`";
					
					// foreach ($RESULTS['ROWS'] as $id => $ROW) {
						// if (!$data_only) {
							// $ROW['level']			= 1;
							// $ROW['table']			= $table;
						// }
						
						// $DATA['DATA'][$id] 		= $ROW;
						// $IDS[$table][] 			= $id;
					// }
					
					// $DATA['FIELDS'] 			= array_keys($ROW);		
					// $DATA['IDS']				= $IDS;
				
					// set_function("list_db", "$table | $value | $db | type:$type");
					// return $DATA;			
				// } else {
					// set_function("list_db", "$table | $value | $db | EMPTY");
				// }
			// } else {
				// set_function("list_db", "$table | $value | $db | type:$type");
				// return $RESULTS;
			// }				
		// } else {
			// set_function("list_db", "$table | $value | $db | NO TABLE");
		// }
	}	
	
?>