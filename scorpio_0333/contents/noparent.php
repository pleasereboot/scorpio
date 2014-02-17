<?php 

	global $CORE;
	global $LIST;
	
	$DB = new db();
	
	$pid_new 	= data_switch("contents", "noparent");

/// REMOVE ROWS IF GET ACTION==REMOVE	
	if ($CORE['GET']['action'] == remove && is_allowed(6)) {
		unset($CORE['GET']['action']);
		
		$query = "DELETE FROM `contents` WHERE `pid` ='|$pid_new|';";
		$results = $DB->query($query);
		
		header("Location:?p=admin_noparent");
	}
	
/// CHECK FOR NOPARENT
	$CONTENTS 	= list_data('contents');
	$KEYS 		= array_flip_multi($CONTENTS);
	
	foreach ($CONTENTS as $CONTENT) {
		if ((in_array(substr($CONTENT['pid'], 1, -1),$KEYS) || substr($CONTENT['pid'], 1, -1) == -1) )  { //&& ($count_max_rows >= $max_rows)

		} else {
			$return .= $CONTENT['id'] . "-" . $CONTENT['name'] . "- <b>no parent</b> <br><br />";
			$NOPARENT[] = $CONTENT['id'];
			if ($PAR['action'] == delete) {
				$query = "UPDATE `contents` SET `pid` = '|$pid_new|' WHERE `id` = " . $CONTENT['id']; 
				$DB->query($query);
			}
		}
	}
	
	$return .= "<br>affected rows = " . count($NOPARENT) . "<br />";
	
/// LIST ROWS IN NOPARENT
	$query = "--  contents_noparent
				  SELECT *					  
				  FROM `contents`
				  WHERE `pid` = '|$pid_new|'				  
			 ";
	
	//$options = type_sys_pid();
	
	$RESULTS = $DB->select($query);	
	
	if (count($RESULTS['ROWS']) > 0) {
		foreach ($RESULTS['ROWS'] as $ROW) {
			$return .= $ROW['id'] . "-" . $ROW['name'] . "- <b>no parent</b>  $options <br>";
			$affected++;
		}
		
		$return .= "<br>no parent rows in db = " . $affected . "<br />";
		$return .= "<br /><a href=\"?p=admin_noparent&action=remove\">remove orphelins</a><br /><br />";
	}

?>