<?php 

	/* SCORPIO engine - functions_types.php - v3.04		*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2007-04-23	 						*/	
	/* KAMELOS MARKETING INC	869/1299/840/2376		*/

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

		if (!isset($INI['TYPE_PAR']['value'])) {$owner = 6;} else {$owner = $INI['TYPE_PAR']['value'];}
		
		$return = $owner;
		
		set_function("ci_timestamp", $field_name);
		return $return;
	}
						
?>