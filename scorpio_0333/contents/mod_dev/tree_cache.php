<?php 


	
	//set_tree_cache();
	get_tree_cache();
	
	//e($GENRE);
	
	$SUB_PAR = array("root" => 2, "level" => 2, "allowed" => true, "status" => true);
	
	$STYLE = tree_sub($SUB_PAR);
	
	e($STYLE);
	
?>