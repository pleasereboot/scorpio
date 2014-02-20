<?php 

	/* SCORPIO engine - scorio.php - v3.18			*/	
	/* functions relatives to scorpio engine		*/
	/* created on 2006-12-09	 					*/
	/* updated on 2008-02-18	 					*/	
	/* YANNICK MENARD			176/1388			*/

	function listen($listname) {
		global $CORE;
		
		$GET = $_GET;
	
		foreach ($GET as $get_key => $get_value) {
			list($list,$mode) = explode('_',$get_key);
			//e($list,1);
			if ($list == $listname) {
				$RETURN[] = $get_key;
			}
		}
	
		return $RETURN;
	}

	function mode_get() {
		global $CORE;
		
		if ($list != "") {$list = $list . "_";}
		
		$mode = $CORE['GET']['m'];
		
		return $mode;
	}

	function goto_previous() {
		global $CORE;
		
		$previous = "?" . $CORE['SESSION']['previous_url'];
		header("Location:$previous");
	}

	function goto_url($url="") {
		if (strstr($url,'?')) {$goto = $url;} else {$goto = "?" . $url;} //v3.25
	
		
		header("Location:$goto");
	}

	function make_select_options($LIST,$select="",$none="",$REFLIST="") {
		//if ($PAR['none'] != "false") {$select .= "<option value=\"\"$selected> </option>";}
		
		foreach($LIST as $key => $value) {
			$selected = "";	

			if ($select == $key) {
				$selected = " selected";
			}
			
			if ($REFLIST != "") {
				$value = $REFLIST[$value];
			}
			
			$select_html .= "<option value=\"$key\"$selected>$value</option>";
		}
		
		return $select_html;
	}

	function page_add($INI) { // crisser dans scorpio
		if (isset($INI['pid'])) {
			if (is_numeric($INI['pid'])) {
				$pid = $INI['pid'];
			} else {
				$pid = data_switch("contents", $INI['pid']);
			}
		} else {
			$pid = data_switch("contents", "pages");
		}
		
		$INSERT = array(	"pid" 			=> "|" . $pid . "|", 
							"name" 			=> $INI['name'],  
							"type" 			=> 1, 
							"par" 			=> $INI['par'], 
							"label_fr" 		=> $INI['name'], 
							"label_en" 		=> $INI['name'], 
						);

		$PAGE_INI = array(	"rs_name" 		=> "ci_page",
							"table_name" 	=> "contents",
						);	

		$new_id = list_item_add($INSERT, $PAGE_INI);

		set_function("page_add", $INI['name']);
		
		return $new_id;	
	}

	function list_item_add($INSERT,$INI="") { // INSERTS FOR MULTIPLE INSERT // INSERT POURRRAIT ETRE OI
		global $CORE;
		global $LIST;
	
		$DB = new db();

	/// prepare CHECKIN RS		
		$rs_name = $INI['rs_name'];
		$rs_id = data_switch($INI['table_name'], $rs_name);

		if ($rs_id) {
			$RS_RES = tree($rs_id, 0, array('status'=>1, 'allowed'=>true));
			$RS = $RS_RES['CHILDS'];
			
			$TYPES 	= &$LIST['checkin'];
			$OI		= &$INSERT; // ORIGINAL INSERT
			$RI		= $INSERT;	// RETURNED INSERT
			
			foreach ($RS as $FIELD) {
				$AF = $INSERT[$FIELD['name']];
				$FIELD_ONLY = $FIELD;
				unset($FIELD_ONLY['CHILDS']);
								
				foreach ($FIELD['CHILDS'] as $TYPE) {
					$FIELDS[$FIELD['name']][$TYPE['name']] = array('type' => $TYPE['type'],'par'  => $TYPE['par']);
					$TYPE_INI = array('OI' => $OI, 'RI' => $RI, 'AF' => $AF, 'FIELD' => $FIELD_ONLY, 'TYPE_PAR' => explode_par($TYPE['par']));
					
					$function_name = $TYPES[$TYPE['type']]['function'];

					if (function_exists($function_name)) {
						$RI[$FIELD['name']] = @call_user_func($function_name, $TYPE_INI);
					} else {
						set_message("function_$type_name", "la function $type_name n'existe pas - content name : $field_name", 1);
					}					
				}
			}	
		} else {
			$RI	= $INSERT;
			set_message("load rs", "row structure <b>$rs_name</b> dans <b>$list_name</b> est inexistant", 1);		
		}

//		//echo $query."<br>";
		$id = $DB->insert($INI['table_name'], $RI);

		set_function("list_item_add", "$pid - $name");
		return $id;
	}


?>