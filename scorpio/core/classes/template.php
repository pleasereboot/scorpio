<?php

	/* SCORPIO engine - template.php - v3.18			*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2008-02-14	 						*/	
	/* YANNICK MENARD	163/220							*/

	class templates {
		var $CORE;
		var $TEMPLATES;
		
		function templates($list_name, $INI="") {
			$this->CORE 		= &$GLOBALS['CORE'];
			$this->TEMPLATES 	= &$GLOBALS['TEMPLATES'];
		}

		function load_file($path, $name, $varname="", $ext=".html") {
			global $CORE; 
				
			$fullpath = $path . $file_name . ".html";
	
			if (!in_array($varname,array_keys($TEMPLATES))) {
				if (file_exists($file_path)) {
					$CORE['TEMPLATES'][] = $varname;
					$html = file_get_contents($file_path);
					$TEMPLATES[$varname] = &$html;
					$loaded = "loaded";
				} else {
					set_message("t_load_file" , "file <b>$file_path</b> introuvable", 1); 
					$loaded = "file not exists";
				}
			} else {
				$html = &$TEMPLATES[$varname];
				$loaded = "alreay loaded";
			}			
	
			set_function("t_load_file", "$file_path | $loaded");
			return $html;
		}		
		
		
	}
	
//	function t_load_file($varname, $file_name, $admin=false, $content=false) { // should look for existing file in memory
//		global $CORE;
//		global $TEMPLATES;
//		
//		//$html = false;
//			
//		if ($admin) {
//			if ($content) { // added support for modules 3.17
//				$file_path = SCORPIO_CONTENTS_PATH . $content . $file_name . ".html";
//			} else {
//				$file_path = SCORPIO_TEMPLATES_PATH . $file_name . ".html";
//			}
//		} else {
//			if ($content) { // added support for modules 3.17
//				$file_path = SITE_CONTENTS_PATH . $content . $file_name . ".html";
//			} else {
//				$file_path = SITE_TEMPLATES_PATH . $file_name . ".html";
//			}
//		}
//
//		if (!in_array($varname,array_keys($TEMPLATES))) {
//			if (file_exists($file_path)) {
//				$CORE['TEMPLATES'][] = $varname;
//				$html = file_get_contents($file_path);
//				$TEMPLATES[$varname] = &$html;
//				$loaded = "loaded";
//			} else {
//				set_message("t_load_file" , "file <b>$file_path</b> introuvable", 1); 
//				$loaded = "file not exists";
//			}
//		} else {
//			$html = &$TEMPLATES[$varname];
//			$loaded = "alreay loaded";
//		}			
//
//		set_function("t_load_file", "$file_path | $loaded");
//		return $html;
//	}
//
//	function t_set_block ($parent, $block_name) {
//		global $CORE;
//		global $TEMPLATES;	
//
//		if (!isset($TEMPLATES[$block_name])) { //debug, ITEMS_LIST prend toujours l<existant 
//			$reg = "/[ \t]*<!--\s+BEGIN $block_name\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END $block_name\s+-->\s*?\n?/sm";
//			$result = preg_match_all($reg, $TEMPLATES[$parent], $RESULTS);
//
//			if ($result != 0) {
//				$CORE['TEMPLATES'][] = $block_name;
//				$TEMPLATES[$block_name] = $RESULTS[1][0];
//				
//				$TEMPLATES[$parent] = preg_replace($reg, "{" . "$block_name}", $TEMPLATES[$parent]);
//				$loaded = "loaded";
//			} else {
//				$loaded = "not found";
//				set_message("t_set_block" , "block <b>$block_name</b> introuvable dans fichier <b>$parent</b>", 1);
//			}
//		}
//		
//		set_function("t_set_block", "$block_name | $loaded");
//		return $TEMPLATES[$block_name]; 
//	}
//	
//	function t_set_var($block_name,$VAR,$VALUES = NULL) {
//		global $TEMPLATES;
//		
//		$return = set_var($TEMPLATES[$block_name],$VAR,$VALUES);
//		
//		return $return;
//	}
//	
//	function t_get_var($var_name) {
//		global $TEMPLATES;
//		
//		$return = $TEMPLATES[$var_name];
//		
//		return $return;
//	}	
//	
//	function t_remove_empty($html) {
//		$html = preg_replace('/{[^ \t\r\n}]+}/', "", $html);
//		
//		return $html;
//	}	

	

?>