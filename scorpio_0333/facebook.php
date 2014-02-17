<?php 

	/* SCORPIO engine - scorpio.php - v4.00		*/	
	/* created on 2006-12-31	 				*/
	/* updated on 2007-11-03	 				*/	
	/* YANNICK MENARD	124/92    				*/

	setlocale(LC_TIME, 'fr_FR');
	ini_set('upload_max_filesize',5);

/// SITE INI
	define('SITE_NAME'								, $site_name);
	define('SITE_DB_VERSION'						, $site_db_version);
	define('SITE_DB_NAME'							, $site_db_name);
	define('SITE_DB_USER'							, $site_db_user);	
	define('SITE_DB_PASSWORD'					, $site_db_password);
	
	define('LOCAL'										, false);	
	
/// SCORPIO INI
	define('TIME'										, time());  //v3.25

	define('SCORPIO_VERSION'						, $scorpio_version);	
	define('SCORPIO_EMAIL'						, "yannick@ledevin.com");
	define('SCORPIO_PAGE_DEFAULT'			, "admin");
	define('SCORPIO_THEME_DEFAULT'			, "default"); //devra etre setté  dans scorpio
	define('SCORPIO_PATH'							, $scorpio_path . "scorpio_" . SCORPIO_VERSION . "/");

	define('SCORPIO_CONTENTS_PATH'			, SCORPIO_PATH 					. "contents/");
	define('SCORPIO_CORE_PATH'					, SCORPIO_PATH 					. "core/");
	define('SCORPIO_CLASSES_PATH'			, SCORPIO_CORE_PATH 		. "classes/");	
	define('SCORPIO_FUNCTIONS_PATH'		, SCORPIO_CORE_PATH 		. "functions/");	
	define('SCORPIO_JS_PATH'						, SCORPIO_CORE_PATH 		. "js/");
	define('SCORPIO_TYPES_PATH'				, SCORPIO_CORE_PATH 		. "types/");
	define('SCORPIO_FACEBOOK_PATH'			, SCORPIO_CORE_PATH 		. "facebook/");	
	
	define('SCORPIO_INSTALL_PATH'				, SCORPIO_PATH					. "install/");	
	define('SCORPIO_LANGUAGES_PATH'		, SCORPIO_PATH					. "languages/");
	
	define('SCORPIO_THEMES_PATH'				, SCORPIO_PATH					. "themes/");
	define('SCORPIO_CSS_PATH'					, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/css/");
	define('SCORPIO_FONTS_PATH'				, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/fonts/");
	define('SCORPIO_IMAGES_PATH'				, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/images/");
	define('SCORPIO_SWF_PATH'					, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/swf/");		
	define('SCORPIO_TEMPLATES_PATH'		, SCORPIO_THEMES_PATH . SCORPIO_THEME_DEFAULT . "/templates/");	

/// ICONS
	define('I_DEL'										, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_delete.png\" border=\"0\" alt=\"SUPPRIMER\" />");	
	define('I_DUP'										, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_dup.png\" border=\"0\" alt=\"DUPLIQUER\" />");
	define('I_EDIT'										, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_edit.png\" border=\"0\" alt=\"MODIFIER\" />");
	define('I_ZOOM'									, "<img src=\"" . SCORPIO_IMAGES_PATH . "icons/sys_zoom.png\" border=\"0\" alt=\"ZOOM\" />");	
	
/// CONSTANTS
	define('NL', '\n');
	define('TB', '\t');
	define('BR', '<br />');
	define('SP', ' ');
	define('BA', ' | ');
	define('HS', '&nbsp;');	
	
/// LOAD SCORPIO LIBRARIES
	include_once SCORPIO_FUNCTIONS_PATH 	. 'func_commons.php';
	include_once SCORPIO_CLASSES_PATH 		. 'class_db.php';
	
/// LOAD FACEBOOK LIBRARIES
	include_once SCORPIO_FACEBOOK_PATH 	. 'simplexml44-0_4_4/class/IsterXmlSimpleXMLImpl.php';
	include_once SCORPIO_FACEBOOK_PATH 	. 'php4client/facebookapi_php4_restlib.php';
	include_once SCORPIO_FACEBOOK_PATH	. 'php4client/facebook.php';
	include_once SCORPIO_FACEBOOK_PATH 	. 'func_facebook.php';	
		
	
?>