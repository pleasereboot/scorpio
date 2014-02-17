<?php 

	global $CORE;

	$list_name 	= "pageslist";
	$root		= 236;
	$gen = 2;
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = 0;}
	$DB = new db();
//e($_POST);
/// ADD PAGES FOR GOD AND ADMIN
	if (isset($_POST['b_pageadd_submit'])) {
		if ($_POST['div'] != '') {$class = $_POST['div'];} else {$class = 'main';}
	
		$PAGE_PAR 		= array('type' => 1, 'label_fr' => $_POST['title_fr'], 'label_en' => $_POST['title_en'], 'class' => $class);
		$new_pid			= trim($_POST['parentpage'],"|");
		$new_par			= $_POST['par'];
		
		$new_id = contents_add($new_pid, $_POST['pagename'], $PAGE_PAR);		
		
		switch($_POST['type']){
			case "rte":
				$SUBPAGE_PAR	= array('type' => 77, 'class' => $_POST['subdiv'], 'par' => $_POST['subpar']);
				
				contents_add($new_id, "mod_html", $SUBPAGE_PAR);		
		
				$time				= time();
		
				$NEW['pid'] 			= "|" . 270 . "|";
				$NEW['name']     		= "html_" . $_POST['pagename'];			
				$NEW['cdate'] 		= $time;
				$NEW['mdate'] 		= $time;
				
				$NEW['status'] 		= 1;
				$NEW['allowed'] 		= 1;
				$NEW['owner'] 		= $CORE['USER']['id'];
				$NEW['order'] 			= "1000";
				
				$val_column 			= "`" . implode("`,`", array_keys($NEW)) . "`";
				$val_item 				= "'" . implode("','", array_map('addslashes', array_values($NEW))) . "'";
				
				$query = "INSERT INTO `content_html` ( $val_column ) VALUES ( $val_item);";
				//echo $query."<br>";
				$DB->query($query);	
								
			break;	
			
			case "php":
				$SUBPAGE_PAR	= array('type' => 4, 'par' => $new_par);
				
				contents_add($new_id, "include_php", $SUBPAGE_PAR);					
			break;			  

			case "html":
				$SUBPAGE_PAR	= array('type' => 5, 'par' => $new_par);
				
				contents_add($new_id, "include_html", $SUBPAGE_PAR);					
			break;	
			
			default:
	
			break;		  
		}
		
		if (isset($_POST['returnUrl'])) {
			header("Location:" . $_POST['returnUrl']);
		} else {
			header("Location:?p=admin_pages");
		}
	}

	$html .= div('+ ajouter une page'		. BR . addPageForm(), array('class' => 'MENU_GOD_SWITCH')) . BR ;
	$html .= div( '+ ajouter un html'			. BR . addHtmlForm(), array('class' => 'MENU_GOD_SWITCH')) . BR ;
	$html .= div( '+ ajouter un separateur'	. BR . addSepForm(), array('class' => 'MENU_GOD_SWITCH')) . BR ;	
	
	$list_name = "pageslist";
	
	if (isset($PAR['root'])) {$list_root = $PAR['root'];} else {$list_root = 236;}


	
/// PARENT PAGE PARSE	
	if (isset($_GET['pageslist_cat_id'])) {	
		if (isset($_POST['b_htmladd_submit'])) {
			$unique_id = shuffle_id(8);
		
			if ($_POST['title_content'] == 'yes') {$title_content = '|title_content:true';}
		
			$SUBPAGE_PAR	= array('type' => 77,  'par' => "html:$unique_id$title_content|struct:0|form:0");
			
			if ($_POST['name'] != '') {$name = $_POST['name'];} else {$name = "html_$unique_id";}
			if ($_POST['label_fr'] != '') {$SUBPAGE_PAR['label_fr'] = $_POST['label_fr'];} else {$SUBPAGE_PAR['label_fr'] = "html_$unique_id";}
			if ($_POST['label_en'] != '') {$SUBPAGE_PAR['label_en'] = $_POST['label_en'];} else {$SUBPAGE_PAR['label_en'] = "html_$unique_id";}			
			
			contents_add($_GET['pageslist_cat_id'], $name, $SUBPAGE_PAR);		

			$time						= time();

			$NEW['pid'] 			= "|" . 270 . "|";
			$NEW['name']     		= $name;			
			$NEW['cdate'] 		= $time;
			$NEW['mdate'] 		= $time;
			
			$NEW['html_fr'] 		= "Section en construction ! ($unique_id)";
			$NEW['html_en'] 		= "Section in construction ($unique_id)";			
			
			$NEW['status'] 		= 1;
			$NEW['allowed'] 		= 1;
			$NEW['owner'] 		= $CORE['USER']['id'];
			$NEW['order'] 			= "1000";
			
			$val_column 			= "`" . implode("`,`", array_keys($NEW)) . "`";
			$val_item 				= "'" . implode("','", array_map('addslashes', array_values($NEW))) . "'";
			
			$query = "INSERT INTO `content_html` ( $val_column ) VALUES ( $val_item);";
			//echo $query."<br>";
			$DB->query($query);	

			if (isset($_POST['returnUrl'])) {
				header("Location:" . $_POST['returnUrl']);
			} else {
				header("Location:?p=admin_pages&pageslist_cat_id=" . $_GET['pageslist_cat_id']);
			}			
		}	

		if (isset($_POST['b_sepadd_submit'])) {
			if ($_POST['class'] == 'other') {$class = strtoupper($_POST['class_other']);} else {$class = strtoupper($_POST['class']);}	
		
			$SEP_PAR	= array('type' => 104,  'par' => "class:$class");
			
			contents_add($_GET['pageslist_cat_id'], 'separator', $SEP_PAR);		

			if (isset($_POST['returnUrl'])) {
				header("Location:" . $_POST['returnUrl']);
			} else {
				header("Location:?p=admin_pages&pageslist_cat_id=" . $_GET['pageslist_cat_id']);
			}			
		}	
		
		$PARENT_INI = array(	'list' 			=> "pageslist",
										'rs_name' 	=> $list_name,
										'template'	=> "page_parent",
										'sys'			=> 1, 
										'item_id' 	=> $_GET['pageslist_cat_id'],
										//'mode' 		=> "edit",
										'mod'			=> "mod_admin",
										'add'			=> "false", 
										'edit'			=> 1,
										//'gen'			=> 3, 
									);
									
		$GENRE = list_ini($PARENT_INI); 
		$html .= list_parse($PARENT_INI);
		
	/// SET GEN FOR PAGES ON  ZOOM
		$gen = 5;
	}

	unset($CORE['LIST'][$list_name]);
	
/// LIST INI
	$INI = array(	'list' 			=> $list_name,
						'table' 		=> "contents",
						'limit' 			=> 50,
						'root' 		=> $list_root,
						'gen'			=> $gen, 
						);

	$GENRE = list_ini($INI);	
	
/// CATS NAV	
	$ITEMS_NAV = array(	'list' 			=> $list_name, 
									'template'	=> "contentslist",
									'type' 		=> "cats",
									'sys'			=> 1,
									'page' 		=> "admin_pages",
									'catlist' 		=> $list_name,
									);

	$html .= list_nav($ITEMS_NAV);	

/// CATS PARSE	
	$CATS_INI = array(	'list' 			=> $list_name, 
								'type' 		=> "cats",
								'rs_name' 	=> "layoutslist",
								'template'	=> "contentslist",
								'sys'			=> 1,
								'form'			=> 1,
								'gen'			=> $gen, 
								);

	$html .= list_parse($CATS_INI);	


/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> $list_name
	 					);

	$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>