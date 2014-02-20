<?php 

	global $SCORPIO;
	global $CORE;
	
	$SCORPIO->load_tables();

	$NEWS_INI 	= array('seeds' => 1,'rs' => 1, 'relations' => true);	
	$NEWS 		= new items($NEWS_INI);

	if ($_GET['live_ctb'] != 'undefined') {$live_ctb = $_GET['live_ctb'];}
	if ($_GET['live_pid'] != 'undefined') {$live_pid = $_GET['live_pid'];}
	if ($_GET['live_ptb'] != 'undefined') {$live_ptb = $_GET['live_ptb'];}

	$return .= "<br / >--- CHILDS ---<br / >";
	
	$NEWS_LIST_INI = array(	'rel_from' 		=> array('cid','ctb','pid','ptb'), 
							'items_from' 	=> array('title_fr'),
							'ctb' 			=> $live_ctb, 
							'pid' 			=> $live_pid, 
							'ptb' 			=> $live_ptb, 
							//'parent' 		=> true,
							'relations' 	=> true, 
							'items' 		=> true, 
							);
	
	$NEWS->select($NEWS_LIST_INI);
	$return .= $NEWS->parse();	

//	$NEWS_LIST_INI['rel_from'] = array('cid','ctb','pid','ptb');
//	$NEWS_LIST_INI['items_from'] = array('title_fr');
//	$NEWS_LIST_INI['ctb'] = $live_ctb;
//	$NEWS_LIST_INI['pid'] = $live_pid; 
//	$NEWS_LIST_INI['ptb'] = $live_ptb; 
//	$NEWS_LIST_INI['relations'] = true; 
//	$NEWS_LIST_INI['items'] = true; 	

?>