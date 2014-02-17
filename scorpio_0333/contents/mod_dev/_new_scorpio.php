<?php 

/// INI
	global $SCORPIO;
	global $CORE;

	//include_once(SCORPIO_TYPES_PATH . 'new_checkout.php');
	
//	$SCORPIO->load_tables();
//
//
//	$return .= '<a href="?p=new_scorpio&structsparent_id=1">root</a><br />';

/// MEGA SUPER REL TREE
//	$listname = 'structsparent';
//	$PARENT = new items($listname);
//	$PARENT->ci_load(2);
//	$PARENT->co_load(5);
//	$PARENT->select();
//	
//	if (isset($_GET[$listname . '_cid'])) {$cid = $_GET[$listname . '_cid'];} else {$cid = 1;} //** to items
//
//	$PARENT->tree2($cid,501); //** to items
//	$return .= $PARENT->parse();
	
/// MEGA SUPER REL TREE
//	$listname = 'structs';
//	$ITEMS = new items($listname);
//	$ITEMS->ci_load(2);
//	$ITEMS->co_load(4);
//	$ITEMS->select();
//
//	if (isset($_GET[$listname . '_cid'])) {$cid = $_GET[$listname . '_cid'];} else {$cid = 1;} //** to items
//
//	$ITEMS->tree2($cid,501); //** to items
//	
//	$return .= $ITEMS->parse();

/// INSERT
//	$ITEMS_INI = array('name' => 'TESTEST');	// add table rel
	//$ITEMS->insert($ITEMS_INI,$INI);

//
//	$RELATION = new items();
//	$RELATION->seed_load(1);
//e($RELATION->SEED);
//	$REL_INI = array('cid' => 66666, 'cdate' => time());	// add table rel
//	$RELATION->insert($REL_INI,$INI);
	
	
	
	//$INSERT = array('title_fr' => $_POST['title_fr']);
	//$INI 	= array('ctb' => $_POST['ctb'], 'pid' => $_POST['pid'], 'ptb' => $_POST['ptb']);
	

	//e($INSERT);



/// NEW ITEMS EXAMPLE
	//$INI 	= array('items_table' => "sys_structures", 'relations' => true);	
//	$ITEMS 	= new items();	
	
/// NEW FORM (VA REMPLACER CA PAR MON AUTO ITEM FORM from rs new ou edit)
//	$table 	= "";
//	
//	foreach ($TABLES as $key => $tvalue) {
//		$table .= "<option value=\"$key\">$tvalue</option>";
//	}
//	
//	$table .= "</select>";
//	
//	$table_ctb = "<select name=\"ctb\">" . $table;
//	$table_ptb = "<select name=\"ptb\">" . $table;
//	
//	$return .= "
//		<form action=\"?p=new_scorpio\" method=\"post\" name=\"items_add\" id=\"items_add\">
//			cib <input name=\"cib\" type=\"text\" id=\"cib\" /><br />
//			ctb $table_ctb <br />
//			pid <input name=\"pid\" type=\"text\" id=\"pid\" /><br />
//			ptb $table_ptb <br /> <br />
//			title_fr <input name=\"title_fr\" type=\"text\" id=\"title_fr\" /><br />
//			<input name=\"b_items_add\" type=\"submit\" value=\"ajouter\" />
//		</form>";
//
//	if (isset($_POST['b_items_add'])) {
//	/// INSERT EXAMPLE	
//		$INSERT = array('title_fr' => $_POST['title_fr']);
//		$INI 	= array('ctb' => $_POST['ctb'], 'pid' => $_POST['pid'], 'ptb' => $_POST['ptb']);	
//		
//		$return .= $ITEMS->insert($INSERT,$INI);
//		
//		header("Location:?p=new_scorpio");
//	}

	
/// LIST FROM SEED
	$return .= "<br / >--- NEWS CAT LIST ---<br / >";

	//$NEWS_CAT_LIST = new items();	 
	//$NEWS_CAT_LIST->co_load(3);
	//$NEWS_CAT_LIST->select();

	//$return .= $NEWS_CAT_LIST->parse();

	$return .= "<br / >--- NEWS CAT ZOOM ---<br / >";

	//$NEWS_CAT = new items();	 
	//$NEWS_CAT->co_load(2);
	//$NEWS_CAT->select();

	//$return .= $NEWS_CAT->parse();

	$return .= "<br / >--- NEWS LIST ---<br / >";
 
	//$NEWS = new items($NEWS_INI);	 
	//$NEWS->co_load(1);
	//$NEWS->select();
	
	//$return .= $NEWS->parse();	
	

	//e($NEWS->DATA);

 // get rs
 	//$RSS 		= new items();
	//$RSS_LIST_INI = array('ctb' => 3, 'pid' => 4,'ptb' => 3,); 
	//$RSS->select($RSS_LIST_INI);

	//e($RSS->DATA);

