<?php 

/// INI
	global $SCORPIO;
	//global $LIST;
	
	$SCORPIO->ini_classes(array('list'));
	$SLIST = new slist("groups_items");
	
	//$SLIST->set_ini(array("table" => "contents","limit" => 10, "parent" => 1676));
	$SLIST->set_ini("select","`label_fr`");
	$SLIST->query_get();

	e($SLIST->INI);	
	$SLIST->query();
	
/// PARSE
	$return = $SLIST->parse();
	//$return .= $SLIST->show_ini();
	

?>