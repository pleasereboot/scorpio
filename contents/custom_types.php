<?php 

	function prod_inv($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;

		$list_name 	= 'prodinstock';
		$style 		= $AC['style'];
		
	/// LIST INI
		$INI = array(	'list' 		=> $list_name,
						'table' 	=> 'prod_products',
						//'limit' 	=> 12,
						'root' 		=> $list_root,
						'page' 		=> $page_root,
						'mod'		=> 'mod_products',
						//'select'	=> 'style,img',
						'where'		=> "`style` = '$style'",
						);
	
		list_ini($INI);

	/// ITEMS PARSE	
		$ITEMS_INI = array(	'list' 			=> $list_name,
							'rs_name' 		=> $list_name,
							'template'		=> $list_name,
							//'add' 			=> 'true',
							'mod'			=> 'mod_products',
							'no_item_show'	=> 'false',
							'form'			=> 0,
							//'splash'		=> 1,
							
							);
	
		$html .= list_parse($ITEMS_INI);
		
		$return = $html;

		set_function("prod_colors", $field_name);
		return $return;
	}

	function prod_colors($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;

		$PAR 				= explode_par($par);
		
		$COLOR_IDS = explode('||' , $AC['color']);
		
		$html  = "<table align=\"center\" ><tr>";

		foreach ($COLOR_IDS as $color_id) {
			$img_file = '<img src="files/' . strtolower($LIST['colors']['DATA'][$color_id - 1]['file']) . '"/>';
			$img_name = $LIST['colors']['DATA'][$color_id - 1][lang('title')];
			$html    .= "<td align=\"center\" valign=\"top\" width=\"80\">$img_file</td>";
		}
			 
		$html  .= "</tr></table>";
		
		$return = $html;

		set_function("prod_colors", $field_name);
		return $return;
	}

	function prod_sizes($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;

		$DB =  new db();

		$PAR 				= explode_par($par);
	
		$SIZES 		= $LIST['sizes']['DATA'];
		$STATUS 	= array('instock', 'inorder', 'booked', 'inprod', 'onsea');	

		$where = ' WHERE id = ' . $AC['id'];
				
		$query 		= 'SELECT * FROM prod_products' . $where;
		
		$PRODUCT 	= $DB->select($query, 3);
	
		$PRODUCT_SIZE = explode('||', $PRODUCT['grandeur']);
		$SIZE_INDEX = array_flip($SIZES); 

		$prod_id = $AC['id'];

		if (!is_allowed(2)) {
			$title_line = b($PRODUCT['name']);
			$ths = td();
			$iss = td('instock');
		}
		
		if (is_allowed(2) && !is_allowed(5)) {
			$title_line = b($PRODUCT['name']);
			$ths = td();
			$iss = td('instock');
			$ios = td('inorder');
			$bos = td('booked'); 
			$dis = td('disp'); 
			$ips = td('inprod');
			$oss = td('onsea');
			$qty = td('qty');
		}	

		if (is_allowed(5)) {
			$title_line = b($PRODUCT['name']) . url(I_EDIT, '?p=prod_items&products_prod_products_edit=' . $prod_id) . url(' (edit inventory)', '?p=prod_items&m=inv_list_full&item_id=' . $prod_id);
			$ths = td();
			$iss = td('instock');
			$ios = td('inorder');
			$bos = td('booked'); 
			$dis = td('disp'); 
			$ips = td('inprod');
			$oss = td('onsea');
			$qty = td('qty');
		}
			
//				
		foreach ($PRODUCT as $key => $value) {
			list($status, $size) = explode('_',  $key);
			
			$size = strtoupper($size);
			
			if (in_array($status, $STATUS) && in_array($SIZE_INDEX[$size], $PRODUCT_SIZE)) {		
				$OUTPUT[$status][$size] = $value; 
	
				if (!is_allowed(2)) {
					if ($status == 'instock') {
						$ths .= td($size); 
						$iss .= td('-', array('align' => 'center'));
					}
				}	
	
				if (is_allowed(2) && !is_allowed(5)) {
					if ($status == 'instock') {
						$ths .= td($size); 
						$iss .= td($PRODUCT['instock_' . strtolower($size)]);
					}
					if ($status == 'inorder') {$ios .= td($PRODUCT['inorder_' . strtolower($size)]);}
					if ($status == 'booked') {
						$bos .= td($PRODUCT['booked_' . strtolower($size)]);
						$dis .= td(b(($PRODUCT['instock_' . strtolower($size)]) - ($PRODUCT['inorder_' . strtolower($size)]) - ($PRODUCT['booked_' . strtolower($size)])));	
					}
					
					if ($status == 'inprod') {$ips .= td($PRODUCT['inprod_' . strtolower($size)]);}
					if ($status == 'onsea') {
						$oss .= td($PRODUCT['onsea_' . strtolower($size)]);					
						$qty .= td(BR . input(0,'size_' . strtolower($size) . "-$prod_id", array('size' => 1)));
					}
				}

				if (is_allowed(5)) {
					if ($status == 'instock') {
						$ths .= td($size); 
						$iss .= td(input($PRODUCT['instock_' . strtolower($size)],"$key-$prod_id", array('size' => 1)));
					}
					if ($status == 'inorder') {$ios .= td(input($PRODUCT['inorder_' . strtolower($size)],"$key-$prod_id", array('size' => 1)));}
					if ($status == 'booked') {
						$bos .= td(input($PRODUCT['booked_' . strtolower($size)],"$key-$prod_id", array('size' => 1)));
						$dis .= td(($PRODUCT['instock_' . strtolower($size)]) - ($PRODUCT['inorder_' . strtolower($size)]) - ($PRODUCT['booked_' . strtolower($size)]));	
					}
					
					if ($status == 'inprod') {$ips .= td(input($PRODUCT['inprod_' . strtolower($size)],"$key-$prod_id", array('size' => 1)));}
					if ($status == 'onsea') {
						$oss .= td(input($PRODUCT['onsea_' . strtolower($size)],"$key-$prod_id", array('size' => 1)));
						$qty .= td(BR . input(0,'size_' . strtolower($size) . "-$prod_id", array('size' => 1)));
					}					
				}				
			}
		}
//	
//				/// ITEM ACTION LINE
//					$b_switch = url('PROD TO SEA', "?p=prod_items&m=tosea_switch&item_id=$prod_id", array('onclick' => "valid_delete('Proceed to transfer to on sea?','?p=prod_items&m=tosea_switch&item_id=$prod_id');")) . ' &#8226 ' . 
//								url('SEA TO INSTOCK', "?p=prod_items&m=tostock_switch&item_id=$prod_id", array('onclick' => "valid_delete('Proceed to transfer to in stock?','?p=prod_items&m=tostock_switch&item_id=$prod_id');")); 
//					
//	
//					$item_action = tr(td(	$b_switch . ' &#8226 '
//											. b('prod date ') . calendar($PRODUCT['ddate_inprod'], "ddate_inprod-$prod_id", $PAR='') . ' &#8226 '
//											. b('sea date ') .  calendar($PRODUCT['ddate_onsea'], "ddate_onsea-$prod_id", $PAR='') . BR
//											. b('ship # ') . input($PRODUCT['shipping_number'], "shipping_number-$prod_id", array('size' => 10)) . ' &#8226 '
//											. b('PO # ') . input($PRODUCT['po_number'], "po_number-$prod_id", array('size' => 10)) . ' &#8226 '
//											. b('notes ') . input($PRODUCT['notes'], "notes-$prod_id", array('size' => 20))
//											, array('colspan' => 50)
//											
//											)) ;
//	
//	
				/// PUT ROW TOGHETER
		if (!is_allowed(2)) {
			$rows_html .= tr(td($title_line, array('colspan' => 8))) . tr(($ths) . tr($iss));	
		}
				
		if (is_allowed(2) && !is_allowed(5)) {
		/// INVENTORY LIST
			$rows_html .= tr(td($title_line, array('colspan' => 8))) . tr(($ths) . tr($iss) . tr($ios) . tr($bos) . tr($dis) . tr($ips) . tr($oss));	
			$rows_html .= tr(td(HS));
			//$html .= table($rows_html);
	
		/// CART FORM
			$action 		= '?p=cart';
			$id 			= 'cart_additem';
			$submit 		= button($id, 'ADD TO CART', 'submit');
			$return_path 	= hidden($_SERVER['REQUEST_URI'], 'return_path');
			$rows_html 		.= 	tr($qty);	
			$rows_html 		.= 	tr(td(HS));
			
			$html .= form($return_path . table($rows_html) . $submit, $action, 'prod_cart', $onsubmit='');	
			
		}				

		if (is_allowed(5)) {
		/// INVENTORY LIST	
			$action 		= '?p=prod_items';
			$id 			= 'products_update';
			$submit 		= button($id, 'UPDATE', 'submit');
			$return_path 	= hidden($_SERVER['REQUEST_URI'], 'return_path');
			$rows_html 		.= tr(td($title_line, array('colspan' => 8))) . tr(($ths) . tr($iss) . tr($ios) . tr($bos) . tr($dis) . tr($ips) . tr($oss) . tr($item_action));	
			$rows_html 		.= tr(td(HS));

			$html .= form(table($rows_html) . $return_path . $submit, $action, 'prod_items', $onsubmit='');
			
		/// CART FORM
			$action 		= '?p=cart';
			$id 			= 'cart_additem';
			$submit 		= button($id, 'ADD TO CART', 'submit');
			$return_path 	= hidden($_SERVER['REQUEST_URI'], 'return_path');
			$rows_html 		= 	tr($qty);	
			$rows_html 		.= 	tr(td(HS));
			
			$html .= form(table($rows_html) . $return_path . $submit, $action, 'prod_cart', $onsubmit='');		
		}


		
		


		
		
		
		$return = $html;

		set_function("prod_sizes", $field_name);
		return $return;
	}

