<?php

	/* SCORPIO engine - newsletter.php - v3.17	*/
	/* created on 2008-01-31	 						*/
	/* updated on 2008-01-31	 						*/
	/* YANNICK MENARD									*/

	global $CORE;
	
	$PAR = explode_par($par);

	$DB = new db();

	$form_file_html = t_load_file("mod_stats", "stats", true, "mod_stats/templates/"); //should come from ini, genre $CORE	
	$session_block 	= t_set_block ("mod_stats", "STATS_SESSION_ROW");
	$stats_block 	= t_set_block ("mod_stats", "STATS_HITS");
	
/// SESSION STATS
 // TODAY
	$today 			= strtotime("12am");
 
	$query 			= "SELECT COUNT(*) FROM `sys_stats` WHERE `cdate` >= '$today' GROUP BY `ip`";// WHERE `id` = '$id'   AND `userid` NOT IN (5,6)
	$TODAY 			= $DB->select($query);

 // YESTERDAY
 	$yesterday 		= strtotime("yesterday 12am");
 
	$query 			= "SELECT COUNT(*) FROM `sys_stats` WHERE `cdate` >= '$yesterday' AND `cdate` < '$today' GROUP BY `ip`";// WHERE `id` = '$id'   AND `userid` NOT IN (5,6)
	$YESTERDAY 		= $DB->select($query);

 // 7 LAST DAYS
 	$sevendays 		= strtotime("-7 days 12am");
 
	$query 			= "SELECT COUNT(*) FROM `sys_stats` WHERE `cdate` >= '$sevendays' GROUP BY `ip`";// WHERE `id` = '$id'   AND `userid` NOT IN (5,6)
	$SEVENDAYS 		= $DB->select($query);


	$LAST_STATS	= array("TODAY"			=> $TODAY['rows_number'], 
						"YESTERDAY"		=> $YESTERDAY['rows_number'],
						"SEVENDAYS"		=> $SEVENDAYS['rows_number'],
						);
		
	//echo date("\L\e\ d\ m\ Y G:i:s", $today);	
	//echo date("\L\e\ d\ m\ Y G:i:s", $yesterday);
	//echo date("\L\e\ d\ m\ Y G:i:s", $sevendays);
						
	$session_stats_html	 .= set_var("mod_stats", $LAST_STATS);	

/// SESSION LOG
	$query 		= "SELECT * FROM `sessions` WHERE `status` = '1' ORDER BY `mdate` DESC";// WHERE `id` = '$id'   AND `userid` NOT IN (5,6)
	$RESULT 	= $DB->select($query);
	
	foreach ($RESULT['ROWS'] as $ROW) {
		$SESSION_VARS	= array("IP"		=> $ROW['ip'], 
								"SESSIONID"	=> substr($ROW['id'],-5),
								"STATUS" 	=> $ROW['status'],
								"USERID" 	=> $ROW['userid'],
								"PAGE" 		=> $ROW['active_page'],
								"REFERER" 	=> $ROW['referrer'],								
								"MDATE" 	=> date("d\ m\ Y G:i:s", $ROW['mdate']),
							);
							
		$row_html	 .= set_var($session_block, $SESSION_VARS);											
	}
	
	$html	 		.= set_var(t_get_var("mod_stats"), $LAST_STATS);		
	$return	 		.= set_var($html, "STATS_SESSION_ROW", $row_html);	
		
		
		
	
?>