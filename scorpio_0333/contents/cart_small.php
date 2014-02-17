<?php 


	$list_name 	= "cart_small";
	$root		= 1700;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}

/// LIST INI
	$INI = array(	'list' 		=> $list_name,
					'table' 	=> "cart",
					'limit' 	=> 20,
	 				'root' 		=> $list_root,
					'page' 		=> "cart",
					'order' 	=> "cdate",
					);

	list_ini($INI);
	
	$CART_ITEMS = &$LIST['cart_small']['ITEMS'];
	
	foreach ($CART_ITEMS as $item_id => $ITEMS) {
		$item_total = $ITEMS['quantity'] * $ITEMS['price'];
		$CART_ITEMS[$item_id]['item_total'] = $item_total;
		$cart_total += $item_total;
		$b_del = "
				<a href=\"?\">X</a> - ";
		$CART_ITEMS[$item_id]['b_del']	= $b_del;	
	};
	
	//e($cart_total);

/// CATS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name, 
						'template'	=> $list_name,
						'type' 		=> "cats",
						'parent' 	=> "cart",
						
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 		=> $list_name, 
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'form'		=> 0,
	 					);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> $list_name,
						'form'		=> 0,
						
	 					);

	$html .= list_parse($ITEMS_INI);
	
	$html .= "<span style=\"text-align:right;\"><br /> TOTAL : <b>" . $CORE['VARS']['cart_total'] . " $</b>";
	$html .= "<br /> <a href=\"?p=cart\">" . lang_arr(array("VOIR PANIER", "VIEW CART")) . "</a></span>";
				

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> $list_name,
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>