<?php 

	/* SCORPIO engine - scorpio ini.php - v3.05		*/	
	/* created on 2007-01-23	 					*/
	/* updated on 2007-05-15	 					*/	
	/* KAMELOS MARKETING INC	40/79/103/137     	*/

/// SITE INI	
	define('SITE_THEME_DEFAULT'			, "default");		
	define('SITE_PATH'						, "");
	
	define('SITE_CONTENTS_PATH'			, SITE_PATH . "contents/");	
	define('SITE_FILES_PATH'			, SITE_PATH . "files/");
	define('SITE_LANGUAGES_PATH'			, SITE_PATH . "languages/");
	define('SITE_MODULES_PATH'			, SITE_PATH . "modules/");
	define('SITE_THEMES_PATH'			, SITE_PATH . "themes/");
		
	define('SITE_CSS_PATH'				, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/css/");
	define('SITE_FONTS_PATH'			, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/fonts/");	
	define('SITE_IMAGES_PATH'			, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/images/");	
	define('SITE_SWF_PATH'				, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/swf/");
	define('SITE_TEMPLATES_PATH'			, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/templates/");
	define('SITE_CONTENTS_HTML_PATH'		, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/contents_html/");
	define('SITE_TEMPLATES_HTML_PATH'		, SITE_THEMES_PATH . SITE_THEME_DEFAULT . "/templates/");	

	define('PAGE_DEFAULT'				, "profil");
	define('PAGE_ERROR_NOTFOUND'			, "error");
	define('PAGE_ERROR_ACCESS'			, "error");
	define('PAGE_AFTER_LOGIN'			, "home");
	
	define('SITE_DEFAULT_LAYOUT'			, "full");
	define('PAGE_DEFAULT_LAYOUT'			, 3834); //bleu:3828 
	
	define('HTML_WIDTH'				, 500);
	define('HTML_HEIGHT'				, 400);	
	define('SITE_FILES_BATCH_PATH'			, SITE_FILES_PATH . "_batch/");
	
/// LANGUAGES
	define('LANG_DEFAULT'				, FR);
	define('LANG_SWITCH'				, true); //v3.26
	

/// DOMAINS SETTINGS (lang, default page, etc)
	$DOMAINS = array('cirauniformes' => array('lang' 	=> FR, ),
					 'cirauniforms'  => array('lang' 	=> EN, )					  
					 );

/// USERS
	define('APPROVE_USER'					, false);	

/// HTML fadra
	$LIST['document_type']['DATA'] = array(
										1 	=> 'Basket', 
										2 	=> 'Quote', 
										3 	=> 'order', 
										4 	=> 'B.O.',
										5 	=> 'Booking',
										6 	=> 'Invoice (Opened)', 
										7 	=> 'Invoice',
										8 	=> 'Adjustment (Opened)', 
										9 	=> 'Adjustment',
										10 	=> 'Credit note', 
										11 	=> 'Debit note',
										12 	=> 'Web cart',
										
											
										   );
							
	$CORE['LIST']['TABLES'][] = "document_type";

	 $LIST['sizes']['DATA'] = array(
										1 	=> 'XXS',
										2 	=> 'XS',
										3 	=> 'S',
										4 	=> 'M',
										5 	=> 'L',
										6 	=> 'XL',
										7 	=> 'XXL',
										8 	=> 'XXXL',
										9 	=> '1',
										10 	=> '3',
										11 	=> '5',
										12 	=> '7',
										13 	=> '9',
										14 	=> '11',
										15 	=> '13',
										16 	=> '15',
										17 	=> '17',
										18 	=> '19',
										19 	=> '28',
										20 	=> '29',
										21 	=> '30',
										22 	=> '31',
										23 	=> '32',
										24 	=> '33',
										25 	=> '34',
										26 	=> '35',
										27 	=> '36',
										28 	=> '38',
										29 	=> '40',
										30 	=> '42',
										31 	=> '44',
										32 	=> '46',
								 );
	

	 $CORE['LIST']['TABLES'][] = "sizes";

	 $LIST['colors']['DATA'] = array(array(	'id' 		=> 1,
											 'title_fr' 	=> 'bleu clair',
											 'title_en' 	=> 'light blue',
											 'file' 		=> 'light_blue.jpg',),
									 array(	'id' 		=> 2,
											 'title_fr' 	=> 'orange br�l�',
											 'title_en' 	=> 'burnt orange',
											 'file' 		=> 'burnt_orange.jpg',),
									 array(	'id' 		=> 3,
											 'title_fr' 	=> 'blanc',
											 'title_en' 	=> 'white',
											 'file' 		=> 'white.jpg',),
									 array(	'id' 		=> 4,
											 'title_fr' 	=> 'moka',
											 'title_en' 	=> 'moka',
											 'file' 		=> 'moka.jpg',),
									 array(	'id' 		=> 5,
											 'title_fr' 	=> 'bleu acier',
											 'title_en' 	=> 'steel blue',
											 'file' 		=> 'steel_blue.jpg',),
									 array(	'id' 		=> 6,
											 'title_fr' 	=> 'rose',
											 'title_en' 	=> 'pink',
											 'file' 		=> 'pink.jpg',),
									 array(	'id' 		=> 7,
											 'title_fr' 	=> 'nouveau bleu',
											 'title_en' 	=> 'new blue',
											 'file' 		=> 'new_blue.jpg',),
									 array(	'id' 		=> 8,
											 'title_fr' 	=> 'navy',
											 'title_en' 	=> 'navy',
											 'file' 		=> 'navy.jpg',),
									 array(	'id' 		=> 9,
											 'title_fr' 	=> 'noir',
											 'title_en' 	=> 'black',
											 'file' 		=> 'black.jpg',),											 										
								 );
								
	 $CORE['LIST']['TABLES'][] = "colors";

/// CACHE exception page
	$CACHE_EXCEPTION_PAGES = array('search_process');

/// IMAGES INI

	$IMAGES_SIZE = array("medthumb" => array( 	"ext" 		=> "_mt",
												"max_hor" 	=> "100",
												"max_ver" 	=> "100",
												"min_hor" 	=> "100",
												"min_ver" 	=> "100",											
										   		   ),
						"smallthumb" => array( 	"ext" 		=> "_t",
												"max_hor" 	=> "50",
												"max_ver" 	=> "50",
												"min_hor" 	=> "50",
												"min_ver" 	=> "50",											
										   		   ),
						"small" 	=> array( 	"ext" 		=> "_s",
												"max_hor" 	=> "125",
												"max_ver" 	=> "125",
												"min_hor" 	=> "125",
												"min_ver" 	=> "125",											
										   		   ),
						"medium" => array( 		"ext" 		=> "_m",
												"max_hor" 	=> "400",
												"max_ver" 	=> "400",
												"min_hor" 	=> "400",
												"min_ver" 	=> "400",											
										   		   ),
						"original" => array( 	"ext" 		=> "",
												"max_hor" 	=> "800",
												"max_ver" 	=> "800",
												"min_hor" 	=> "800",
												"min_ver" 	=> "800",											
										   		   )												   
								);
		
?>