//		$return .= "<br / >--- CHILDS ---<br / >";
//		$NEWS_LIST_INI = array(	//'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//								//'ctb' 		=> 3, 
//								'pid' 		=> $_POST['pid'], 
//								'ptb' 		=> $_POST['ptb'], 
//								'parent' 	=> true,
//								'relations' => true, 
//								'items' 	=> true, 
//								);
//		
//		$NEWS->select($NEWS_LIST_INI);
//		$return .= $NEWS->parse();	



 // get tables
//	$select_end .= "<option value=\"\">&nbsp;</option>";
//	foreach ($TABLES as $key => $tvalue) {
//		$select_end .= "<option value=\"$key\">$tvalue</option>";
//	}
//	
//	$select_end .= "</select>" . BR;
//
//	$return .= "From table : <select id=\"ctb_name\" onChange=\"set_ini('ctb',this.value); live_items('items_list')\">" . $select_end;
//	$return .= "Parent table : <select id=\"ptb_name\" onChange=\"set_ini('ptb',this.value); live_items('items_list'); live_options('pid_name')\">" . $select_end;
//	$return .= "Parent id : <select id=\"pid_name\" onChange=\"set_ini('pid',this.value); live_items('items_list')\">" . $select_end;
//
//	$return .= "<div id=\"items_list\">icitte que ca va</div>";
//	$return .= "<div id=\"items_test\">test</div>";






///// SELECT EXAMPLE LIST CHILDS (genre les categories) le parent va donner la categore parent
//	$TABLES = $CORE['TABLES'];
//	
//	$table = "";
//	
//	foreach ($TABLES as $key => $tvalue) {
//		$table .= "<option value=\"$key\">$tvalue</option>";
//	}
//	
//	$table .= "</select>";
//	
//	$table_ctb = "<select name=\"ctb\">" . $table;
//	$table_ptb = "<select name=\"ptb\">" . $table;
//
//	$return .= "
//		<form action=\"?p=new_scorpio\" method=\"post\" name=\"items_select\" id=\"items_select\">
//			cib <input name=\"cib\" type=\"text\" id=\"cib\" /><br />
//			ctb $table_ctb <br />
//			pid <input name=\"pid\" type=\"text\" id=\"pid\" value=\"" . $_POST['pid'] . "\" /><br />
//			ptb $table_ptb <br /> <br />
//			<input name=\"b_items_select\" type=\"submit\" value=\"select\" /><br />
//		</form>";
//
//	$return .= "<input name=\"b_items_select\" type=\"submit\" value=\"fetch\" onMouseUp=\"live_items('index.php?p=live_select&live_ctb=10&live_pid=3&live_ptb=5','criss')\" />";
//	$return .= "<div id=\"criss\">icitte que ca va</div>";
//
//	if (isset($_POST['b_items_select'])) {
//		$return .= "<br / >--- CHILDS ---<br / >";
//		$NEWS_LIST_INI = array(	//'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//								//'ctb' 		=> 3, 
//								'pid' 		=> $_POST['pid'], 
//								'ptb' 		=> $_POST['ptb'], 
//								'parent' 	=> true,
//								'relations' => true, 
//								'items' 	=> true, 
//								);
//		
//		$NEWS->select($NEWS_LIST_INI);
//		$return .= $NEWS->parse();	
//	}
	
