<?php

	/* SCORPIO engine - site_map.php - v3.32				*/
	/* created on 2007-04-30	 						*/
	/* updated on 2009-05-01	 						*/
	/* YANNICK MENARD			126						*/

	global $CORE;

	$DB = new db();

	$allow = max($CORE['GROUPS']); 

	$query = "--  site_map
				  SELECT *					  
				  FROM `contents`
				  WHERE `type` = '1'
				  AND `status` = '1'
				  AND `allowed` <= '$allow'
				  AND `par` NOT LIKE '%map:false%'
				  ORDER BY `label_fr`			  
			 ";
	
	$PAGES = $DB->select($query); 
	
	foreach ($PAGES['ROWS'] as $key => $PAGE) {
		$MAP[] = url($PAGE[lang('label')], "?p=" . $PAGE['name']);
	}		

	$html .= BR . div(implode(' | ', $MAP), array('style' => 'width:80%;text-align:center;padding:0px 10% 0px 10%')); //'PLAN DU SITE -> ' . 
	//$html .= '<a href="javascript:addBookmark(\'Orange-River\', \'http://www.orange-river.ca/\')"><font color="#0000FF" face="Arial">Ajouter à vos favoris</font></a>';

/// RETURN
	$return = $html;//print_r($GENRE, 1);

?>