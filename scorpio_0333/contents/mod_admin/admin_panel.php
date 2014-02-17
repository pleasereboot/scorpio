<?php 


	$DB = new db();
	$this_page = 'admin_panel';
	
/// GOD PANEL

 // CHECK IF SITE IS IN DB
	if ($CORE['SITE']['name'] == '') { 
		$GOD['site created in db'] = 'nope ' . url('(create)', '?p=admin_sites'); 
	}

 // LOOK FOR 0 CONTENT AND CHANGE IT (BUG REPAIR)	
 	if($_GET['action'] == '0bug') {
		$query = "UPDATE `contents` SET `id` = '0' WHERE `name` = 'scorpio'"; 
		$DB->query($query);
		
		header("Location:?p=$this_page");
	}
 
	$root_query = "		
		SELECT * FROM `contents` WHERE `name` = 'scorpio'
		";
		
	$ROOT_RESULTS = $DB->select($root_query,3);

 	if ($ROOT_RESULTS['id'] == 0) {
		$GOD['0 bug'] = 'ok'; 
	} else {
		$GOD['0 bug'] = 'chie : ' . url('repair', '?p=admin_panel&action=0bug'); 
	}
 
 // CHECK FOLDER PERMISSIONS
  	if($_GET['action'] == 'perm_files') {
		$conn_id = ftp_connect(SITE_IP) /* or (die("Couldn't connect to $ftp_server"))*/;
		$login_result = ftp_login($conn_id, SITE_USERNAME, SITE_PASSWORD);
		//ftp_chdir($conn_id, 'files');
		$result = ftp_site($conn_id, 'SITE CHMOD 777 /httpdocs/files');
		
	e($result);	
		//header("Location:?p=$this_page"); 
	}
 
	$GOD['permissions - files'] 		= substr(decoct(fileperms(SITE_FILES_PATH)),2) . url(' 777',  '?p=admin_panel&action=perm_files');
	$GOD['permissions - install'] 		= substr(decoct(fileperms(SCORPIO_INSTALL_PATH)),2); 
 
 // IMPORT CONTENTS TREE FROM FILE	
 	$IMPORT_FILES 	= dir_scan(SCORPIO_INSTALL_PATH . '/');
 
	$GOD['import contents tree'] = 'files in folder ' . implode(BR,$IMPORT_FILES['FILES']);


	$this_page = $_GET['p'];	
	
	// SHIP THIS PAGES IN THEIR MOD INSTALL FOLDER
//	$PAGES_TO_CHECK = array(	array('name' => "home",			'label_fr' => "Accueil", 		'allowed' => 1),
//								array('name' => "admin_stats", 'label_fr' => "admin_stats", 'label_en' => "admin_stats", 'allowed' => 5, 'pid' => "admin_page",
//												//'CHILDS' => array(array('name' => "rte",	'label_fr' => "rte", 'label_en' => "rte", 'type' => 18),
//												//				  array('name' => "html_admin_stats",	'label_fr' => "rte", 'label_en' => "rte", 'type' => 18, 'pid' => 570),
//												//			)
//									 ),
//								//array('name' => "fulldestyle",	'label_fr' => "fulldestyle", 	'allowed' => 5),
//	
//							);
//	
//	foreach ($PAGES_TO_CHECK as $PAGE) {
//		$page_name = $PAGE['name'];
//		$NEW_PAGE = $PAGE;
//		unset($NEW_PAGE['CHILDS']);
//		
//		if (list_search("contents", "name", $page_name, "name") == "") {
//			if (isset($_GET[$page_name]) && $_GET[$page_name] == "install") {
//				if (is_allowed(6)) {
//					$new_id = page_add($NEW_PAGE);
//						if (isset($PAGE['CHILDS'])) {
//						
//						//e($PAGE['CHILDS']);
//							$new_pid = $new_id ;
//							
//							foreach ($PAGE['CHILDS'] as $CONTENT) {
//							//e($CONTENT);
//								$CONTENT_INI = array("table_name" 	=> "contents");
//								if (isset($CONTENT['pid'])) {$CONTENT['pid']	= "|" . $CONTENT['pid'] . "|";} else {$CONTENT['pid']	= "|" . $new_id . "|";}	
//																	
//								list_item_add($CONTENT,$CONTENT_INI);
//							}			
//						}
//						
//					header("Location:?p=$this_page");
//				} 
//			} else {
//				$message_html .= "<div style=\"text-align:center\">Page $page_name : inexistante <a href=\"?p=$this_page&$page_name=install\" >installer</a></div>";
//			}
//		} else {
//			$message_html .= "<div style=\"text-align:center\">Page $page_name : OK</div>";
//		}
//	}
//
//	$return .= $message_html;	
//	
//	
//	
//	
//
//	



	
/// SYS STATS
	$GOD['stats - clear'] = url('clear stats', '?p=admin_panel&action=clearstats');

 	if($_GET['action'] == 'clearstats') {
		$query = "TRUNCATE TABLE `sys_stats`"; 
		$DB->query($query);
		
		header("Location:?p=$this_page"); 
	}	
	
	$table_name = "sys_stats";	

	if (!$DB->table_exist($table_name)) {
		if (isset($_GET[$table_name]) && $_GET[$table_name] == "install") {
			if (is_allowed(6)) { ein();
				$table_query = "
					CREATE TABLE `sys_stats` (
					  `id` int(11) NOT NULL auto_increment,
					  `cdate` int(11) NOT NULL default '0',
					  `page` varchar(150) NOT NULL default '',
					  `referer` varchar(150) NOT NULL default '',
					  `ip` varchar(16) NOT NULL default '',
					  `browser` varchar(50) NOT NULL default '',
					  `chrono` float NOT NULL default '0',
					  `lang` tinyint(2) NOT NULL default '0',
					  `userid` int(11) NOT NULL default '0',
					  `cache` tinyint(1) NOT NULL default '0',
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `id` (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;		
					";	
					
				$DB->query($table_query);
				
				header("Location:?p=$this_page");
			}
		} else {
			$GOD['missing table - stats']  = "<div style=\"text-align:center\">Table $table_name : inexistante <a href=\"?p=$this_page&$table_name=install\" >installer</a></div>";
		}			
	} else {
		$GOD['missing table - stats'] = "<div style=\"text-align:center\">Table $table_name : OK</div>";
	}	

/// SYS CACHE
	$table_name = "sys_cache";

	if (!$DB->table_exist($table_name)) {
		if (isset($_GET[$table_name]) && $_GET[$table_name] == "install") {
			if (is_allowed(6)) {
				$table_query = "		
					CREATE TABLE `sys_cache` (
					  `id` varchar(255) NOT NULL default '',
					  `html` text NOT NULL,
					  `cdate` int(11) NOT NULL default '0',
					  UNIQUE KEY `id` (`id`),
					  FULLTEXT KEY `html` (`html`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
					";
					
				$DB->query($table_query);
				
				header("Location:?p=$this_page");
			}
		} else {
			$GOD['missing table - cache'] = "<div style=\"text-align:center\">Table $table_name : inexistante <a href=\"?p=$this_page&$table_name=install\" >installer</a></div>";
		}			
	} else {
		$GOD['missing table - cache'] = "<div style=\"text-align:center\">Table $table_name : OK</div>";
	}


/// ADMIN PANEL
	
	foreach ($GOD as $row_label => $row_value) {
		$row_html .= tr(td(b($row_label), array('align' => 'right','valign' => 'top')) . td($row_value));
	}

	$return = table($row_html);
	
?>