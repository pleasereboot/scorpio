<?php 

/// INI
	$t_filename = "accueil_menu";
	$hits		= $CORE['SITE']['hits'];

/// FOOTER TEMPLATE
	$t_file_html	= t_load_file($t_filename, $t_filename, $sys);
	$t_footer_html	= t_set_block($t_filename, "FOOTER");

/// set hits
	$t_footer_html	= set_var($t_footer_html, "HITS",  $hits);
	$t_footer_html	= set_var($t_footer_html, "VERSION",  "v" . SCORPIO_VERSION);		

/// set name
	$t_footer_html	= set_var($t_footer_html, "SITE_NAME",  $CORE['SITE'][lang("label")]);

/// RETURN	
	$return = $t_footer_html;//print_r($GENRE, 1);
	
?>