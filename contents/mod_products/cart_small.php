<?php 

	global $CORE;
	global $LIST;
	

//	include('contents/mod_products/class_docs.php');	
//	
	$DB = new db();
//
//	$this_page  = 'products';
//	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];
//
	$query = "SELECT * FROM prod_documents WHERE `user_id` = $user_id AND `type` = 12";	
	
	$RESULTS = $DB->select($query,3);
	
	$doc_id	= $RESULTS['id'];
	
	if($doc_id) {
		// FILL DETAILS 	
		$query 		= "SELECT * FROM prod_details WHERE document_id = $doc_id ORDER BY cdate";
				
		$DETAILS 	= $DB->select($query);
	
		foreach ($DETAILS['ROWS'] as $detail_id => $DETAIL) {
			$detail_name = $DETAIL['name'];
			$detail_qty = '';
			
			foreach ($LIST['sizes']['DATA'] as $size) {
				$detail_qty += $DETAIL['size_' . strtolower($size)];
				
			} 
			
			$detail_total = piasses($detail_qty * $DETAIL['product_price']);
			
			$total_qty += $detail_qty;
			$total_cost += $detail_qty * $DETAIL['product_price'];
			
			$td_html = td($detail_qty . ' x' . HS, array('align' => 'right')) . td(b($detail_name)) . td($detail_total, array('align' => 'right'));
			$tr_html .= tr($td_html);
		}
	
		$total_html = tr(td(table(tr(td(BR . b($total_qty) . ' items', array('align' => 'left')) . td(BR . 's-total = ' . b(piasses($total_cost)), array('align' => 'right'))), array('width' => '100%')), array('colspan' => 3)));
		$action_html = tr(td(url(lang_arr(array('voir le panier', 'view cart')), '?p=cart'), array('align' => 'right', 'colspan' => 3)));
	
	
		$html .= table($tr_html . $total_html . $action_html, array('width' => '100%') );
	} else {
		$html .= lang_arr(array('panier vide', 'empty cart')); 
	}


	$return .= $html;

?>