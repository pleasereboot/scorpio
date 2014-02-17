<?php 

	global $CORE;
	global $LIST;
	
	$DB = new db();
	
	include('contents/mod_products/class_docs.php');

	$this_page  = 'prod_documents';
	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];
	$doc_id 	= $_GET['order_id'];

	$mode = $_GET['m'];
	
	switch($mode){			
		case "baskettoquote":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type(2);
				$BASKET->change_mdate();
				$BASKET->change_docid($BASKET->get_next_id(2));
				$BASKET->save();							
		
				header("Location:?p=prod_documents&documents_item_id=" . $BASKET->DOC['document_id']);
			}
		break;
		
		case "baskettoorder":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type(3);
				$BASKET->change_mdate();
				//$BASKET->stock_update('instock');
				$BASKET->stock_update('inorder', 'pos');
				$BASKET->change_docid($BASKET->get_next_id(3));
				$BASKET->save();							
		
				header("Location:?p=prod_documents&documents_item_id=" . $BASKET->id);			
			}		
		break;

		case "baskettobooking":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type(5);
				$BASKET->change_mdate();
				$BASKET->stock_update('booked', 'pos');
				$BASKET->change_docid($BASKET->get_next_id(5));
				$BASKET->save();							
		
				header("Location:?p=prod_documents&documents_item_id=" . $BASKET->DOC['document_id']);;
			}		
		break;

		case "baskettocredit":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type(9);
				$BASKET->change_mdate();
				$BASKET->change_docid($BASKET->get_next_id(9));
				$BASKET->save();							

				header("Location:?p=prod_documents&documents_item_id=" . $BASKET->DOC['document_id']);
			}		
		break;

		case "baskettoinvoice":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type(6);
				$BASKET->change_mdate();
				$BASKET->stock_update('instock');
				$BASKET->change_docid($BASKET->get_next_id(6));
				$BASKET->save();							
		
				header("Location:?p=prod_documents&documents_item_id=" . $BASKET->id);			
			}		
		break;

		case "baskettoadjust":	
			if (is_allowed(5) && $_GET['order_id'] != '') {
				$BASKET = new doc($_GET['order_id']);		
					
				$BASKET->change_type('Adjustement');
				$BASKET->change_mdate();
				$BASKET->stock_update('instock', 'pos');
				$BASKET->change_docid($BASKET->get_next_id(8));
				$BASKET->save();							
		
				header("Location:?p=prod_documents&documents_item_id=" . $BASKET->DOC['document_id']);
			}		
		break;

		case "quotetoorder":
		//case "quotetoinvoice":
			if (is_allowed(5) && $doc_id != '') {
				$QUOTE = new doc($doc_id);		
				$QUOTE->saveas(3);	
						
				$ORDER = new doc($QUOTE->new_id);				
				$ORDER->change_type(3);
				$ORDER->change_mdate();
				$ORDER->change_ref($QUOTE->DOC['document_id'], 2);
				$ORDER->save();
				
				$BASKET->stock_update('inorder', 'pos');
				$QUOTE->change_comments(BR . 'COMMANDE no. ' . $ORDER->DOC['document_id'] , true);
				$QUOTE->save();
				
				header("Location:?p=prod_documents&documents_item_id=" . $QUOTE->new_id);						
			}
		break;

		case "quotetoinvoice":
			if (is_allowed(5) && $doc_id != '') {
				$QUOTE = new doc($doc_id);		
				$QUOTE->saveas(6);
						
				$INVOICE = new doc($QUOTE->new_id);				
				$INVOICE->change_type(6);
				$INVOICE->change_mdate();
				$INVOICE->change_ref($QUOTE->DOC['document_id'], 2);
				$INVOICE->save();
				
				$QUOTE->change_comments(BR . 'FACTURE no. ' . $INVOICE->DOC['document_id'] , true);
				$QUOTE->save();
				
				header("Location:?p=prod_documents&documents_item_id=" . $ORDER->new_id);						
			}
		break;

		case "ordertoinvoice":	
			if (is_allowed(5) && $doc_id != '') {
				$ORDER = new doc($doc_id);		
				$ORDER->saveas(6);
							
				$INVOICE = new doc($ORDER->new_id);				
				$INVOICE->change_type(6);
				$INVOICE->change_mdate();
				$INVOICE->change_ref($ORDER->DOC['document_id'], 3);
				$INVOICE->save();
				
				$ORDER->change_comments(BR . 'FACTURE no. ' . $INVOICE->DOC['document_id'] , true);
				$ORDER->save();	
				
				header("Location:?p=prod_documents&documents_item_id=" . $ORDER->new_id);					
			}
		break;
		
		case "closeinvoice":	
			if (is_allowed(5) && $doc_id != '') {
				$INVOICE = new doc($doc_id);		
					
				$INVOICE->change_type(7);
				$INVOICE->change_mdate();
				$INVOICE->stock_update('instock');
				$INVOICE->stock_update('inorder', 'pos');
				//$BASKET->change_docid($BASKET->get_next_id(7));
				$INVOICE->save();							
		
				header("Location:?p=prod_documents&documents_item_id=" . $doc_id);			
			}		
		break;		
		
		case "closeinvoicebo":	
			if (is_allowed(5) && $doc_id != '') {
				$INVOICE = new doc($doc_id);		
					
				$INVOICE->change_type(7);
				$INVOICE->change_mdate();
				$INVOICE->stock_update('instock');
				$INVOICE->stock_update('inorder', 'pos');
				//$BASKET->change_docid($BASKET->get_next_id(7));
				$INVOICE->save();	
				$INVOICE->saveas(4);
				
				//echo ;
				$ORDER = new doc($INVOICE->DOC['ref_db_id']);
				e($ORDER->DETAILS);
				
				$BO = new doc($INVOICE->new_id);		
				$BO->change_ref($INVOICE->DOC['document_id'], 7, $INVOICE->id);	
				$BO->details_remove($ORDER->DETAILS);
				$BO->save();
				
				
				$INVOICE->change_comments(BR . 'B.O. no. ' . $BO->DOC['document_id'] , true);
				$INVOICE->save();				
			//e($BO);							
				header("Location:?p=prod_documents&documents_item_id=" . $INVOICE->new_id);					
				//header("Location:?p=prod_documents&documents_item_id=" . $INVOICE->new_id);			
			}		
		break;	
			
		case "detail_update":	
			$DB = new db();
		
