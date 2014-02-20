<?php 

	/* SCORPIO engine - site ini.php - v3.05		*/	
	/* created on 2007-01-23	 					*/
	/* updated on 2007-05-15	 					*/	
	/* KAMELOS MARKETING INC	54/79/103/137     	*/

/// SCORPIO INI
	define('TIME'							, time());  //v3.25

	define('SCORPIO_DB_VERSION'				, "0400");
	define('SCORPIO_DB_NAME'				, "sites_" . SCORPIO_DB_VERSION);
	define('SCORPIO_DB_USER'				, "sites");	
	define('SCORPIO_DB_PASSWORD'			, "s1tes0300");
		
	define('SCORPIO_VERSION'				, $scorpio_version);	
	define('SCORPIO_EMAIL'					, "web@ledevin.com");
	define('SCORPIO_PAGE_DEFAULT'			, "admin");
	define('SCORPIO_THEME_DEFAULT'			, "default"); //devra etre setté  dans scorpio
	define('SCORPIO_PATH'					, $scorpio_path . "scorpio_" . SCORPIO_VERSION . "/");

	define('SCORPIO_CONTENTS_PATH'			, SCORPIO_PATH 			. "contents/");
	define('SCORPIO_CORE_PATH'				, SCORPIO_PATH 			. "core/");
	define('SCORPIO_CLASSES_PATH'			, SCORPIO_CORE_PATH 	. "classes/");	
	define('SCORPIO_FUNCTIONS_PATH'			, SCORPIO_CORE_PATH 	. "functions/");	
	define('SCORPIO_JS_PATH'				, SCORPIO_CORE_PATH 	. "js/");
	define('SCORPIO_TYPES_PATH'				, SCORPIO_CORE_PATH 	. "types/");
	
	define('SCORPIO_INSTALL_PATH'			, SCORPIO_PATH			. "install/");	
	define('SCORPIO_LANGUAGES_PATH'			, SCORPIO_PATH			. "languages/");
	
	define('SCORPIO_THEMES_PATH'			, SCORPIO_PATH			. "themes/");
	define('SCORPIO_CSS_PATH'				, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/css/");
	define('SCORPIO_FONTS_PATH'				, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/fonts/");
	define('SCORPIO_IMAGES_PATH'			, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/images/");
	define('SCORPIO_SWF_PATH'				, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/swf/");		
	define('SCORPIO_TEMPLATES_PATH'			, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/templates/");	

/// ICONS
	define('I_DEL'							, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_delete.png\" border=\"0\" alt=\"SUPPRIMER\" />");	
	define('I_DUP'							, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_dup.png\" border=\"0\" alt=\"DUPLIQUER\" />");
	define('I_EDIT'							, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_edit.png\" border=\"0\" alt=\"MODIFIER\" />");
	define('I_ZOOM'							, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_zoom.png\" border=\"0\" alt=\"ZOOM\" />");

/// PREPEND
	$CORE['SITE']			 				= "";
	$CORE['SESSION'] 						= "";
	$CORE['USER'] 							= "";
	$CORE['GROUPS'] 						= "";
	$CORE['MAIN'] 							= "";
	$CORE['PAGE'] 							= "";
	$CORE['POST'] 							= $_POST;
	$CORE['GET'] 							= $_GET;
	$CORE['QS'] 								= $_GET;		
	$CORE['LIST'] 							= ""; // mettre les types et les tables là dedans  
	$CORE['TEMPLATES'] 						= "";
	$CORE['MOD'] 							= ""; //v3.22 to support noncached mod vars (mperrier quotes)
	
	$LIST									= array();
	$RELATIONS								= array();	
	$TREES									= array();
	$TEMPLATES								= array();	
	
	$SELECT									= array(); //v3.22
	$RS										= array(); //v3.22
	$STRUCTS								= array(); //v3.22 hold struct tree, will be store in db using cache_order !	

/// LANG
	$LIST['lang']['DATA'] = array(1 => "fr", 2 => "en", 3 => "sp", 4 => "it");
	$CORE['LIST']['TABLES'][] = "lang";
	
	define('FR'								, 1);
	define('EN'								, 2);	
	define('SP'								, 3);	
	
	$LIST['status']['DATA'] = array(0 => "inactive", 1 => "active", 2 => "delete", 3 => "WC", 4 => "WA", 5 => "NEW");  // WC WA NEW v3.23
	$CORE['LIST']['TABLES'][] = "status";	
	
	$LIST['files_types']['DATA'] = array(0 => "image/jpeg", 1 => "image/gif", 2 => "application/pdf", 3 => "image/pjpeg", 4 => "image/png", 5 => "application/vnd.ms-excel", 6 => "image/x-png");
	$CORE['LIST']['TABLES'][] = "files_types";
	
	$LIST['pid_filter']['DATA'] = array(4,8,10,14,15,16,17,18,19,28,29,30,37,41);
	$CORE['LIST']['TABLES'][] = "pid_filter";
	
	$LIST['sel_yesno']['DATA'] = array(0 => "NON", 1 => "OUI",);
	$CORE['LIST']['TABLES'][] = "sel_yesno";

 // new scorpio	
	$LIST['noprevious'] = array("log","error","form_process","session");
	$LIST['checkin'] = array(	101 => array('name' => "ci_default", 'function' => "ci_default"),
								105 => array('name' => "ci_password", 'function' => "ci_password"),
							);	
		
/// CHECKIN
	//$CORE['LIST']['TABLES'][] = "checkin";
	//$LIST['checkin'] = array(	79 => array('name' => "ci_timestamp", 	'function' => "ci_timestamp"	),
	//							80 => array('name' => "ci_owner", 		'function' => "ci_owner"		),
	
		//					);
							
/// CONSTANTS
	define('NL', '\n');
	define('TB', '\t');
	define('BR', '<br />');
	define('SP', ' ');
	define('BA', ' | ');
	define('HS', '&nbsp;');
	
/// NON_CACHE CONTENTS	
	$NOCHACHE_CONTENTS = array('saviezvousque' => 3762); // must set allowed pages, patch dans scorpio
		
?>