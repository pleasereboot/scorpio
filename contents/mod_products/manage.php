<?php 

	global $CORE;
	
//	$DB = new db();
//
//	$this_page  = 'products';
//	$list_name 	= 'products';
//	$user_id	= $CORE['USER']['id'];
	
	$html .= '<strong>Documents</strong> : ' . BR;
	$html .= HS . HS . url('Add','?p=prod_documents&documents_prod_documents_new=true&new_cat_id=4032') . ' or ' . url('convert document from basket ','?p=prod_documents&type=1') . BR ;
	$html .= HS . HS . 'View : ' 
		   . url('All','?p=prod_documents') . ' | ' 
		   . url('Quotes','?p=prod_documents&type=2') . ' | ' 
		   . url('Orders ','?p=prod_documents&type=3') . ' | ' 
		   . url('B.O. ','?p=prod_documents&type=4') . ' | '
		   . url('Book ','?p=prod_documents&type=5') . ' | ' 
		   . url('Inv. (O) ','?p=prod_documents&type=6') . ' | '
		   . url('Inv. (C) ','?p=prod_documents&type=7') . ' | '
		   . url('Adjust. ','?p=prod_documents&type=8') . ' | ' 
		   . url('C.N.','?p=prod_documents&type=9') . ' | ' 
		   . url('D.N.','?p=prod_documents&type=10') . BR . BR; 



	$PRODUCTS	= db_select('prod_products', array('order' => 'style'));
	$PROD_DATA  = $PRODUCTS['DATA'];



	foreach ($PROD_DATA as $DATA) {
		$SELECT_LIST[$DATA['id']]['style'] = $DATA['style'];
	}

	$select_html = select_build($SELECT_LIST, 'inv_style', 'style', 'style', 'invreport_style', $selected=false, $blank=false, $multiple=false);
	
	$form_html  = " | <form action=\"index.php\" method=\"get\" name=\"genre\">$select_html<input name=\"p\" type=\"hidden\" value=\"prod_items\" /><input name=\"m\" type=\"hidden\" value=\"inv_list\" /><input name=\"b_style\" type=\"submit\" value=\"select\" /></form>";



	$html .= '<strong>Products</strong> : ' . BR;
	$html .= HS . HS . url('All','?p=prod_items') . ' | ' . url('Inventaire','?p=prod_items&m=inv_list') . ' ' . url('(full)','?p=prod_items&m=inv_list_full') . $form_html . BR;
	
	$html .= '<strong>Customers</strong> : ' . BR;
	$html .= HS . HS . url('All','?p=admin_customers') . BR . BR;

	$html .= '<strong>Reports</strong> : ' . BR;
	$html .= HS . HS . url('stock (excel)','?p=prod_items&m=rep_stock_excel') . ' | ' . url('sales (excel)','?p=prod_items&m=rep_sales_excel') . BR . BR;
	

	
	$return = $html;
	
?>