<?php 



	function type_prod_styles($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;
		
		$DB = new db();

		$PAR 				= explode_par($par);

		$PROD_ITEMS_TYPES 	= $LIST['prod_items_types']['DATA'];
		$PROD_STYLES 		= $LIST['prod_styles']['DATA'];
		$PROD_STYLES_TYPES 	= $LIST['prod_styles_types']['DATA'];	

	/// SORT STYLES BY STYLE TYPES
		foreach ($PROD_STYLES as $key => $STYLE) {
			$STYLES_BY_TYPE[$STYLE['type_id']][] = $STYLE['id'];
		}
		

		
		foreach ($PROD_ITEMS_TYPES[$AC['type']] as $key => $value) {
			if (strstr($key, 'style_') && $value != '') {
				$STYLE_TYPES[$value] = $STYLES_BY_TYPE[$value];
			}
		}

	/// BUILD INVENTORY
		switch($_GET['m'])
		{
		    case 'build_inventory':
				//$ITEM = $AC;
 				function prout() {
 					
					
 				}
				
				
				


		        break;

		}




		$query = 'SELECT * FROM prod_inventory WHERE item_id = ' . $AC['id'];
		$RESULTS = $DB->select($query);

//e($RESULTS);

		if ($RESULTS['rows_number'] == 0) {
			$html .= url('build inventory', qs_load() . '&m=build_inventory&build_id=' . $AC['id']);
			
		}


		


		$return = $html;

		set_function("prod_colors", $field_name);
		return $return;
	}

	function ci_prod_styles($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;



		set_function("prod_colors", $field_name);
		return $return;
	}
	
?>