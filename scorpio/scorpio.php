<?php

	/* SCORPIO engine - scorpio.php - v4.00		*/
	/* created on 2006-12-31	 				*/
	/* updated on 2007-11-03	 				*/
	/* YANNICK MENARD	124/92    				*/

	session_start ();
	setlocale(LC_TIME, 'fr_FR');

	ini_set('upload_max_filesize',5);

/// LOAD SCORPIO AND SITE INI
	require_once($scorpio_path . "scorpio_$scorpio_version/ini.php");
	require_once('ini.php');
	require_once(SCORPIO_CLASSES_PATH . "scorpio.php");

	$SCORPIO = new scorpio;

	$SCORPIO->ini_functions(array('list','template','scorpio'));
	$SCORPIO->ini_classes(array('db','session'));
	$SCORPIO->ini_classes(array('contents'));
	$SCORPIO->ini_types(array('checkin','checkout'));
	$SCORPIO->load_site();
	//$SCORPIO->load_tables();
	$SCORPIO->load_contents();
	$SCORPIO->load_types();
	$SCORPIO->load_groups();
	$SCORPIO->set_js(SCORPIO_JS_PATH . "update.js",1);
	$SCORPIO->set_js(SCORPIO_JS_PATH . "live.js",1);

/// load FACEBOOK
	if (isset($_GET['fb_sig_user'])) {
	// // the facebook client library
	 include_once 'php4client/facebook.php';

	// // some basic library functions
	// include_once 'lib.php';

	// // this defines some of your basic setup
	// include_once 'config.php';

	// $facebook = new Facebook($api_key, $secret);
	// $facebook->require_frame();

	// $user_id  = $facebook->require_login();
	}

// [fb_sig_user] => 724222829


/// START SESSION HANDLER
	$SCORPIO->session_initiate(); 	// a partir d'ici, is_allowed fonctionne

/// LANGUAGE SELECTOR
	$SCORPIO->domain_set();

/// LANGUAGE SELECTOR
	$SCORPIO->lang_set();

//e($_SESSION,1);

/// LOAD ADMIN FILES IF ALLOWED
	if (is_allowed(5)) {
		$SCORPIO->ini_functions(array('admin'));//,'files'
		$SCORPIO->set_css_link("admin",1);
		//$SCORPIO->set_js(SCORPIO_JS_PATH . "test.js");
	}


/// TREE CONTENTS
	$LIST['tree_data'] = db_select("contents");

	foreach($LIST['tree_data']['DATA'] as $ROW) {
		$id = $ROW['id'];
		$pid = substr($ROW['pid'], 1, -1);

		$CHILDS_INDEX[$pid][] = $id;
		$PARENTS_INDEX[$id] = $pid;
	}

/// PAGE CONTENT
	$page_name 			= page_validate($_GET['p']);
	$page_id			= data_switch("contents" , $page_name);
	$CORE['GET']['p'] 	= $page_name;

	define('PAGE_NAME', $page_name);
	define('PAGE_ID', $page_id);
	define('PAGE_TITLE', $LIST['contents']['DATA'][$page_id]['label_fr']);//patch titre agora
	define('PAGE_CONTENT', $LIST['contents']['DATA'][$page_id]['par']);

