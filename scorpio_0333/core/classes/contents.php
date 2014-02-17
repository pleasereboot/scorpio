<?php 

	/* SCORPIO engine - class_session.php - v2.5		*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2007-01-22	 						*/	
	/* KAMELOS MARKETING INC	163/220					*/

	class contents {
		var $CORE;
 		var $DB;
		var $TABLES;
		
		var $listname;	//holds list name
		var $CI_SEED;	//holds seed (input in tables)
		var $CO_SEED; 	//holds list (output from tables)		
		var $QUERY_INI;	//holds the query ini infos		
		var $QUERY;		//holds the query itself
		var $PARENT_INI;//holds the parent ini infos
		var $PARENT; 	//holds the parent item
		var $DATA; 		//holds query results
		var $RS; 		//holds active rs
		var $LISTEN; 	//holds the listen() results

		var $AR; 		//holds active row
		var $UR; 		//holds updated row	
		var $AF; 		//holds active field			
		var $HTML; 		//holds updated results

		
		var $TREE; 		//holds tree
		var $TREE_TEMP; //holds tree temp
		var $TREE_LIST; //holds tree list		
		
		function contents($list_name, $INI="") {
			$this->CORE 	= &$GLOBALS['CORE'];
			$this->TABLES	= $this->CORE['TABLES'];
			$this->listname	= $list_name;
			
			//$this->DB		= new db();
			//if ($this->CO_SEED['db'] == "") {$this->CO_SEED['db'] = 0;} // devrait venir du seed
		}
	
	
		function listen($listname='') { 
			if ($listname == '') {$listname = $this->listname;}
			
			$GET = $_GET;
						
			foreach ($GET as $key => $value) {
				//list($list,$mode) = explode('_',$key); 
	//e($key .  $value);
				$this->LISTEN[$key] = $value;

			}
	//e($this->LISTEN);
			return $this->LISTEN;
		}
		
		function process($listname='') { 
			if ($listname == '') {$listname = $this->listname;}
			
			switch ($this->LISTEN['m'])	{
				case 'structs_export' :
					$STRUCTS = tree($this->LISTEN['id'],'',array('status' => 1, 'allowed'=>1));
					
					$STRUCTS_LIST = tree_to_list($this->LISTEN['id'],$STRUCTS);
					
					$write_html .= "<?php 
							";
					
					foreach($STRUCTS_LIST as $key => $TREE_ROW) {
						if ($key = $this->LISTEN['id']) {$export_name = $TREE_ROW['name'];}
						
						foreach($TREE_ROW as $prout => $row_value) {
							$row_value = addslashes($row_value);
							$write_html .= "\$TREE_IMPORT[$key]['$prout'] = '$row_value';
							";
						}
					}
					
					$write_html .= "?>";
					
					$filename = $export_name . '_' . $this->LISTEN['id'] . '.php';
			
					if ($fp = @fopen(SCORPIO_INSTALL_PATH . '/' . $filename, 'w')) { 
						fwrite($fp, $write_html);
						fclose($fp);
					}	
				break;

				/// IMPORT 
				case 'structs_import' :
					$pid_parent = 4879;
				
					$filename = $export_name . '_' . $this->LISTEN['id'] . '.php';
					
					include(SCORPIO_INSTALL_PATH . '/' . $filename);
					
					stripslashes_deep($TREE_IMPORT);
					
					foreach($TREE_IMPORT as $ROW) {
						unset($ROW['level']);
						unset($ROW['table']);
						
						if($pid_new == '') { // first
							$pid_new = $pid_parent;
						} else {
							$pid_new = $IDS[explode_pid($ROW['pid'])];
						}
						
						$id_new = contents_add($pid_new, $ROW['name'], $ROW);
						
						$IDS[$ROW['id']] 	= $id_new;
					}
				break;

			}				

		}		
		

		
		
//	
//		function ci_set($INI, $value="") { 
//			if ($value == "") {
//				foreach ($INI as $field => $value) {
//					$this->ci_set($field,$value);
//				}
//			} else {
//				$this->CI_SEED[$INI] = $value;
//			}
//		}
//		
//		function co_set($INI, $value="") {
//			if ($value == "") {
//				foreach ($INI as $field => $value) {
//					$this->co_set($field,$value);
//				}
//			} else { 
//				$this->CO_SEED[$INI] = $value;
//			}
//		}
//		
//		function ci_load($seed) {
//			$SEED 		= new items();
//			$SEED_INI = array('cid' => $seed, 'ctb' => 551); 
//			$SEED->select($SEED_INI);
//			$this->ci_set($SEED->DATA[0]);
//
//			return $this->CI_SEED;
//		}
//
//		function co_load($seed) {
//			$SEED 		= new items();
//			$SEED_INI = array('cid' => $seed, 'ctb' => 552); 
//			$SEED->select($SEED_INI);			
//			$this->co_set($SEED->DATA[0]);
//
//			return $this->CO_SEED;
//		}
//
//		function select($INI="") {
//		/// USE SEED
//			if ($INI == "") {
//				$INI = $this->CO_SEED;
//			}
//
//		/// LISTEN FOR REQUEST UPDATE
//			$this->listen($this->CO_SEED['listen_list']);
//e($this->LISTEN);			
//			foreach ($this->LISTEN as $listen_key => $listen_value) {
//				//$INI[$listen_key] = $listen_value;
//			}
//			
//
//		//e($INI);
//
//		/// MODE SELECTION	
//			if (isset($INI['cid']) && $INI['cid'] != "") {
//			/// ZOOM
//				$this->CO_SEED['mode'] = "zoom";			
//				$WHERE[] 		= "r.cid = " . $INI['cid'];
//				$WHERE[] 		= "r.ctb = " . $INI['ctb'];	
//			} else {
//			/// LIST
//				$this->CO_SEED['mode'] = "list";
//				if (isset($INI['ctb']) && $INI['ctb'] != "") {$WHERE[] 		= "r.ctb = " . $INI['ctb'];}
//				if (isset($INI['pid']) && $INI['pid'] != "") {$WHERE[] 		= "r.pid = " . $INI['pid'];}
//				if (isset($INI['ptb']) && $INI['ptb'] != "") {$WHERE[] 		= "r.ptb = " . $INI['ptb'];}
//				if (isset($INI['tid']) && $INI['tid'] != "") {$WHERE[] 		= "r.tid = " . $INI['tid'];}
//				if (isset($INI['ttb']) && $INI['ttb'] != "") {$WHERE[] 		= "r.ttb = " . $INI['ttb'];}				
//			}
//
//		/// GET PARENT   ship dans parent_get
//			$PARENT = $this->parent_get($INI['pid'],$INI['ptb']); // si prends plus que 2 vars, faire un $INI
////e($PARENT);		
//			if (isset($INI['rel_from'])) {$SELECT[] = "r." . implode(",r.", $INI['rel_from']);} else {$SELECT[] = "r.*";}
//			
//		 // ORDER	
//			if (!isset($INI['orderby_dir'])) {$INI['orderby_dir'] = " ASC " ;}
//			if (isset($INI['orderby'])) {$orderby = " ORDER BY = " . $INI['orderby'] . $INI['orderby_dir'];}
//
//			if (isset($INI['ctb'])) {
//				$items_table 	= $this->TABLES[$INI['ctb']];
//				if (isset($INI['items_from'])) 	{$SELECT[] = "i." . implode(",i.", $INI['items_from']);} else {$SELECT[] = "i.*";}
//			} else {
//				$items_table 	= $this->TABLES[$INI['ptb']];
//			}
//				
//			if ($items_table != "") {$join = "LEFT JOIN ($items_table AS i) ON (i.id=r.cid)";}	
//					
//			if (isset($SELECT)) {$select = implode(", ", $SELECT);}
//			if (isset($WHERE)) {$where = " WHERE " . implode(" AND ", $WHERE);}
//			
//			$query = "SELECT $select FROM sys_relations AS r $join $where $orderby";
//						
//			$RESULTS = $this->query($query);
////e($RESULTS);			
//			$this->QUERY_INI 		= $RESULTS['_INI'];
//			unset($RESULTS['_INI']);
//			
//			if ($INI['parent'] == true) {
//				$this->DATA = array_merge($PARENT,$RESULTS);
//			} else {
//				$this->DATA = $RESULTS;
//			}
//
//			return $results;
//		}	
//
//		function delete($INI="") {
//			$cid			= $INI['cid'];
//			$ctb 			= $INI['ctb'];
//			$items_table	= $this->TABLES[$ctb];
//			
//			$query 			= "DELETE FROM `" . $items_table . "` WHERE `id` IN ($cid) ";
////e($query);
//			$results 		= $this->query($query);
//		
//			$query 			= "DELETE FROM `sys_relations` WHERE `cid` IN ($cid) AND `ctb` = $ctb ";
//
//			$results 		= $this->query($query);
//			
//			return $results;
//		}
//
//		function parent_get($pid, $ptb) {
//			if ($pid != "" && $ptb != "") {
//				$parent_table	= $this->TABLES[$ptb];
//				
//				$query = "SELECT * FROM sys_relations AS r LEFT JOIN ($parent_table AS i)
//							ON (i.id=r.cid) WHERE r.cid = $pid AND r.ctb = $ptb";
//							
//				$PARENT = $this->query($query);	
//									
//				$this->PARENT_INI 		= $PARENT['_INI'];
//				unset($PARENT['_INI']);
//				$this->PARENT = $PARENT;
//			}	
//
//			return $PARENT;
//		}
//
//		function relations_add($INSERT="",$INI="") {		
//			$ctb			= $INI['ctb'];
//			$pid			= $INI['pid'];
//			$ptb 			= $INI['ptb'];		
//			$tid			= $INI['tid'];
//			$ttb 			= $INI['ttb'];
//			$vid 			= $INI['vid'];
//		
//			$items_table = $this->TABLES[$ctb];
//
//		/// valider this items (relations) struct	CI	
//			$time 	= time();		
//			$INSERT = array(	'cid' 		=> $cid,  // p-e crisser tout ca dans une f() qui prepare la relation (for use in update too) or use CI
//								'ctb' 		=> $ctb, 
//								'pid' 		=> $pid, 
//								'ptb' 		=> $ptb,
//								'tid' 		=> 1, 
//								'ttb' 		=> 1,
//								'vid' 		=> 1,
//								'primary'	=> 1, 
//								'cdate' 	=> $time,								
//								'mdate' 	=> $time, 
//								'order' 	=> 1000, 
//								'owner' 	=> 1,	
//								'read' 		=> 1,	
//								'write' 	=> 1, 
//								'exe' 		=> 1,	
//								'status'	=> 1,							
//								);						
//												
//			$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
//			$val_item = "'" . implode("','", array_values($INSERT)) . "'";		
//			
//			echo $query = "INSERT INTO `sys_relations` ( $val_column ) VALUES ( $val_item);";		
//			//$results = $this->query("$query");
//				
//			return $id;		
//		
//		}
//		
//		function insert($INSERT="",$INI="") {
//			$items_table = $this->TABLES[$this->CI_SEED['ptable']];
//		
//			$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
//			$val_item 	= "'" . implode("','", array_values($INSERT)) . "'";		
//			
//			$query 		= "INSERT INTO `$items_table` ( $val_column ) VALUES ( $val_item);";		
//			$results 	= $this->query("$query");			
//			$new_id		= mysql_insert_id();
//
//			if ($this->CI_SEED['relation']) {
//				$RELATION = new items();
//				$RELATION->ci_load(1);
//			e($RELATION->CI_SEED);
//				$REL_INI = array('cid' => $new_id, 'cdate' => time());	// add table rel
//				$RELATION->insert($REL_INI,$INI);				
//			}
//				
////			$ctb			= $INI['ctb'];
////			$pid			= $INI['pid'];
////			$ptb 			= $INI['ptb'];		
////		
////			$items_table = $this->TABLES[$ctb];
////			
////			//$sid = 
////		
////		/// valider this items struct
////			$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
////			$val_item 	= "'" . implode("','", array_values($INSERT)) . "'";		
////			
////			$query 		= "INSERT INTO `$items_table` ( $val_column ) VALUES ( $val_item);";		
////			$results = $this->query("$query");
////		
////			$cid = mysql_insert_id();	
////			$this->relations_add($cid, $INI);	
//				
//			return $cid;	
//		}
//
//		function tree($level=0, $CURRENT="", $LIST="") {
//			if ($level==0) {
//				$LIST = $this->DATA;
//				$CURRENT = $LIST[0];	
//			}
//
//			$CURRENT['level'] = $level;
//			$this->TREE[] = $CURRENT;
//			$level++;
//			
//			foreach ($LIST as $key => $ROW) {
//				if ($ROW['pid'] == $CURRENT['cid'] && $ROW['ptb'] == $CURRENT['ctb']) {				
//					unset($LIST[$key]);	
//					$this->tree($level, $ROW, $LIST);
//				}
//			}
//		}
//		
//		function show_seed($mode=1) {
//			if ($mode == 0) {
//				return print_r($this->CO_SEED,1);
//			} else {
//				e($this->CO_SEED);
//			}
//			
//			return $this->CO_SEED;
//		}				
//
//		function query($query="", $type=10) {
//			$DB = new db($this->CO_SEED['db']);
//			
//			if ($query == "") {$query = $this->query_get();}
//
//			$RESULTS = $DB->select($query, $type);
//			
//			return $RESULTS;
//		}		
//
//		function rs_load($rs_id, $tid="", $ttb="") {
//			global $RS;
//
//			if (!isset($RS[$rs_id])) {		
//				$RS_LIST = new items();
//				$RS_LIST->select(array('ctb' => 501, 'tid' => $tid, 'ttb' => $ttb));
////e($rs_id);e($tid);e($ttb);
////e($RS_LIST->CO_SEED);				
//				$RS_LIST->tree2($rs_id,501);   // last thing changed
////e($RS_LIST->TREE);	
//				foreach ($RS_LIST->TREE['_CHILDS'] as $PARENT => $ROW) {
//					$this->RS[$ROW['name']] = $ROW;
//				}
//				
//				$RS[$rs_id] = $this->RS;
//			} else {
//				$this->RS = $RS[$rs_id];
//				
//			}
////e($this->RS);
//			return $this->RS;
//		}
//
//		function run($INI="") {
//			$cid_start = $INI['cid_start'];
//			$ctb_start = $INI['ctb_start'];
//		
//		/// RS
//		
//		/// TEMPLATE
//			
//			foreach ($this->TREE as $key => $ROW) {
//				if (($ROW['cid'] == $cid_start && $ROW['ctb'] == $ctb_start)) {
//					$START = $ROW;
//					$return .= $key;
//					$start = true;
//				} else if ($ROW['level'] <= $START['level'] && $start == true) {
//					break;
//				}
//
//				if ($ROW['level'] > $START['level'] && $start == true) {
//					$return .= $key;
//				}
//			}
//			
//			return $return;
//		}
//
//		function tree2($cid="", $ctb="", $level=0) {
//			if ($level==0) {
//				$this->TREE_TEMP = $this->DATA;
//				$prout = true;
//			}
//				
//			$this->TREE_LIST;
//						
//			$level++;
//			
//			if (($level <= ($this->CO_SEED['gen'] + 1)) || !isset($this->CO_SEED['gen'])) {	/// CONTROLS NUM TREE GENERATION
//				foreach ($this->TREE_TEMP as $key => $ROW) {
//					if ($ROW['cid'] == $cid && $ROW['ctb'] == $ctb) {
//						$TREE = $ROW;
//						$TREE['_INI']['level'] = $level;
//						$this->TREE_LIST[] = $TREE;
//						unset($this->TREE_TEMP[$key]);
//					}
//				}
//	
//				foreach ($this->TREE_TEMP as $key => $ROW) {			
//					if ($ROW['pid'] == $cid && $ROW['ptb'] == $ctb) {
//						$TREE_RES = $this->tree2($ROW['cid'], $ROW['ctb'], $level);
//						 
//						if ($TREE_RES != "") {
//							$TREE['_CHILDS'][] = $TREE_RES;
//						}
//					}
//				}
//			}	
//							
//			$TREE['_INI']['child_count'] = count($TREE['_CHILDS']);
//			
//			if ($prout) {
//				$this->TREE = $TREE;
//				unset($TREE['_CHILDS']);
//				$this->PARENT = $TREE;	
//				//e($this->TREE_TEMP);  //orphelins
//			}
//
//			return $TREE;
//		}
//
//		function parse($LIST="", $INI="") {
//			if (count($this->TREE_LIST) > 0) {
//				$this->DATA = $this->TREE_LIST;
//			} else if ($LIST != "") {
//				$this->DATA = $LIST;
//			}
//		
//		 // load seed
//			if ($INI != "") 	{$this->co_set($INI);}
//			if (!isset($this->CO_SEED['rs'])) 	{$this->CO_SEED['rs'] = 4;}
////e($this->CO_SEED['rs']);			
////e($this->CO_SEED);
//			if ($this->DATA != "") {
//			/// SHOW PARENT
//				if (!$this->CO_SEED['show_parent']) {array_shift($this->DATA);}
//			
//				foreach ($this->DATA as $key => $this->AR) {
//				 // load rs
////e($this->AR);
//					//if (!isset($this->AR['type'])) {   // need something else to run system
//						$this->rs_load($this->CO_SEED['rs'],1001,501);
//
//						foreach ($this->RS as $RS_FIELD) {
//							$field = $RS_FIELD['name'];
//							
//							if (isset($this->AR[$field])) {
//								$this->UR[$field] = $this->AR[$field];
//								$av = $this->AR[$field];
//								$uv = &$this->UR[$field];
//									 
//								foreach ($RS_FIELD['_CHILDS'] as $CO) {
//									if (function_exists($CO['name'])) {	
//										$CO_INI = array('PAR' => new_explode_par($CO['par']), 'af' => $field, 'av' => $av, 'uv' => &$uv, 'AR' => &$this->AR,'UR' => &$this->UR, 'SEED' => &$this->CO_SEED, 'CO' => $CO, 'listname' => $this->listname);
//										//e($CO['name']);
//										@call_user_func($CO['name'],&$CO_INI);
//										//e($this->UR);
//									}
//								}
//							}
//							
//							$return .= $uv . BR;
//						}
//						
//						$return .= BR;
//					//}
//				}		
//			} else {
//				$return = "nothing to parse";
//			}
//		
//			return $return;
//		}	
			
	}

?>