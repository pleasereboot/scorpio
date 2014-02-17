<?php 

	/* SCORPIO engine - footer.php - v3.17		*/	
	/* created on 2006-12-31	 				*/
	/* updated on 2008-02-07	 				*/	
	/* KAMELOS MARKETING INC	78/86/137     	*/

/// INI
	$t_filename = "footer";

/// FOOTER TEMPLATE
	$t_file_html	= t_load_file($t_filename, $t_filename, $sys);
	$t_footer_html	= t_set_block($t_filename, "FOOTER");

/// set lang switch
	$LANG = array_flip($LIST['lang']['DATA']);
	$page = qs_load();
	
	if (lang() == 'fr') {$lang = 'en';} else {$lang = 'fr';}	
	if (lang() == 'fr') {$lang_label = 'english version';} else {$lang_label = 'version française';}
	
	$t_footer_html	= set_var($t_footer_html, "SITE_LANG_URL", $page . '&lang=' . $LANG[$lang]);
	$t_footer_html	= set_var($t_footer_html, "SITE_LANG_LABEL", $lang_label);

/// RETURN	
	$return = $t_footer_html;//print_r($GENRE, 1);
	
?> 