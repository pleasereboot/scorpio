<?php

	/* SCORPIO engine - newsletter_small.php - v3.17	*/
	/* created on 2008-01-31	 						*/
	/* updated on 2008-01-31	 						*/
	/* YANNICK MENARD									*/

	global $CORE;



/// FILL TEMPLATE   
	$form_file_html 		= t_load_file("newsletter_small", "newsletter_small", false, "contents/newsletter/templates/"); //should come from ini, genre $CORE	
	$form_input_html 		= t_set_block ("newsletter_small", "EMAIL_INPUT");

//	$FORM_VARS	= array("FIELD_LABEL"		=> $TYPE_PAR[lang("label")], 
//						"FIELD_VALUE" 		=> $content,
//						"NAME"				=> $field_name . "-" . $AC['id'],
//						);	
	
	$return	 			= set_var($form_input_html, $FORM_VARS);	
	
	
	
	
	
	
	
?>