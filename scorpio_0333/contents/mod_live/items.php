<?php 

	global $SCORPIO;
	global $CORE;
	
	$SCORPIO->load_tables();

	$RSS 		= new items();	

	if ($_GET['live_ctb'] != 'undefined') {$live_ctb = $_GET['live_ctb'];}
	if ($_GET['live_pid'] != 'undefined') {$live_pid = $_GET['live_pid'];}
	if ($_GET['live_ptb'] != 'undefined') {$live_ptb = $_GET['live_ptb'];}

	$RSS_LIST_INI = array(	//'rel_from' 		=> array('cid','ctb','pid','ptb'), 
							//'items_from' 	=> array('title_fr'),
							'ctb' 			=> $live_ptb, 
							//'pid' 			=> $live_pid, 
							//'ptb' 			=> $live_ptb, 
							//'parent' 		=> false,
							//'relations' 	=> true, 
							//'items' 		=> true, 
							);

	$RSS->select($RSS_LIST_INI);

	$select_end .= "<option value=\"\">&nbsp;</option>";

	foreach ($RSS->DATA as $key => $GENRE) {
		$select_end .= "<option value=\"" . $GENRE['id'] . "\">" . $GENRE['title_fr'] . "</option>";
	}
	
	$return .= $select_end;
	//e($RSS->DATA);
?>