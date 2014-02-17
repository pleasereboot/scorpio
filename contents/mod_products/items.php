<?php 

	global $CORE;
	global $LIST;
	
	$DB = new db();

	$this_page  = 'products';
	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];

	//$GET = listen($list_name);
//e($GET[0],1);
	$mode = $_GET['m'];
	
//	$return .= url('STYLES','?p=' . 'prod_items' . '&m=styles_list') . ' | ' . url('Styles types','?p=' . 'prod_items' . '&m=styles_types_list') . BR;
//	$return .= url('Items types','?p=' . 'prod_items' . '&m=items_types_list');
	
		switch($mode){
			case "styles_list":
				$list_name 	= "prodstyleslist";
				$root		= 3776;
				
				$INI = array(	'list' 		=> $list_name,
								'table' 	=> 'prod_styles',
								//'limit' 	=> 12,
				 				'root' 		=> $list_root,
								//'page' 		=> $page_root,
								'mod'		=> 'mod_products',
								//'select'	=> 'style,img',
								'group'		=> 'style',
								'order'		=> 'name',
								'order_dir'		=> 'desc',
								);
				
				list_ini($INI);				
			/// ITEMS PARSE	
				$ITEMS_INI = array(	'list' 		=> $list_name,
									'rs_name' 	=> $list_name,
									'template'	=> $list_name,
									'add' 		=> 'true',
									'mod'		=> 'mod_products',
									'no_item_show'	=> 'false',
									'form'			=> 0,
									//'splash'	=> 1,
									
				 					);
			
				$return .= list_parse($ITEMS_INI);		

			break;			

			case "inv_list":
			case "inv_list_print":
			case "inv_list_full":
				$list_name 	= "invreport";
				$root		= 3776;
	
				$SIZES 		= $LIST['sizes']['DATA'];
				$STATUS 	= array('instock', 'inorder', 'booked', 'inprod', 'onsea');

				if (isset($_GET[$list_name . '_style'])) {
					$where = ' WHERE `style` = \'' . $_GET[$list_name . '_style'] . '\'';
					$print_url_add = '&' . $list_name . '_style=' . $_GET[$list_name . '_style'];
				}				
				
				if (isset($_GET['item_id'])) {
					$where = ' WHERE id = ' . $_GET['item_id'];
				}
				
				$query 		= 'SELECT * FROM prod_products' . $where . ' ORDER BY name';
				
				$PRODUCTS 	= $DB->select($query);
	
				foreach ($PRODUCTS['ROWS'] as $prod_id => $PRODUCT) {
					$PRODUCT_SIZE = explode('||', $PRODUCT['grandeur']);
					$SIZE_INDEX = array_flip($SIZES); 

					$title_line = b($PRODUCT['name']) . url(I_EDIT, '?p=prod_items&products_prod_products_edit=' . $prod_id) . url(' (edit inventory)', '?p=prod_items&m=inv_list_full&item_id=' . $prod_id);

					$ths = td();
					$iss = td('instock');
					$ios = td('inorder');
					$bos = td('booked'); 
					$dis = td('disp'); 
					$ips = td('inprod');
					$oss = td('onsea');
				
					foreach ($PRODUCT as $key => $value) {
						list($status, $size) = explode('_',  $key);
						
						$size = strtoupper($size);
						
						if (in_array($status, $STATUS) && in_array($SIZE_INDEX[$size], $PRODUCT_SIZE)) {		
							$OUTPUT[$status][$size] = $value; 

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
							if ($status == 'onsea') {$oss .= td(input($PRODUCT['onsea_' . strtolower($size)],"$key-$prod_id", array('size' => 1)));}
							
						}
					}
	
				/// ITEM ACTION LINE
					$b_switch = url('PROD TO SEA', "?p=prod_items&m=tosea_switch&item_id=$prod_id", array('onclick' => "valid_delete('Proceed to transfer to on sea?','?p=prod_items&m=tosea_switch&item_id=$prod_id');")) . ' &#8226 ' . 
								url('SEA TO INSTOCK', "?p=prod_items&m=tostock_switch&item_id=$prod_id", array('onclick' => "valid_delete('Proceed to transfer to in stock?','?p=prod_items&m=tostock_switch&item_id=$prod_id');")); 
					
	
					$item_action = tr(td(	$b_switch . ' &#8226 '
											. b('prod date ') . calendar($PRODUCT['ddate_inprod'], "ddate_inprod-$prod_id", $PAR='') . ' &#8226 '
											. b('sea date ') .  calendar($PRODUCT['ddate_onsea'], "ddate_onsea-$prod_id", $PAR='') . BR
											. b('ship # ') . input($PRODUCT['shipping_number'], "shipping_number-$prod_id", array('size' => 10)) . ' &#8226 '
											. b('PO # ') . input($PRODUCT['po_number'], "po_number-$prod_id", array('size' => 10)) . ' &#8226 '
											. b('notes ') . input($PRODUCT['notes'], "notes-$prod_id", array('size' => 20))
											, array('colspan' => 50)
											
											)) ;
	
	
				/// PUT ROW TOGHETER
					$rows_html .= tr(td($title_line, array('colspan' => 8))) . tr(($ths) . tr($iss) . tr($ios) . tr($bos) . tr($dis) . tr($ips) . tr($oss) . tr($item_action));
					$rows_html .= tr(td(HS));
					
					
				}
				
				$action 		= '?p=prod_items';
				$id 			= 'products_update';
				$submit 		= button($id, 'UPDATE', 'submit');
				$return_path 	= hidden($_SERVER['REQUEST_URI'], 'return_path');
				
				$html .= form($return_path . table($rows_html) . $submit, $action, 'prod_items', $onsubmit='');
				
				
				//e($OUTPUT);
				
				
//								if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
//		
//		
//				$PRODUCTS_INI = array(	'list' 		=> $list_name,
//					 					//'root' 		=> $list_root,
//										'page' 		=> "prod_items",
//										'table' 	=> "prod_products",
//										'rs_name' 	=> "invreport",
//										//'ci_name' 	=> "userslist", 
//										'template'	=> "inv_report",
//										'mode' 		=> "list",
//										'mod'		=> "mod_products",
//										'add'		=> "false",
//										'limit'		=> 10,
//
//										//'edit'		=> 1,
//										//'form_url'	=> "?p=account&account_sendconf=1",
//									  );
//						
//				if (isset($_GET[$list_name . '_style'])) {
//						$PRODUCTS_INI['where'] = 'style=\'' . $_GET[$list_name . '_style'] . '\'';
//						$print_url_add = '&' . $list_name . '_style=' . $_GET[$list_name . '_style'];
//				}
//				
//				if ($mode == 'inv_list_full') {
//						$PRODUCTS_INI['limit'] = 1000;
//						//$PRODUCTS_INI['form'] = 0;
//				}				
//				
//				if ($mode == 'inv_list_print') {
//					if (isset($_GET[$list_name . '_style'])) {
//							$PRODUCTS_INI['where'] = 'style=\'' . $_GET[$list_name . '_style'] . '\'';
//							$print_url_add = '&' . $list_name . '_style=' . $_GET[$list_name . '_style'];
//					}
//					
//					$PRODUCTS_INI['limit'] = 1000;
//					$PRODUCTS_INI['struct'] = 0;
//					$PRODUCTS_INI['form'] = 0;
//				}					
//				
//				list_ini($PRODUCTS_INI);
//
//				$inv_html .= list_parse($PRODUCTS_INI);
//				
//				if($mode == 'inv_list_print') {
//					$inv_html = t_remove_empty($inv_html);
//					
//					require_once(SCORPIO_CLASSES_PATH . 'pdf/html2pdf.class.php');
//					$PDF = new HTML2PDF('P','LETTER','fr');
//					$PDF->WriteHTML($inv_html, 1);					
//				}
//				
//				$inv_html .= url('PRINT', '?p=prod_items&m=inv_list_print' . $print_url_add);
//				
//				$inv_html .= list_nav($PRODUCTS_INI);
//				
//				$return = $inv_html;
				
				$return .= $html;
			break;		
	
			case "tosea_switch":
				$query 		= 'SELECT * FROM prod_products WHERE id=' . $_GET['item_id'];
				$PRODUCTS 	= $DB->select($query);

				foreach ($PRODUCTS['ROWS'] as $key => $PRODUCT ) {
					foreach ($PRODUCT as $col => $value) {
						if (strstr($col, 'inprod_')) {
							$INPROD[$col] = 0;
							$ONSEA[str_replace('inprod_', 'onsea_', $col)] = $PRODUCT[str_replace('inprod_', 'onsea_', $col)] + $value;
						}					
					}	
				}
				
				$DB->update('prod_products', $_GET['item_id'], $INPROD);
				$DB->update('prod_products', $_GET['item_id'], $ONSEA);
				
				goto($_SERVER['HTTP_REFERER']);

			break;	
	
			case "tostock_switch":
				$query 		= 'SELECT * FROM prod_products WHERE id=' . $_GET['item_id'];
				$PRODUCTS 	= $DB->select($query);

				foreach ($PRODUCTS['ROWS'] as $key => $PRODUCT ) {
					foreach ($PRODUCT as $col => $value) {
						if (strstr($col, 'onsea_')) {
							$ONSEA[$col] = 0;
							$INSTOCK[str_replace('onsea_', 'instock_', $col)] = $PRODUCT[str_replace('onsea_', 'instock_', $col)] + $value;
						}					
					}	
				}
				
				$DB->update('prod_products', $_GET['item_id'], $INSTOCK);
				$DB->update('prod_products', $_GET['item_id'], $ONSEA);
				
				goto($_SERVER['HTTP_REFERER']);

			break;	
		
			case "add":

				
			break;		

			case "edit":
				
			break;

			case "account_edit":
			break;	
			
			case 'rep_stock_excel':
				$date = time();
			
				$select = 'SELECT *'
						. ' FROM `prod_products`'
						. ' ORDER BY name ASC '; 

				$ROWS = $DB->select($select,2);		
	
				$data = arraytotable($ROWS, array('headers' => true, 'EXCEP' => array('pid', 'order', 'html', 'cdate', 'mdate', 'quantite', 'allowed', 'owner'), 'RENAME' => array('grandeur' => 'size')));

				header("Content-type: application/x-msexcel");
				header("Content-Disposition: attachment; filename=rep_stock_$date.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				print $data; 
				
				exit; 

			break;		
			
			case 'rep_sales_excel':
				$date = time();
			
				$select = 'SELECT t3.name as username, FROM_UNIXTIME(t1.CDATE) as cdate, t1.document_id, t1.shipping, t2.name, t2.product_id, t2.product_price, t2.shipping, t2.size_xxs, t2.size_xs, t2.size_s, t2.size_m, t2.size_l, t2.size_xl, t2.size_xxl, t2.size_1, t2.size_3, t2.size_5, t2.size_7, t2.size_9, t2.size_11, t2.size_13, t2.size_15, t2.size_17, t2.size_19, (t2.size_xxs + t2.size_xs + t2.size_s + t2.size_m + t2.size_l + t2.size_xl + t2.size_xxl + t2.size_1 + t2.size_3 + t2.size_5 + t2.size_7 + t2.size_9 + t2.size_11 + t2.size_13 + t2.size_15 + t2.size_17 + t2.size_19) as qty_total, ((t2.size_xxs + t2.size_xs + t2.size_s + t2.size_m + t2.size_l + t2.size_xl + t2.size_xxl + t2.size_1 + t2.size_3 + t2.size_5 + t2.size_7 + t2.size_9 + t2.size_11 + t2.size_13 + t2.size_15 + t2.size_17 + t2.size_19) * product_price) as cash_total'
						. ' FROM `prod_documents` as t1, `prod_details` as t2, `users` as t3'
						. ' WHERE t2.document_id = t1.id AND t1.pid = \'|4326|\' AND t3.id = t1.user_id'
						. ' ORDER BY t2.name ASC  '; 	
						
				$ROWS = $DB->select($select,2);		
					
				$data = arraytotable($ROWS, array('headers' => true));

				header("Content-type: application/x-msexcel");
				header("Content-Disposition: attachment; filename=rep_sales_$date.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				print $data; 
				
				exit;

			break;		

			case "rep_sales":
				$DETAILS 	= db_select('prod_details');
				$USERS 		= db_select('users');
				$DOCS 		= db_select('prod_documents');
				$PRODUCTS	= db_select('prod_products');	
		
				$DOCS_DATA	= $DOCS['DATA'];
				$PROD_DATA  = $PRODUCTS['DATA'];
				$USERS_DATA = $USERS['DATA'];
		//e($USERS_DATA);
				$SIZES = array('xxs','xs','s','m','l','xl','xxl','1','3','5','7','9','11','13','15','17','19');
				
				$ITEMS_STATS['OVERALL'] = '';
			
				foreach ($DETAILS['DATA'] as $detail_id => $DETAIL) {
					$item_name 		= $DETAIL['name'];
					$user_id		= $DOCS_DATA[$DETAIL['document_id']]['user_id'];
					$user_name      = $USERS_DATA[$user_id]['name'];
					$document_id	= $DETAIL['document_id'];
					$price			= $DETAIL['product_price'];
					$style			= $PROD_DATA[$DETAIL['product_id']]['style'];
					$color			= $PROD_DATA[$DETAIL['product_id']]['color'];
					
			
					$ITEMS[$item_name][] = $DETAIL;
					
					$ITEMS_STATS[$item_name]['name'] = $item_name;
					
					foreach($SIZES as $size) {
						$units = $DETAIL['size_' . $size];
						
						$ITEMS_STATS[$item_name]['total_unit_' . $size] += $units;
						$ITEMS_STATS[$item_name]['total_cash_' . $size] += $units * $price;
						
						$ITEMS_STATS[$item_name]['total_unit_sold'] += $units;
						$ITEMS_STATS[$item_name]['total_cash_sold'] += $units * $price;
						
						$ITEMS_STATS['OVERALL']['unit_sold'] += $units;
						$ITEMS_STATS['OVERALL']['cash_sold'] += $units * $price;

						$ITEMS_STATS['OVERALL']['BY_STYLES'][$style]['unit'] += $units;
						$ITEMS_STATS['OVERALL']['BY_STYLES'][$style]['cash'] += $units * $price;
						$ITEMS_STATS['OVERALL']['BY_STYLES'][$style][$color]['unit'] += $units;
						$ITEMS_STATS['OVERALL']['BY_STYLES'][$style][$color]['cash'] += $units * $price;								

						$ITEMS_STATS['OVERALL']['BY_SIZES']['size_' . $size][$style]['unit'] += $units;
						$ITEMS_STATS['OVERALL']['BY_SIZES']['size_' . $size][$style]['cash'] += $units * $price;
						$ITEMS_STATS['OVERALL']['BY_SIZES']['size_' . $size][$style][$color]['unit'] += $units;
						$ITEMS_STATS['OVERALL']['BY_SIZES']['size_' . $size][$style][$color]['cash'] += $units * $price;						
						
						$ITEMS_STATS['OVERALL']['BY_CUSTOMERS'][$user_id]['name'] = $user_name;
						$ITEMS_STATS['OVERALL']['BY_CUSTOMERS'][$user_id]['unit'] += $units;
						$ITEMS_STATS['OVERALL']['BY_CUSTOMERS'][$user_id]['cash'] += $units * $price;						
						
						
						
					}
								
					$ITEMS_STATS[$item_name]['total_invoicetouched'] += 1;
					$ITEMS_STATS[$item_name]['INVOICES_TOUCHED'][] = $document_id; 
					$ITEMS_STATS[$item_name]['CUSTOMERS_TOUCHED'][] = $user_id; 
									
				}		
				
				e($ITEMS_STATS, 1);
			
//				$SALES_TOT = new items(array('list' =>'repsalesbydoc', 'root' =>'', 'index_key' => 'cdate', 'select' => '*,t1.id, t2.name as item_name, t2.document_id, SUM(product_price), SUM(size_xxl) as size_xxl, SUM(size_xl) as size_xl, SUM(size_l) as size_l, SUM(size_m) as size_m, SUM(size_s) as size_s, SUM(size_xs) as size_xs, SUM(size_xxs) as size_xxs, SUM(size_1), SUM(size_3), SUM(size_5), SUM(size_7), SUM(size_11), SUM(size_13), SUM(size_15), SUM(size_17), SUM(size_19), t3.name, t1.cdate
//','from' => '`prod_documents` as t1, `prod_details` as t2,  `users` as t3 ', 'where' => 't1.document_id = t2.document_id AND t1.user_id = t3.id', 'limit' => 50, 'group' => 'item_name, user_id, t1.document_id WITH ROLLUP'));
//				$SALES_TOT->parse();
//				
////e($SALES_TOT->RESULTS['INI']['cc_total']);				
//e($SALES_TOT->RESULTS);
//				$return .= $SALES_TOT->html;
			break;				
			
			default:			
			case "list":		  
				$list_name 	= "products";
				$root		= 3776;
				
				if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
		
				$PRODUCTS_INI = array(	'list' 		=> $list_name,
					 					'root' 		=> $list_root,
										'page' 		=> "prod_items",
										'table' 	=> "prod_products",
										'rs_name' 	=> "cataloglist",
										//'ci_name' 	=> "userslist", 
										'template'	=> "products", 
										//'sys'		=> 1,
										//'item_id' 	=> $edit_id,
										'limit' 	=> 200,
										//'mode' 		=> "list",
										'mod'		=> "mod_products",
										'add'		=> 'true',
										'show_all'		=> 'true',  
										'order'		=> 'name',
										//'edit'		=> 1,
										//'form_url'	=> "?p=account&account_sendconf=1",
									  );
								
				if (isset($_GET['products_prod_products_edit'])) {$PRODUCTS_INI['item_id'] = $_GET['products_prod_products_edit'];}								
									
				list_ini($PRODUCTS_INI);
				
				$return .= list_parse($PRODUCTS_INI);
				
				$return .= list_nav($PRODUCTS_INI);
		}
	//}
	
?>