//	if ($fp = @fopen('files/debug.txt', 'a')) {
//		fwrite($fp, $CORE['SESSION']['active_url'] . NL);
//		fclose($fp);
//	}

	if ($_GET['live'] == 'true') {
		/// MAIN CONTENT
			$main_html 				= content(PAGE_ID);

			$CORE['MAIN']['HTML']	= $main_html;
			$html = $main_html;
	} else {

	/// CACHE SYSTEM
		if (isset($_GET['action']) && ($_GET['action'] == "clear_cache" || $_GET['action'] == "clear_cache_all") && CACHE) {
			if ($_GET['action'] == "clear_cache_all") {$clear_all = 1;}
			$SCORPIO->clear_cache($clear_all);
			goto_previous();
		}

		if ($SCORPIO->is_cached() && !is_allowed(5) && count($_POST) <= 0 && CACHE) {
			$html = $SCORPIO->load_cache();
			$from_cache = " from cache";
		} else {
		/// EVENT MAIN_AFTER
			include(SCORPIO_CORE_PATH . 'events/main_before.php');
			$main_html	.= $event_main_before;

		/// MAIN CONTENT
			$main_html 				= content(PAGE_ID);

			if($main_html == '') {$main_html = ' ';}

			$CORE['MAIN']['HTML']	= $main_html;

			$SCORPIO->set_css_link("default");
			$SCORPIO->set_js(SCORPIO_JS_PATH . "ieupdate.js" , 0,1);

		/// PAGE LAYOUT CONTENT
			if ($CORE['MAIN']['page_layout'] !=  '') {
				$page_layout_id = $CORE['MAIN']['page_layout'];
			} else {
				$page_layout_id = PAGE_DEFAULT_LAYOUT;
			}

			define('PAGE_LAYOUT_ID', $page_layout_id);
			define('PAGE_LAYOUT_NAME', data_switch("contents" , $page_layout_id));

			$page_layout_html = content($page_layout_id);

			$CORE['PAGE']['HTML'] = $page_layout_html;

		/// SITE LAYOUT CONTENT
			if ($CORE['GET']['layout'] == "none") {
				$layout = "none";
				$page_template = "pagenone";
				t_load_file($page_template, "page_none", true);
			} else {
				if ($CORE['MAIN']['layout'] != "") {$layout = $CORE['MAIN']['layout'];} else {$layout = SITE_DEFAULT_LAYOUT;}

				$page_template = "pagedefault";
				t_load_file($page_template, "page_default", true);
			}

			$layout_name 		= "layout_" . $layout;
			$layout_id			= data_switch("contents" , $layout_name);
			define('SITE_LAYOUT_ID', $layout_id);
			define('SITE_LAYOUT_NAME', $layout_name);

			//if ($layout_id == "") {$layout_id = data_switch("contents" , "layout_full");	} v3.30

			$layout_html 		= content($layout_id);

			$html	 			= t_set_var($page_template,"LAYOUT_HTML", $layout_html);

			if ($CORE['MAIN'][lang('desc')] != '') {$desc = $CORE['MAIN'][lang('desc')];} else {$desc = $CORE['SITE']['description'];}

			//$SCORPIO->set_css('BODY', 'background-color:#000000');

			$PAGE_VARS	= array('PAGE_TITLE'		=> $CORE['SITE'][lang('label')] . ' - ' . $CORE['MAIN']['title'] . " - " . $desc,
								'PAGE_CSS_LINK'		=> $SCORPIO->parse_css_link(),
								'PAGE_CSS' 			=> $SCORPIO->parse_css(),
								'PAGE_JS_TOP'		=> $SCORPIO->parse_js(),
								'PAGE_JS_BOT'		=> $SCORPIO->parse_js(1),
								'SITE_KEYWORDS'		=> $CORE['SITE']['keywords'],
								'SITE_DESCRIPTION'	=> $desc,

							/// FOOTER
								'VERSION' 			=> SCORPIO_VERSION,
								'SITE_NAME' 		=> $CORE['SITE'][lang('label')],
								);

			$html	 			= set_var($html, $PAGE_VARS);

			if (!in_array(PAGE_NAME, $CACHE_EXCEPTION_PAGES) && CACHE) {
				if (!is_allowed(5)) {
					$SCORPIO->set_cache($html);
					$from_cache = " new cache";
				} else {
					$SCORPIO->clear_cache();
					$from_cache = " cache cleared";
				}
			}
		}

		$chrono_end			= chrono();

	/// CACHE VARS
		if (is_allowed(5)) {
			$ADMIN_VARS	= array(
								"ADMIN_CHRONO" 		=> $chrono_end,
								"ADMIN_QUERIES" 	=> count($CORE['DEBUG']['QUERIES']),
								"ADMIN_FUNCTIONS" 	=> count($CORE['DEBUG']['FUNCTIONS']),
								"ADMIN_CONTENTS" 	=> count($LIST['contents']['DATA']),
							 );

			$html	 	= set_var($html, $ADMIN_VARS);
		}

	/// RUN NO-CACHE CONTENTS    v3.22
		foreach ($NOCHACHE_CONTENTS as $nocache_id) {
			if (PAGE_NAME == "home") { // must put allowed pages
				content($nocache_id);
			}
		}

		if (DEBUG) {
			$site_chrono 			= "<br />(g�n�r� en " . $chrono_end . ", " . count($CORE['DEBUG']['QUERIES']) . " queries)";
			$site_cache  			= $from_cache;
			$site_clear_cache  		= "&nbsp;&nbsp;�&nbsp;&nbsp;clear cache <a href=\"" . qs_load() . "&action=clear_cache" . "\">this page</a> | <a href=\"" . qs_load() . "&action=clear_cache_all" . "\">all</a>";
		}

		if (LANG_SWITCH) {
			if (lang() == 'fr') {
				$lang_url = url('english', qs_load() . '&lang=2');
			} else {
				$lang_url = url('fran�ais', qs_load() . '&lang=1');
			}

			$switch_lang_html = '&nbsp;&nbsp;&bull;&nbsp;&nbsp' . $lang_url;
		}

/// GOOGLE ANALYTICS
		if ($ga_account != '') {
			$ga_html = '
				<script type="text/javascript">
					var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
					document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
					</script>
					<script type="text/javascript">
					try {
					var pageTracker = _gat._getTracker("' . $ga_account . '");
					pageTracker._trackPageview();
					} catch(err) {}
				</script>';
		}


		$CACHE_VARS	= array(
							'HITS' 						=> $CORE['SITE']['hits'],
							'LAST_UPDATED' 				=> date('d\ m\ Y',$CORE['SITE']['mdate']),
							'SITE_CHRONO' 				=> $site_chrono,
							'SITE_CACHE' 				=> $site_cache,
							'SITE_CLEAR_CACHE'			=> $site_clear_cache,
							'LANG_SWITCH'				=> $switch_lang_html,
							'SAVIEZVOUSQUE'	 			=> $MOD['saviezvousque'],
							'GA'						=> $ga_html,
							);

		$html	 			= set_var($html, $CACHE_VARS);
	}

	$html	 			= t_remove_empty($html);



/// FINAL OUTPUT
	$html = t_remove_empty($html);
	echo $html;

	$CORE['MAIN']['HTML'] 			= 'deleted for cleaness';
	$CORE['SITE']['password'] 		= 'deleted for cleaness';

	$SESSION->stats($chrono_end,$from_cache);

	if (is_allowed(6)) {
		//sep();
		set_function('FINITO');
		//e($CORE);
		//e($LIST['types']['DATA']);
		//e($LIST);
		//e($CORE['USER'],1);
		//e($CORE['SESSION'],1);
		e($CORE['DEBUG']['tree_count']);
		e($CORE['DEBUG']['tree2_count']);
		//e($SELECT);
	}

	unset($LIST);
	unset($CORE);
?>