///// SELECT EXAMPLE LIST CHILDS (genre les categories) le parent va donner la categore parent
//	$return .= "<br / >--- CHILDS ---<br / >";
//	$NEWS_LIST_INI = array(	//'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//							//'ctb' 		=> 3, 
//							'pid' 		=> 10, 
//							'ptb' 		=> 1, 
//							'parent' 	=> true,
//							'relations' => true, 
//							'items' 	=> true, 
//							);
//	
//	//$NEWS->select($NEWS_LIST_INI);
//	//$return .= $NEWS->parse();	
	
	



///// DELETE EXAMPLE	
//	$INI 	= array('cid' => 33, 'ctb' => 3);	
//	
//	//$return .= $ITEMS->delete($INI);
//
//
///// SELECT EXAMPLE ZOOM (genre un item) le parent va donner la categore parent
//	$return .= "<br / >--- ZOOM ---<br / >";
//	//$INI = array('rel_from' => array('cid','ctb','pid','ptb'), 'relations' => true, 'cid' => 2, 'ctb' => 3);
//
//	$INI = array(	//'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//					'cid' 		=> 2,
//					'ctb' 		=> 3, 
//					'pid' 		=> 1, 
//					'ptb' 		=> 3, 
//					'parent' 	=> true,
//					'relations' => true, 
//					'items' 	=> true, 
//					);
//	
//	$ITEMS->select($INI);
//	$return .= $ITEMS->parse();	
//	
//
///// SELECT EXAMPLE LIST CHILDS (genre les categories) le parent va donner la categore parent
//	$return .= "<br / >--- CHILDS ---<br / >";
//	$INI = array(	'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//					//'ctb' 		=> 3, 
//					'pid' 		=> 1, 
//					'ptb' 		=> 3, 
//					'parent' 	=> true,
//					'relations' => true, 
//					'items' 	=> true, 
//					);
//	
//	//$ITEMS->select($INI);
//	//$return .= $ITEMS->parse();	
//
//
///// SELECT EXAMPLE LIST CHILDS (genre les categories) le parent va donner la categore parent
//	$return .= "<br / >--- TREE ---<br / >";
//	$INI = array(	//'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//					'ctb' 		=> 3, 
//					//'pid' 		=> 1, 
//					'ptb' 		=> 3, 
//					'parent' 	=> true,
//					'relations' => true, 
//					'items' 	=> true, 
//					);
//	
//	$ITEMS->select($INI);
//	$ITEMS->tree();	
//	
//	//e($ITEMS->TREE);
//
//
///// SELECT EXAMPLE LIST CHILDS (genre les categories) le parent va donner la categore parent
//	$return .= "<br / >--- RUN ---<br / >";
//	$INI = array(	//'rel_from' 	=> array('cid','ctb','pid','ptb'), 
//					'cid_start' 	=> 2, 
//					'ctb_start' 	=> 3,
//					);
//						
//	$return .= $ITEMS->run($INI);
//
//	
///// SELECT EXAMPLE LIST TABLE
//	$return .= "<br / >--- TABLE CHILDS ---<br / >";
//	$INI = array('items_table' => "sys_structures", 'rel_from' => array('cid','ctb','pid','ptb'), 'relations' => true, 'ptb' => 3);
//	
//	//$ITEMS->select($INI);
//	//$return .= $ITEMS->parse();	
//
///// SELECT EXAMPLE LIST ALL ITEMS EVERYWHERE
//	$return .= "<br / >--- ALL ---<br / >";
//	$INI = array('items_table' => "sys_structures", 'rel_from' => array('cid','ctb','pid','ptb'), 'items_from' => array('id','title_fr'), 'relations' => true);
//	
//	//$ITEMS->select($INI);
//	//$return .= $ITEMS->parse();		
	





	

	

?>