//	function prod_sizes($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
//		global $CORE;
//		global $LIST;
//
//		$PAR 				= explode_par($par);
//		
//		$SIZES_IDS = explode('||' , $AC['grandeur']);
//		
//		$html  = "<table align=\"center\" ><tr>";
//
//		foreach ($SIZES_IDS as $size_id) {
//			
//			$size_name = $LIST['sizes']['DATA'][$size_id];
//			
//			if (is_allowed(2)) {$instock = $AC['instock_' . strtolower($size_name)];} else {$instock = '-';}
//			
//			$html    .= "<td align=\"center\" valign=\"top\" width=\"30\"><font size=\"-1\"><strong>$size_name</strong><br />$instock</font></td>";
//		}
//			 
//		$html  .= "</tr></table>";
//		
//		$return = $html;
//
//		set_function("prod_sizes", $field_name);
//		return $return;
//	}

	function prod_others($AC="", $HTML="", $par="", $field_name="", $TYPE_PAR="") {
		global $CORE;
		global $LIST;

		$PAR 				= explode_par($par);
		
		//$COLOR_IDS = explode('||' , $AC['color']);
		
		$html  = "<table align=\"center\" ><tr>";

		foreach ($COLOR_IDS as $color_id) {
			$img_file = '<img src="files/' . $AC[$field_name] . '"/>';
			//$img_name = $LIST['colors']['DATA'][$color_id - 1][lang('title')];
			$html    .= "<td align=\"center\" valign=\"top\" width=\"80\">$img_file</td>";
		}
			 
		$html  .= "</tr></table>";
		
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