//e($_POST);		
			foreach($_POST as $key => $value) {
				list($field, $id) = explode('-', $key); 
				
				if (isset($id)) {
					$UPDATES[$id][$field] = $value;
				}		
			}
			
			foreach($UPDATES as $key => $UPDATE) {
				$DB->update('prod_details', $key, $UPDATE);
			}
				
			$return_path = $CORE['POST']['return_path'];
			
			header("Location:$return_path");
		
		break;	
					
		case "detail_add":	
			$DB = new db();
			//$D =  new doc();
		//e($_POST);	
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
									//'TC'			=> $type,
									'STOTAL' 		=> number_format($CORE['VARS']['prod_stotal'], 2, '.', ''),//round($CORE['VARS']['prod_stotal'],2),
									'TPS' 			=> number_format(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05, 2, '.', ''), //round(($CORE['VARS']['prod_stotal'] + $shipping) * 0.05,2),
									'TVQ' 			=> number_format(0, 2, '.', ''),
									'SHIPPING_CALC'	=> number_format($shipping, 2, '.', ''),
									'TOTAL' 		=> number_format(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05, 2, '.', ''),//round(($CORE['VARS']['prod_stotal'] + $shipping) * 1.05,2),		
									'COMMENTS' 		=> '',								
									);

			$final_html = set_var($final_html, $DOCUMENT_VARS);
			$final_html = t_remove_empty($final_html);
			
			if (is_allowed(4)) {
				require_once(SCORPIO_CLASSES_PATH . 'pdf/html2pdf.class.php');
				$PDF = new HTML2PDF('P','LETTER','fr');
				$PDF->WriteHTML($final_html, 1); //isset($_GET['vuehtml'])
				//$PDF_RES = $PDF->Output('document.pdf',true); 		 
			}	
		
			$return .= $final_html;
		break;

		case "detail_delete":	
			$detail_id = $_GET['detaildelete_id'];
			$query = "DELETE FROM `prod_details` WHERE `id` = $detail_id;";
		//echo $query."<br>"; 
			$RESULTS = $DB->query($query);			
		
		//break;
				
		case "invoices_list":		  
		default:
			if (is_allowed(5)) {
			/// SPLASH CATS
				$list_name 	= "documents";
				$list_root	= 4032;
				$add 		= 'false';
		
				$SIZES 		= $LIST['sizes']['DATA'];
				
		
			/// USER FOR LIST remove et faire un join dans prochaine version
				$LIST['prod_customers'] = db_select('users', array('allowed' => 1, 'where' => 'id > 101', )); // patch pour lister customers
									
				$NO_EDIT = array(3,7,9);
				
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
				
	//			if (isset($CORE['GET']['documents_item_id'] )) {
	//				$PRODUCTS_INI['item_id'] = $CORE['GET']['documents_item_id'];
	//			}
								
				if ($CORE['GET']['type'] == 1) {
					$PRODUCTS_INI['add'] = 'true';
				}	
				
	
				if(isset($CORE['GET']['type'])) {
					$PRODUCTS_INI['where'] = 'type=' . $CORE['GET']['type'];
				}					
				
				list_ini($PRODUCTS_INI);
	
				$document_html .= list_parse($PRODUCTS_INI);
				$document_html .= list_nav($PRODUCTS_INI);			
								
				if (isset($CORE['GET']['documents_item_id'] )) {
					$DOC		= $LIST[$list_name];
			//e($DOC);				
				 // DOC VARS	
					$doc_id 		= $DOC['INI']['item_id'];
					$client_id 		= $DOC['ITEMS'][$doc_id]['user_id'];
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
					//if ($doc_id != '') {$detail_where = "`document_id` = $doc_id";}
					
					if (!in_array($DOC['ITEMS'][$doc_id]['type'], $NO_EDIT)) {$details_form = 1;} else {$details_form = 0;}
				 //e($detail_where);
	
				 
					$query 		= "SELECT * FROM prod_details WHERE document_id = $doc_id ORDER BY cdate";
					
					$DETAILS 	= $DB->select($query);
		
		//e($DETAILS);
		
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
								
						//e($item_amount);
							} 
							
							
						}
	
						$title_line 	= url('X', '?p=prod_documents&documents_item_id=' . $doc_id . '&m=detail_delete&detaildelete_id=' . $detail_id) . ' ' . b($DETAIL['name']);
						$price_qty		= input($DETAIL['product_price'], "product_price-$detail_id", array('size' => 3));
	
						$rows_html 		.= tr(td($title_line, array('colspan' => 8)). td($price_qty . ' X ', array('colspan' => 2)) . td(b($item_count) . ' = ', array('colspan' => 1)) . td(b(number_format($item_amount) . ' $'), array('colspan' => 3)), array('color' => '#CCCCCC')) . tr(($ths) . tr($iss));
						$rows_html 		.= tr(td(HS));
						
						$total_count 	+= $item_count;
						$total_amount 	+= $item_amount;
						
						
						
					}
			//e($total_count);
			//e($total_amount);
					
					$action 		= '?p=prod_documents&m=detail_update'; //&documents_item_id=' . $id
					$id 			= 'details_update';
					$submit 		= button($id, 'UPDATE', 'submit');
					$return_path 	= hidden($_SERVER['REQUEST_URI'], 'return_path');
		//e($_SERVER['REQUEST_URI']);			
					$details_html .= form(table($rows_html) . $return_path . $submit, $action, 'prod_documents', $onsubmit='');			 
				 
				 
				 
				 
	//				$DETAILS_INI = array(	'list' 		=> 'detailslist',
	//										'root' 		=> 4032,
	//										'page' 		=> "prod_documents",
	//										'table' 	=> "prod_details",
	//										'rs_name' 	=> "detailslist",
	//										'template'	=> "details",
	//										'where'		=> $detail_where,
	//										'order' 	=> "cdate",
	//										//'order_dir' => "ASC",
	//										'mode' 		=> "list",
	//										'mod'		=> "mod_products",
	//										'add'		=> "false",
	//										'form'		=> $details_form,
	//										'limit' 	=> 1000,
	//									  );
	//									
	//				list_ini($DETAILS_INI);
	//	
	//				$details_html .= list_parse($DETAILS_INI);	
					
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
		
				/// IF BASKET	
					if ($DOC['ITEMS'][$doc_id]['type'] == 1) {
						$document_html .= ' Convert to : ' . url(' quote', "?p=$this_page" 		. '&m=baskettoquote&order_id=' 	. $doc_id);
						$document_html .= ' | ' . 			url(' order', "?p=$this_page" 			. '&m=baskettoorder&order_id=' 	. $doc_id);
						$document_html .= ' | ' . 		url(' booking', "?p=$this_page" 			. '&m=baskettobooking&order_id=' 	. $doc_id);
						$document_html .= ' | ' . 		url(' invoice', "?p=$this_page" 			. '&m=baskettoinvoice&order_id=' 	. $doc_id);
						$document_html .= ' | ' . 		url(' credit note', "?p=$this_page" 		. '&m=baskettocredit&order_id=' . $doc_id);
						$document_html .= ' | ' . 		url(' stock adjustment', "?p=$this_page"	. '&m=baskettoadjust&order_id=' . $doc_id) . BR . BR;	
					}
		
				/// IF QUOTE
					if ($DOC['ITEMS'][$doc_id]['type'] == 2) {
						$document_html .= ' | ' . url('Quote to order', "?p=$this_page" 	. '&m=quotetoorder&order_id=' 	. $doc_id);
						$document_html .= ' | ' . url('Quote to booking', "?p=$this_page"	. '&m=quotetobooking&order_id=' . $doc_id);
						$document_html .= ' | ' . url('Quote to invoice', "?p=$this_page"	. '&m=quotetoinvoice&order_id=' . $doc_id);
					}	
				
				/// IF ORDER
					if ($DOC['ITEMS'][$doc_id]['type'] == 3) {
						$document_html .= ' | ' . url('Order to invoice', "?p=$this_page" 	. '&m=ordertoinvoice&order_id=' 	. $doc_id);
					}	
					
				/// IF INVOICE
					if ($DOC['ITEMS'][$doc_id]['type'] == 6) {
						$document_html .= ' | ' . url('close invoice', "?p=$this_page" 			. '&m=closeinvoice&order_id=' 	. $doc_id);
						$document_html .= ' | ' . url('close invoice with B.O.', "?p=$this_page" 	. '&m=closeinvoicebo&order_id=' 	. $doc_id);
						$document_html .= BR . 'ONCE CLOSED, INVOICE IS LOCKED AND CANNOT BE EDITED FURTHER';
					}	
								
				/// IF WEB CART	
					if ($DOC['ITEMS'][$doc_id]['type'] == 1) {
						$document_html .= ' Convert to : ' . url(' quote', "?p=$this_page" 		. '&m=baskettoquote&order_id=' 		. $doc_id);
						$document_html .= ' | ' . 			url(' order', "?p=$this_page" 		. '&m=baskettoorder&order_id=' 		. $doc_id);
						$document_html .= ' | ' . 			url(' booking', "?p=$this_page" 	. '&m=baskettobooking&order_id=' 	. $doc_id);
						$document_html .= ' | ' . 			url(' invoice', "?p=$this_page" 	. '&m=baskettoinvoice&order_id=' 	. $doc_id);
						//$document_html .= ' | ' . 		url(' credit note', "?p=$this_page" 		. '&m=baskettocredit&order_id=' . $doc_id);
						//$document_html .= ' | ' . 		url(' stock adjustment', "?p=$this_page"	. '&m=baskettoadjust&order_id=' . $doc_id) . BR . BR;	
					}			
				
							
				}	
							
				$return .= $document_html;
				
				//$return .= BR . BR . 'clean details';
			}
	}
	
?>