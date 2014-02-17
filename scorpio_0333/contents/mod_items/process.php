<?php 

/// INI
	global $SCORPIO;
	global $CORE;
	
	$SCORPIO->load_tables();
	
	//$NEWS_INI 	= array('items_table' => "sys_news", 'relations' => true);	
	$NEWS 		= new items($NEWS_INI);		

	/// INSERT	
		$INSERT = array('title_fr' => $_POST['title_fr']);
		$INI 	= array('ctb' => $_POST['ctb'], 'pid' => $_POST['pid'], 'ptb' => $_POST['ptb']);	
		
		//$return .= $ITEMS->insert($INSERT,$INI);
		
		//header("Location:?p=new_scorpio");

	$return .= "sti";

?>