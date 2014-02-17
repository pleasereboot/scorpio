<?php 

	/* SCORPIO engine - functions_types.php - v3.04		*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2007-04-23	 						*/	
	/* KAMELOS MARKETING INC	869/1299/840/2376		*/

	function ci_products($INI) {
		global $CORE;
		global $LIST;
		
		$DB = new db();
	
		if ($INI['av'] == '' && $INI['af'] = 'document_id') {
			$type = $INI['AR']['pid'];
			
		 // LAST NUM
			$query = "SELECT MAX(document_id) FROM `prod_documents` WHERE `pid`='$type'"; 
			$RESULTS = $DB->select($query, 3);
		
			$new_number = $RESULTS['MAX(document_id)'] + 1;
			
			$INI['uv'] = $new_number;
		}	
		
		set_function("ci_products", $INI['uv']);
		return $return;
	}

	function ci_timestamp($INI) {
		global $CORE;
	
		$return = time();
		
		set_function("ci_timestamp", $field_name);
		return $return;
	}

	function ci_owner($INI) {
		global $CORE;

		if (!isset($INI['TYPE_PAR']['value'])) {$owner = 6;} else {$owner = $INI['TYPE_PAR']['value'];}
		
		$return = $owner;
		
		set_function("ci_timestamp", $field_name);
		return $return;
	}
 
	function ci_password($INI) {
		global $CORE;
		
		if (strlen($INI['av']) != 32) {
			$INI['uv'] = md5($INI['av']);
		}	
		
		set_function("ci_password", $INI['uv']);
		return $return;
	}

?>