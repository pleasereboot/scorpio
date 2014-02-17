<?php

	/* SCORPIO engine - index.php - v3.33		*/	
	/* created on 2006-12-31	 				*/
	/* updated on 2009-05-29	 				*/	
	/* KAMELOS MARKETING INC		29/0		*/

	define("SCORPIO"		, true); 
	define("LOCAL"			, false);
	define("DEBUG"			, false);
    define("MAINTENANCE"	, false);
    define("CACHE"			, false);
    define("SPLASH"			, false);		
    define('LANG_SWITCH'	, true);

/// SITE STATUS
	$ALLOWED_IPS[] = '173.176.184.229';
	$ALLOWED_IPS[] = '66.130.77.131';
	$ALLOWED_IPS[] = '24.203.76.46';	
	//$ALLOWED_IPS[] = '24.201.173.148';

	if (MAINTENANCE && !in_array($_SERVER['REMOTE_ADDR'],$ALLOWED_IPS)) { // to scorpio
		echo "en cours de maintenance<br>";
		echo $_SERVER['REMOTE_ADDR'] . "<br>";
		//header("Location:index.html");
		die;
	}

/// PHP INI
	error_reporting(E_ERROR | E_WARNING | E_PARSE);  							//11 pour checker les variables vides 
	ini_set("display_errors",DEBUG);
	ini_set('allow_call_time_pass_reference', 1);  	//faudrait corriger notre code pour enlever cette ligne

/// SCORPIO INI
	$scorpio_version 			= "0333";
	$scorpio_path				= ""; //"../../"

/// SITE INI
	define('SITE_NAME'						, 'gladale');
	define('SITE_USERNAME'					, 'gladale');	
	define('SITE_PASSWORD'					, 'G706D5S0');
	define('SITE_IP'						, '67.222.142.190');

/// DB INI	
	define('SITE_DB_VERSION'				, '0333');
	define('SITE_DB_NAME'					, SITE_USERNAME . '_' . SITE_DB_VERSION);
	define('SITE_DB_USER'					, SITE_USERNAME . '_' . SITE_DB_VERSION);	
	define('SITE_DB_PASSWORD'				, 'G706D5S0');
	
/// GOOGLE ANALYTICS ACCOUNT	
	//$ga_account = 'UA-8526360-5';
	
/// SCORPIO START
	include($scorpio_path . "scorpio_$scorpio_version/scorpio.php");
	
?>