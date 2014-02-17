<?php 

	global $CORE;
	
//	$DB = new db();
//
//	$this_page  = 'products';
//	$list_name 	= 'products';
//	$user_id	= $CORE['USER']['id'];
	
	$html .= '<strong>Documents</strong> : ' . BR;
	$html .= HS . HS . url('Ajouter','?p=prod_documents&documents_prod_documents_new=true&new_cat_id=4324') . ' ou ' . url('convertir un document du panier ','?p=prod_documents&documents_cat_id=4324') . BR ;
	$html .= HS . HS . 'Voir : ' 
		   . url('Tout','?p=prod_documents') . ' | ' 
		   . url('Soumissions','?p=prod_documents&documents_cat_id=4323') . ' | ' 
		   . url('Commandes ','?p=prod_documents&documents_cat_id=4573') . ' | ' 
		   . url('Booking ','?p=prod_documents&documents_cat_id=4325') . ' | ' 
		   . url('Factures ','?p=prod_documents&documents_cat_id=4326') . ' | ' 
		   . url('N.C.','?p=prod_documents&documents_cat_id=4576') . ' | ' 
		   . url('B.O. ','?p=prod_documents&documents_cat_id=4338') . ' | '
		   . url('Ajust. ','?p=prod_documents&documents_cat_id=4327') . BR . BR; 	

	$html .= '<strong>Produits</strong> : ' . BR;
	$html .= HS . HS . url('Tout','?p=prod_items') . ' | ' . url('Inventaire','?p=prod_items&m=inv_list') . BR . BR;
	
	$html .= '<strong>Clients</strong> : ' . BR;
	$html .= HS . HS . url('Tout','?p=admin_customers') . BR;	
	
//	$html .= url('Soumissions','?p=prod_documents&documents_cat_id=4323') . ' | ' 
//		   . url('Commandes ','?p=prod_documents&documents_cat_id=4324') . ' | ' 
//		   . url('Booking ','?p=prod_documents&documents_cat_id=4325') . ' | ' 
//		   . url('Factures ','?p=prod_documents&documents_cat_id=4326') . ' | ' 
//		   . url('B.O. ','?p=prod_documents&documents_cat_id=4338') . ' | '
//		   . url('Ajustements ','?p=prod_documents&documents_cat_id=4327') . BR; 	
	
	$return = $html;
	
?>