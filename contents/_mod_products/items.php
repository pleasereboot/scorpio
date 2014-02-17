<?php 

	global $CORE;
	
	$DB = new db();

	$this_page  = 'products';
	$list_name 	= 'products';
	$user_id	= $CORE['USER']['id'];

	//$GET = listen($list_name);
//e($GET[0],1);
	$mode = $_GET['m'];
	
	//$return .= url('Liste des items','?p=' . $this_page . '&m=items_list');
	//$return .= ' | ' . url('Voir les factures','?p=' . $this_page . '&m=invoices_list');	
	
		switch($mode){
			case "inv_list":
				$list_name 	= "invreport";
				$root		= 3776;
				
				if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = $root;}			
		
				$PRODUCTS_INI = array(	'list' 		=> $list_name,
					 					//'root' 		=> $list_root,
										'page' 		=> "prod_items",
										'table' 	=> "prod_products",
										'rs_name' 	=> "invreport",
										//'ci_name' 	=> "userslist", 
										'template'	=> "inv_report",
										//'sys'		=> 1,
										//'item_id' 	=> $edit_id,
										'mode' 		=> "list",
										'mod'		=> "mod_products",
										'add'		=> "false",
										'limit'		=> 10,
										//'edit'		=> 1,
										//'form_url'	=> "?p=account&account_sendconf=1",
									  );
									
				list_ini($PRODUCTS_INI);
			//e($LIST[$list_name]);	
				$return .= list_parse($PRODUCTS_INI);
				
				$return .= list_nav($PRODUCTS_INI);	
				
			break;		
		
			case "add":

				
			break;		

			case "edit":
				
			break;

			case "account_edit":
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
										'mode' 		=> "list",
										'mod'		=> "mod_products",
										'add'		=> 'true',
										'show_all'		=> 'true',  
										//'edit'		=> 1,
										//'form_url'	=> "?p=account&account_sendconf=1",
									  );
									
				list_ini($PRODUCTS_INI);
				
				$return .= list_parse($PRODUCTS_INI);
				
				$return .= list_nav($PRODUCTS_INI);
		}
	//}
	
?>