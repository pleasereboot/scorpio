<?php 

	global $CORE;
	global $LIST;
	
	include('contents/mod_products/class_docs.php');	
	
	$DB = new db();

	$this_page  = 'products';
	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];

	$query = "SELECT * FROM prod_documents WHERE `user_id` = $user_id AND `type` = 12";	
	
	$RESULTS = $DB->select($query,3);

	if (isset($_POST['cart_additem'])) {
		if (is_array($RESULTS)) {
			$D = new doc($RESULTS['id']);

			$doc_id = $RESULTS['id'];
		} else {
			$INSERT['cdate'] 	= TIME;
			$INSERT['mdate'] 	= TIME;
			$INSERT['user_id'] 	= $user_id;
			$INSERT['type'] 	= 12;
			
			$doc_id = $DB->insert('prod_documents', $INSERT);

			$D = new doc($doc_id);
		}
		
		$D->details_add($doc_id, $_POST);
		
		goto($_POST['return_path']);
	} else {
		$mode = $_GET['m'];
	
		switch($mode){
			case "detail_delete":	
				$detail_id = $_GET['detaildelete_id'];
				$query = "DELETE FROM `prod_details` WHERE `id` = $detail_id;";
			//echo $query."<br>"; 
				$DB->query($query);			
		}
		
		if (is_array($RESULTS)) {
		/// SPLASH CATS
			$list_name 	= "documents";
			$list_root	= 4032;
			$add 		= 'false';
	
			$SIZES 		= $LIST['sizes']['DATA'];
			
		 // ADD NEW ITEM ON NEW DOC ONLY
			$PRODUCTS_INI = array(	'list' 			=> $list_name,
									'root' 			=> $list_root,
									'page' 			=> "prod_documents",
									'table' 		=> "prod_documents",
									'rs_name' 		=> "documents",
									'template'		=> "documents",
									//'mode' 			=> "list",
									'mod'			=> "mod_products",
									'order' 		=> "mdate",
									'order_dir'		=> "DESC",									
									//'show_all'		=> $show_all,	
									'form'			=> 0,
									'ci_name'		=> "documents",
									'edit_return'	=> 1,
									'limit' 		=> 24,
									//'add'			=> $add,
								  );
	
			$PRODUCTS_INI['item_id'] = $RESULTS['id'];
			$PRODUCTS_INI['where'] = 'type=12 AND user_id=' . $user_id;
			list_ini($PRODUCTS_INI);

			$document_html .= list_parse($PRODUCTS_INI);
			$document_html .= list_nav($PRODUCTS_INI);			
							
			//if (isset($CORE['GET']['documents_item_id'] )) {
				$DOC		= $LIST[$list_name];
		//e($DOC);				
			 // DOC VARS	
				$doc_id 		= $DOC['INI']['item_id'];
				$client_id 		= $user_id; 
				$type 			= $DOC['ITEMS'][$doc_id]['type'];
	
			 // FILL USER 
				
				if ($client_id != '') {
					$USER_INI 	= array(	'id' 		=> $client_id,
											'type' 		=> 3,
	
										  );			
					
					$USER_DATA = db_select('users',$USER_INI);
					
					$user_html = 	BR . '<b>' . $USER_DATA['name'] . '</b>' . BR . 
									$USER_DATA['adress'] . BR .
									$USER_DATA['city'] . ' (' . $USER_DATA['prov'] . ') ' . $USER_DATA['postalcode'] . BR;
				}
				
			 // FILL PRODUCTS ADD 
				if (!in_array($DOC['ITEMS'][$doc_id]['type'], $NO_EDIT) && is_allowed(5)) { 
					$returnpath  = qs_load();
									
					$PRODUCTS_INI 	= array(	//'id' 		=> $client_id,
												'fields' 		=> 'id,name',
												'order' 		=> 'name',
										  );
											
					$PRODUCTS_DATA = db_select('prod_products', $PRODUCTS_INI);
										
					$product_multisel = select_build($PRODUCTS_DATA['DATA'], 'products_multisel', 'id', 'name', 'detailadd_id', $selected=false, $blank=false, true); 					
										
					$details_html .= 'ADD STYLES : ';
					$details_html .= 	"<form action=\"?p=prod_documents&m=detail_add\" method=\"post\" enctype=\"multipart/form-data\" name=\"products_adddetails\">
											$product_multisel
											<input name=\"doc_id\" type=\"hidden\" value=\"$doc_id\" />
											<input name=\"returnpath\" type=\"hidden\" value=\"$returnpath\" />
											<input name=\"s_adddetails\" type=\"submit\" value=\"AJOUTER\" />
										</form>" ;									
				}
				
			 // FILL DETAILS 	
				if (!in_array($DOC['ITEMS'][$doc_id]['type'], $NO_EDIT)) {$details_form = 1;} else {$details_form = 0;}
			 
				$query 		= "SELECT * FROM prod_details WHERE document_id = $doc_id ORDER BY cdate";
				
				$DETAILS 	= $DB->select($query);
	
				foreach ($DETAILS['ROWS'] as $detail_id => $DETAIL) {
					$item_id 		= $DETAIL['product_id'];
					$query 			= "SELECT id,grandeur FROM prod_products WHERE id = $item_id ORDER BY style";
				
					$ITEM 			= $DB->select($query, 3);
					
					$ITEM_SIZE 		= explode('||', $ITEM['grandeur']);
					$SIZE_INDEX 	= array_flip($SIZES); 

					$title_line 	= b($DETAIL['name']);
					$item_count 	= 0;
					$item_amount 	= 0;

					$ths = td('size');
					$iss = td('qty');
				//e($DETAIL);
					foreach ($DETAIL as $key => $value) {
						list($status, $size) = explode('_',  $key);
						
						$size = strtoupper($size); 
						
						if (in_array($SIZE_INDEX[$size], $ITEM_SIZE)) {		
							$OUTPUT[$status][$size] = $value; 

							$ths .= td($size); 
							$iss .= td(input($DETAIL['size_' . strtolower($size)],"$key-$detail_id", array('size' => 1)));
							
							$item_count += $DETAIL['size_' . strtolower($size)];
							$item_amount += $DETAIL['size_' . strtolower($size)] * $DETAIL['product_price'];
						} 
					}

					$title_line 	= url('X', '?p=cart&documents_item_id=' . $doc_id . '&m=detail_delete&detaildelete_id=' . $detail_id) . ' ' . b($DETAIL['name']);

					if(is_allowed(5)) {
						$price_qty		= input($DETAIL['product_price'], "product_price-$detail_id", array('size' => 3));
					} else {
						$price_qty		= $DETAIL['product_price'];
					}

					$rows_html 		.= tr(td($title_line, array('colspan' => 8)). td($price_qty . ' X ', array('colspan' => 2)) . td(b($item_count) . ' = ', array('colspan' => 1)) . td(b(number_format($item_amount) . ' $'), array('colspan' => 3)), array('color' => '#CCCCCC')) . tr(($ths) . tr($iss));
					$rows_html 		.= tr(td(HS));
					
					$total_count 	+= $item_count;
					$total_amount 	+= $item_amount;
				}
				
				$action 		= '?p=prod_documents&m=detail_update'; //&documents_item_id=' . $id
				$id 			= 'details_update';
				$submit 		= button($id, 'UPDATE', 'submit');
				$return_path 	= hidden($_SERVER['REQUEST_URI'], 'return_path');
		
				$details_html .= form(table($rows_html) . $return_path . $submit, $action, 'prod_documents', $onsubmit='');			 
			 
			/// DOCUMENT VARS			
				$shipping 	   = $DOC['ITEMS'][$doc_id]['shipping'];
				
				$DOCUMENT_VARS = array(	'USER_DETAILS' 	=> $user_html,
										'ITEMS_DETAILS' => $details_html,
										'ITEMS_COUNT' 	=> $total_count,
										//'REP_ID' 		=> $total_count,
										//'TC'			=> $type,
										'REF' 			=> $LIST['document_type']['DATA'][$DOC['ITEMS'][$doc_id]['ref_type']] . '-' . $DOC['ITEMS'][$doc_id]['ref_id'],
										'STOTAL' 		=> number_format($total_amount, 2, '.', ''),//round($CORE['VARS']['prod_stotal'],2),
										'TPS' 			=> number_format(($total_amount + $shipping) * 0.05, 2, '.', ''), //round(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05,2),
										'TVQ' 			=> number_format(0, 2, '.', ''),
										'SHIPPING_CALC'	=> number_format($shipping, 2, '.', ''),
										'TOTAL' 		=> number_format(($total_amount + $shipping) * 1.05, 2, '.', ''),//round(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05,2),		
										'COMMENTS' 		=> '',								
										);
				
				$document_html = set_var($document_html, $DOCUMENT_VARS);
				$document_html .= url('print', qs_load() . '&m=print') . BR;
			//}	
			
			$return .= $document_html;
		} else {
			$return .= 'no active cart';	
		}
	}
	
?>