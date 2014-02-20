<?php 

/// INI
	global $SCORPIO;
	global $CORE;
	
	$SCORPIO->load_tables();
	
	$CONTENT 		= new contents('testlist');		

	$CONTENT->listen();
	$CONTENT->process();
	
//e($CONTENT);
	$return .= "sti";

?>