<?php 

	global $CORE;
	
	$DB = new db();

	$this_page  = 'products';
	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];
	
	
	$html .= 'Documents : ' . url('Liste','?p=prod_documents' . '&m=invoices_list' ) . ' | ' . url('Ajouter','?p=prod_documents' . '&m=invoices_list' ) . ' | ' . url('Modifier','?p=prod_documents' . '&m=invoices_list' ) . BR;
	$html .= 'Items : ' . url('Liste','?p=prod_items' . '&m=list' ) . ' | ' . url('Ajouter','?p=prod_items' . '&m=add' ) . ' | ' . url('Modifier','?p=prod_items' . '&m=edit' ) . BR;
	
	
	
	
	
	
	$return = $html;

	//$GET = listen($list_name);
//e($GET[0],1);
//	$mode = $_GET['m'];
//	
//	$return .= url('Liste des items','?p=' . $this_page . '&m=items_list');
//	$return .= ' | ' . url('Voir les factures','?p=' . $this_page . '&m=invoices_list');	
//	
//		switch($mode){
//			case "invoices_list":
//				$list_name 	= "products";
//				$root		= 3776;
//				
//				if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
//		
//				$PRODUCTS_INI = array(	'list' 		=> $list_name,
//					 					'root' 		=> $list_root,
//										'page' 		=> "album",
//										'table' 	=> "prod_products",
//										'rs_name' 	=> "products_cats",
//										//'ci_name' 	=> "userslist", 
//										'template'	=> "products",
//										//'sys'		=> 1,
//										//'item_id' 	=> $edit_id,
//										'mode' 		=> "list",
//										'mod'		=> "mod_products",
//										'add'		=> "false",
//										//'edit'		=> 1,
//										//'form_url'	=> "?p=account&account_sendconf=1",
//									  );
//									
//				list_ini($PRODUCTS_INI);
//				
//				$return .= list_parse($PRODUCTS_INI);	
//				
//			break;		
//		
//			case "items_list":
//				$list_name 	= "products";
//				$root		= 3776;
//				
//				
//				
//				if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
//		
//				$PRODUCTS_INI = array(	'list' 		=> $list_name,
//					 					'root' 		=> $list_root,
//										'page' 		=> "album",
//										'table' 	=> "prod_products",
//										'rs_name' 	=> "products_cats",
//										//'ci_name' 	=> "userslist", 
//										'template'	=> "products",
//										//'sys'		=> 1,
//										//'item_id' 	=> $edit_id,
//										'mode' 		=> "list",
//										'mod'		=> "mod_products",
//										'add'		=> "false",
//										//'edit'		=> 1,
//										//'form_url'	=> "?p=account&account_sendconf=1",
//									  );
//									
//				list_ini($PRODUCTS_INI);
//				
//				$return .= list_parse($PRODUCTS_INI);
//				
//			break;		
//
//			case "account_sendconf":
//				
//			break;
//
//			case "account_confirm":
//				
//			break;
//
//			case "account_edit":
//			break;			  
//			default:
//			/// SPLASH CATS
//				$list_name 	= "products";
//				$root		= 3776;
//				
//				if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
//		
//				$return .= 'genre';
//		
//				$PRODUCTS_INI = array(	'list' 		=> $list_name,
//					 					'root' 		=> $list_root,
//										'page' 		=> "album",
//										'table' 	=> "prod_products",
//										'rs_name' 	=> "products",
//										//'ci_name' 	=> "userslist", 
//										'template'	=> "products",
//										'type'		=> 'cats',
//										//'item_id' 	=> $edit_id,
//										'mode' 		=> "list",
//										'mod'		=> "mod_products",
//										'add'		=> "false",
//										//'edit'		=> 1,
//										//'form_url'	=> "?p=account&account_sendconf=1",
//									  );
//									
//				list_ini($PRODUCTS_INI);
//				
//				
//				$return .= list_parse($PRODUCTS_INI);		
//			
//		}
	//}
	
?>