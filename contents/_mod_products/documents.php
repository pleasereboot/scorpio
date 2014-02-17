<?php 

	global $CORE;
	
	$DB = new db();
	
	include('contents/mod_products/class_docs.php');

	$this_page  = 'products';
	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];

	$mode = $_GET['m'];
	
	switch($mode){			
		case "baskettoquote":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Soumission');
				$BASKET->change_mdate();
				$BASKET->change_docid($BASKET->get_next_id('|4323|'));
				$BASKET->save();							
		
				header("Location:?p=prod_documents");
			}
		break;
		
		case "baskettoorder":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Commande');
				$BASKET->change_mdate();
				$BASKET->stock_update('instock');
				$BASKET->stock_update('inorder', 'pos');
				$BASKET->change_docid($BASKET->get_next_id('|4573|'));
				$BASKET->save();							
		
				header("Location:?p=prod_documents");			
			}		
		break;

		case "baskettobooking":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Booking');
				$BASKET->change_mdate();
				$BASKET->stock_update('booked', 'pos');
				$BASKET->change_docid($BASKET->get_next_id('|4325|'));
				$BASKET->save();							
		
				header("Location:?p=prod_documents");
			}		
		break;

		case "baskettocredit":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Note de crédit');
				$BASKET->change_mdate();
				$BASKET->change_docid($BASKET->get_next_id('|4576|'));
				$BASKET->save();							

				header("Location:?p=prod_documents");
			}		
		break;

		case "baskettoinvoice":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Facture');
				$BASKET->change_mdate();
				$BASKET->stock_update('instock');
				$BASKET->change_docid($BASKET->get_next_id('|4326|'));
				$BASKET->save();							
		
				header("Location:?p=prod_documents");			
			}		
		break;

		case "baskettoadjust":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Ajustement');
				$BASKET->change_mdate();
				$BASKET->stock_update('instock', 'pos');
				$BASKET->change_docid($BASKET->get_next_id('|4327|'));
				$BASKET->save();							
		
				header("Location:?p=prod_documents");
			}		
		break;

		case "ordertoinvoice":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$ORDER = new doc($_GET['order_id']);		
				$ORDER->saveas('Facture');	
							
				$INVOICE = new doc($ORDER->new_id);				
				$INVOICE->change_type('Facture');
				$INVOICE->change_mdate();
				$INVOICE->change_ref($ORDER->DOC['document_id'], 'C');
				$INVOICE->save();
				
				$ORDER->change_comments(BR . 'FACTURE no. ' . $INVOICE->DOC['document_id'] , true);
				$ORDER->save();						
			}
		break;
				
		case "order_confirm":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$DB = new db();		
					
				$order_id = $_GET['order_id'];	
										
				$CART_DATA = db_select('prod_documents', array(	'id' 		=> $order_id  ));			
			
				$ORDER_DATA = $CART_DATA;
				
				$ORDER_DATA['pid'] = '4573';
				
				$query = "UPDATE `prod_documents` SET `pid` = '|4573|' WHERE `id` = '$order_id';";
				$DB->query($query);
				
				$time = TIME;
				$query = "UPDATE `prod_documents` SET `cdate` = '$time' WHERE `id` = '$order_id';";
				$DB->query($query);	
							
				unset($CORE['QS']['m']);
				unset($CORE['QS']['order_id']);
				
				$CORE['QS']['documents_cat_id'] = 4573;
				
				
			/// IN ORDER ITEMS					
				$ITEMS_INI 	= array('where' => "`document_id` = '$order_id'");
										
				$ITEMS_DATA = db_select('prod_details', $ITEMS_INI);	
		
			/// IN STOCK ITEMS	
				foreach($ITEMS_DATA['DATA'] as $ITEM) {
					$IDS[] = $ITEM['product_id'];
				}
				
				reset($ITEMS_DATA);
										
				$STOCK_DATA = db_select('prod_products', array('in' => implode(",", $IDS)));
				
			/// 				
				foreach($ITEMS_DATA{'DATA'} as $key => $ITEM) {
					foreach($ITEM as $field => $value) {
						if (strstr($field,'size') && $value != 0) {
							$item_id 		= $ITEM['product_id'];
							$to_field 		= str_replace('size','instock',$field);
							$num_instock	= $STOCK_DATA['DATA'][$item_id][$to_field];
							$num_update 	= $num_instock - $value;
							
							$query = "UPDATE `prod_products` SET `$to_field` = '$num_update' WHERE `id` = '$item_id';";
							
							//e($query);
							$DB->query($query);
						}
					}
				}
	
				header("Location:$page" . qs_load());
			}
		
		break;	
	
		case "adjust_confirm":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$DB = new db();		
					
				$order_id = $_GET['order_id'];	
										
				$CART_DATA = db_select('prod_documents', array(	'id' 		=> $order_id  ));			
			
				$ORDER_DATA = $CART_DATA;
				
				$ORDER_DATA['pid'] = '4327';
				
				$query = "UPDATE `prod_documents` SET `pid` = '|4327|' WHERE `id` = '$order_id';";
				$DB->query($query);
				
				unset($CORE['QS']['m']);
				unset($CORE['QS']['order_id']);
				
				$CORE['QS']['documents_cat_id'] = 4327;
				
				
			/// IN ORDER ITEMS					
				$ITEMS_INI 	= array('where' => "`document_id` = '$order_id'");
										
				$ITEMS_DATA = db_select('prod_details', $ITEMS_INI);	
		
			/// IN STOCK ITEMS	
				foreach($ITEMS_DATA['DATA'] as $ITEM) {
					$IDS[] = $ITEM['product_id'];
				}
				
				reset($ITEMS_DATA);
										
				$STOCK_DATA = db_select('prod_products', array('in' => implode(",", $IDS)));
				
			/// 				
				foreach($ITEMS_DATA{'DATA'} as $key => $ITEM) {
					foreach($ITEM as $field => $value) {
						if (strstr($field,'size') && $value != 0) {
							$item_id 		= $ITEM['product_id'];
							$to_field 		= str_replace('size','instock',$field);
							$num_instock	= $STOCK_DATA['DATA'][$item_id][$to_field];
							$num_update 	= $num_instock - $value;
							
							$query = "UPDATE `prod_products` SET `$to_field` = '$num_update' WHERE `id` = '$item_id';";
							
							//e($query);
							$DB->query($query);
						}
					}
				}
	
				header("Location:$page" . qs_load());
			}
		
		break;
	
		case "detail_add":	
			$DB = new db();
	
			
			if (!is_array($_POST['detailadd_id'])) {
				$this_id = $_POST['detailadd_id'];
			 	unset($_POST['detailadd_id']);	
				$_POST['detailadd_id'][] = $this_id;
			}
			
			foreach($_POST['detailadd_id'] as $active_id) {
				$ITEM_ORI_INI 	= array(	'id' 		=> $active_id,
											'type' 		=> 3,
	
									  );			
				
				$ITEM_ORI_DATA = db_select('prod_products',$ITEM_ORI_INI);
						
			//e($ITEM_ORI_DATA);
			
				$INSERT = array('document_id' 	=> $_POST['doc_id'], 
								'product_id' 	=> $active_id,
								'cdate' 		=> TIME,
								'mdate' 		=> TIME,
								'product_price' => 0 + $ITEM_ORI_DATA['price'],
								'name' 			=> $ITEM_ORI_DATA['name'],
								);
		
				$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
				$val_item = "'" . implode("','", array_map('addslashes', array_values($INSERT))) . "'";
				
				$query = "INSERT INTO `prod_details` ( $val_column ) VALUES ( $val_item);";
				//echo $query."<br>";
				$DB->query($query);
				$id = mysql_insert_id();
			}
		
			goto($_POST['returnpath']);
		
		break;

		case "print":		  
		/// SPLASH CATS
			$list_name 	= "documents";
			$root		= 4032;
			
			if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
		
			$PRODUCTS_INI = array(	'list' 			=> $list_name,
									'root' 			=> $list_root,
									'page' 			=> "prod_documents",
									'table' 		=> "prod_documents",
									'rs_name' 		=> "documentsprint",
									'template'		=> "documentsprint",
									'mode' 			=> "list",
									'mod'			=> "mod_products",
									'order' 		=> "document_id",
									'order_dir'		=> "DESC",									
									'struct'		=> 0,
									'form'			=> 0,
									'ci_name'		=> "documents",
									'edit_return'	=> 1,
									'add'			=> "false",
								  );
								
			list_ini($PRODUCTS_INI);
			
			$DOC		= $LIST[$list_name];
		
			$document_html .= list_parse($PRODUCTS_INI);
			
		 // DOC VARS	
			$doc_id 	= $DOC['INI']['item_id'];
			$client_id 	= $DOC['ITEMS'][$doc_id]['user_id'];
			$type 		= strtoupper(substr($LIST['document_type']['DATA'][$DOC['ITEMS'][$doc_id]['pid']],0,1));

		/// FILL USER 
			if ($client_id != '') {
				$USER_INI 	= array(	'id' 		=> $client_id,
										'type' 		=> 3,

									  );			
				
				$USER_DATA = db_select('users',$USER_INI);
				
				$user_html = 	BR . '<b>' . $USER_DATA['name'] . '</b>' . BR . 
								$USER_DATA['adress'] . BR .
								$USER_DATA['city'] . ' (' . $USER_DATA['prov'] . ') ' . $USER_DATA['postalcode'] . BR;
			}

		 // FILL DETAILS 
			if ($doc_id != '') {$detail_where = "`document_id` = $doc_id";}

			$DETAILS_INI = array(	'list' 		=> 'detailslist',
									'root' 		=> 4032,
									'page' 		=> "prod_documents",
									'table' 	=> "prod_details",
									'rs_name' 	=> "detailsprint",
									'template'	=> "detailsprint",
									'where'		=> $detail_where,
									'order' 	=> "cdate",
									'struct'	=> 0,
									'form'		=> 0,
									'mode' 		=> "list",
									'mod'		=> "mod_products",
									'add'		=> "false",
									'limit' 	=> 1000,
									'parse_start' => 0,
									'parse_limit' => 5,
								  );
								
			list_ini($DETAILS_INI);

			$DETAILS = $LIST['detailslist'];
			
			$total_page = ceil(count($DETAILS['ITEMS']) / 5);
			$shipping 	= $DOC['ITEMS'][$doc_id]['shipping'];
			
			for($i = 0; $i <= ($total_page - 1); $i++) { 
				$DETAILS_INI['parse_start'] = $i * 5;
			
				$details_html = list_parse($DETAILS_INI);
			
				$PAGE_VARS = array(		'ITEMS_DETAILS' => $details_html,
										'PAGE_NUM' 		=> ($i + 1) . ' de ' . $total_page,										
										);
				
				$final_html .= set_var($document_html, $PAGE_VARS);	
				
				if ($i != ($total_page - 1)) {$final_html .= "<p STYLE='page-break-before: always'></p>";}	
			}

			$DOCUMENT_VARS = array(	'USER_DETAILS' 	=> $user_html,
									'TC'			=> $type,
									'STOTAL' 		=> number_format($CORE['VARS']['prod_stotal'], 2, '.', ''),//round($CORE['VARS']['prod_stotal'],2),
									'TPS' 			=> number_format(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05, 2, '.', ''), //round(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05,2),
									'TVQ' 			=> number_format(0, 2, '.', ''),
									'SHIPPING_CALC'	=> number_format($shipping, 2, '.', ''),
									'TOTAL' 		=> number_format(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05, 2, '.', ''),//round(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05,2),		
									'COMMENTS' 		=> '',								
									);

			$final_html = set_var($final_html, $DOCUMENT_VARS);
			$final_html = t_remove_empty($final_html);
			
			if (is_allowed(5)) {
				require_once(SCORPIO_CLASSES_PATH . 'pdf/html2pdf.class.php');
				$PDF = new HTML2PDF('P','LETTER','fr');
				$PDF->WriteHTML($final_html, 1); //isset($_GET['vuehtml'])
				//$PDF_RES = $PDF->Output('document.pdf',true); 		 
			}	
		
			$return .= $final_html;
		break;
				
		case "invoices_list":		  
		default:
		/// SPLASH CATS
			$list_name 	= "documents";
			$root		= 4032;
			$add 		= 'false';
			
			$NO_EDIT = array('|4327|','|4573|');
			
			if ($CORE['GET']['documents_cat_id'] != '') {
				if (isset($PAR['root'])) {
					$list_root = $PAR['root'];
				} else {
					$list_root = $root;
				}			
			} else {
				$show_all = 'true';
			}

		 // ADD NEW ITEM ON NEW DOC ONLY
			if ($CORE['GET']['documents_cat_id'] == 4324) {$add	= 'true';}
			
			$PRODUCTS_INI = array(	'list' 			=> $list_name,
									'root' 			=> $list_root,
									'page' 			=> "prod_documents",
									'table' 		=> "prod_documents",
									'rs_name' 		=> "documents",
									'template'		=> "documents",
									'mode' 			=> "list",
									'mod'			=> "mod_products",
									'order' 		=> "mdate",
									'order_dir'		=> "DESC",									
									'show_all'		=> $show_all,	
									'form'			=> 0,
									'ci_name'		=> "documents",
									'edit_return'	=> 1,
									'limit' 		=> 24,
									'add'			=> $add,
								  );
								
			list_ini($PRODUCTS_INI);
			
			$DOC		= $LIST[$list_name];
		
			$document_html .= list_parse($PRODUCTS_INI);
			$document_html .= list_nav($PRODUCTS_INI);
			
		 // DOC VARS	
			$doc_id 	= $DOC['INI']['item_id'];
			$client_id 	= $DOC['ITEMS'][$doc_id]['user_id'];
			$type 		= strtoupper(substr($LIST['document_type']['DATA'][$DOC['ITEMS'][$doc_id]['pid']],0,1));

		 // FILL USER 
			
			if ($client_id != '') {
				$USER_INI 	= array(	'id' 		=> $client_id,
										'type' 		=> 3,

									  );			
				
				$USER_DATA = db_select('users',$USER_INI);
				
			//e($USER_DATA);	
				
				$user_html = 	BR . '<b>' . $USER_DATA['name'] . '</b>' . BR . 
								$USER_DATA['adress'] . BR .
								$USER_DATA['city'] . ' (' . $USER_DATA['prov'] . ') ' . $USER_DATA['postalcode'] . BR;
			}


								  
											
		 // FILL PRODUCTS ADD 
	//e($DOC['ITEMS'][$doc_id]['pid']);
		 
			if (!in_array($DOC['ITEMS'][$doc_id]['pid'], $NO_EDIT)) {
				$returnpath  = qs_load();
								
				$PRODUCTS_INI 	= array(	//'id' 		=> $client_id,
											'fields' 		=> 'id,name',
											'order' 		=> 'name',
									  );
										
				$PRODUCTS_DATA = db_select('prod_products', $PRODUCTS_INI);
				 
//				$product_sel = select_build($PRODUCTS_DATA['DATA'], 'products_sel', 'id', 'name', 'detailadd_id', $selected=false, $blank=false); 

				
//				$details_html .= 'AJOUTER UNE LIGNE DE DETAIL : ';
//				$details_html .= 	"<form action=\"?p=prod_documents&m=detail_add\" method=\"post\" enctype=\"multipart/form-data\" name=\"products_adddetails\">
//										$product_sel
//										<input name=\"doc_id\" type=\"hidden\" value=\"$doc_id\" />
//										<input name=\"returnpath\" type=\"hidden\" value=\"$returnpath\" />
//										<input name=\"s_adddetails\" type=\"submit\" value=\"AJOUTER\" />
//									</form>" ;
									
				$product_multisel = select_build($PRODUCTS_DATA['DATA'], 'products_multisel', 'id', 'name', 'detailadd_id', $selected=false, $blank=false, true); 					
									
				$details_html .= 'AJOUTER DES STYLES : ';
				$details_html .= 	"<form action=\"?p=prod_documents&m=detail_add\" method=\"post\" enctype=\"multipart/form-data\" name=\"products_adddetails\">
										$product_multisel
										<input name=\"doc_id\" type=\"hidden\" value=\"$doc_id\" />
										<input name=\"returnpath\" type=\"hidden\" value=\"$returnpath\" />
										<input name=\"s_adddetails\" type=\"submit\" value=\"AJOUTER\" />
									</form>" ;									
			}
			
			
		 // FILL DETAILS 
			if ($doc_id != '') {$detail_where = "`document_id` = $doc_id";}
			
			if (!in_array($DOC['ITEMS'][$doc_id]['pid'], $NO_EDIT)) {$details_form = 1;} else {$details_form = 0;}
		 //e($detail_where);
			$DETAILS_INI = array(	'list' 		=> 'detailslist',
									'root' 		=> 4032,
									'page' 		=> "prod_documents",
									'table' 	=> "prod_details",
									'rs_name' 	=> "detailslist",
									'template'	=> "details",
									'where'		=> $detail_where,
									'order' 	=> "cdate",
									//'order_dir' => "ASC",
									'mode' 		=> "list",
									'mod'		=> "mod_products",
									'add'		=> "false",
									'form'		=> $details_form,
									'limit' 	=> 1000,
								  );
								
			list_ini($DETAILS_INI);

			$details_html .= list_parse($DETAILS_INI);			
			$shipping 	   = $DOC['ITEMS'][$doc_id]['shipping'];
			
			$DOCUMENT_VARS = array(	'USER_DETAILS' 	=> $user_html,
									'ITEMS_DETAILS' => $details_html,
									'TC'			=> $type,
									'STOTAL' 		=> number_format($CORE['VARS']['prod_stotal'], 2, '.', ''),//round($CORE['VARS']['prod_stotal'],2),
									'TPS' 			=> number_format(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05, 2, '.', ''), //round(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05,2),
									'TVQ' 			=> number_format(0, 2, '.', ''),
									'SHIPPING_CALC'	=> number_format($shipping, 2, '.', ''),
									'TOTAL' 		=> number_format(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05, 2, '.', ''),//round(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05,2),		
									'COMMENTS' 		=> '',								
									
			
									);
			
			$document_html = set_var($document_html, $DOCUMENT_VARS);
			$document_html .= url('print', qs_load() . '&m=print') . BR;

		/// IF BASKET	
			if ($DOC['ITEMS'][$doc_id]['pid'] == '|4324|') {
				$document_html .= ' Créer : ' . url(' soumission', qs_load() 				. '&m=baskettoquote&order_id=' 	. $doc_id);
				$document_html .= ' | ' . 		url(' commande', qs_load() 					. '&m=baskettoorder&order_id=' 	. $doc_id);
				$document_html .= ' | ' . 		url(' booking', qs_load() 					. '&m=baskettobooking&order_id=' 	. $doc_id);
				$document_html .= ' | ' . 		url(' facture', qs_load() 					. '&m=baskettoinvoice&order_id=' 	. $doc_id);
				$document_html .= ' | ' . 		url(' note de credit', qs_load() 			. '&m=baskettocredit&order_id=' . $doc_id);
				$document_html .= ' | ' . 		url(' modification d\'inventaire', qs_load(). '&m=baskettoadjust&order_id=' . $doc_id) . BR . BR;	
			}

		/// IF QUOTE
			if ($DOC['ITEMS'][$doc_id]['pid'] == '|4323|') {
				$document_html .= ' | ' . url('Quote to order', qs_load() 	. '&m=quotetoorder&order_id=' 	. $doc_id);
				$document_html .= ' | ' . url('Quote to booking', qs_load()	. '&m=quotetobooking&order_id=' . $doc_id);
				$document_html .= ' | ' . url('Quote to invoice', qs_load()	. '&m=quotetoinvoice&order_id=' . $doc_id);
			}	
		
		/// IF ORDER
			if ($DOC['ITEMS'][$doc_id]['pid'] == '|4573|') {
				$document_html .= ' | ' . url('Order to invoice', qs_load() 	. '&m=ordertoinvoice&order_id=' 	. $doc_id);
			}			
				
			$return .= $document_html;
	}
	
?>