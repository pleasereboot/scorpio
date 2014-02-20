<?php 

	/* SCORPIO engine - class_session.php - v2.5		*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2007-01-22	 						*/	
	/* KAMELOS MARKETING INC	163/220					*/

	class scorpio {
		var $CORE;
		var $LIST;
		var $SESSION;
		var $DOMAINS;
		
		var $domain_active;
		var $cached = false; // contain cached html or false
	
		function scorpio() {
			$this->CORE 	= &$GLOBALS['CORE'];
			$this->LIST 	= &$GLOBALS['LIST'];
			$this->SESSION	= &$GLOBALS['SESSION'];
			$this->DOMAINS	= &$GLOBALS['DOMAINS'];
			
			@require_once(SCORPIO_FUNCTIONS_PATH . "commons.php");
		}
			
		function domain_set() {
			$domain_full = str_replace(array('.com','.ca','.biz'),array('','',''),str_replace('www.','',$_SERVER['HTTP_HOST']));

			$this->domain_active = $domain_full;	
		}			
			
		function ini_functions($PAR) { // juste plate que je peux pas is_allowed
			foreach ($PAR as $include) {
				$result = @require_once(SCORPIO_FUNCTIONS_PATH . $include . ".php");
				if ($result != 1) {
					
				}
			}
			
			set_function("ini_functions", implode(",", $PAR));
		}
	
		function ini_classes($PAR) { // juste plate que je peux pas is_allowed
			foreach ($PAR as $include) {
				$result = @require_once(SCORPIO_CLASSES_PATH . $include . ".php");
				if ($result != 1) {
					
				}
			}
			
			set_function("ini_classes", implode(",", $PAR));
		}	
	
		function ini_types($PAR) { // juste plate que je peux pas is_allowed
			foreach ($PAR as $include) {
				$result = @require_once(SCORPIO_TYPES_PATH . $include . ".php");
				if ($result != 1) {
					
				}
			}
			
			set_function("ini_types", implode(",", $PAR));
		}		
		
		function load_site() {
			$this->CORE['SITE'] = db_select("sites",array('id' => SITE_NAME, 'db' => -1, 'type' => 3));
			
			set_function("load_site", SITE_NAME);
		}
	
		function load_tables() {
			$DB 	= new db();
			
			$query = "SELECT r.*, i.* FROM sys_relations AS r LEFT JOIN (sys_structures AS i) ON (i.id=r.cid) WHERE vid = 510";
			
			$this->CORE['TABLES'] 	= $DB->select($query,11);

			set_function("load_tables", $return);
			
			return $return;
		}		
	
		function lang_set() {  //v3.26
			if (!isset($_SESSION['lang'])) {
				$lang = LANG_DEFAULT;
		
				if ($this->DOMAINS != '' && in_array($this->domain_active,$this->DOMAINS)) { // handle custom domain lang //v3.28 in_array
					$lang = $this->DOMAINS[$this->domain_active]['lang'];
				}
				
				$this->SESSION->switch_lang($lang);
				$this->clear_cache();
				
				$page = qs_load();
				goto_url($page);
			}	
			
			if (isset($_GET['lang'])) {
				$this->SESSION->switch_lang($_GET['lang']);
				unset($this->CORE['QS']['lang']);
				
				$this->clear_cache();
				
				$page = qs_load();
				goto_url($page);
			}			

			return $return;
		}	
	
		function load_contents() {
			$this->LIST['contents'] = db_select("contents",array('tree'=>true));
			
		/// for customs v3.20
			include_once("contents/custom_types.php");
			
			set_function("load_contents", SITE_NAME);
		}
		
		function load_types() { // faut mettre ca dans contents
			$this->LIST['types'] = db_select("types", array('db' => -1)); 
			
			set_function("load_types", SITE_NAME); 
		}
		
		function load_groups() { // faut mettre ca dans contents
			$this->LIST['groups'] = db_select("groups");
			
			set_function("load_groups", SITE_NAME);
		}		
						
		function session_initiate() { // faut mettre ca dans contents
			$this->SESSION = new session();	
			$this->SESSION->start();
			
			set_function("session_initiate", SITE_NAME);
		}
		
		function set_css_link($css,$sys=0,$mod=0,$type=0) {
			if ($type == 0) {
				if ($mod == 0) {
					if ($sys == 0) {
						$css_path = SITE_CSS_PATH;
					} else {
						$css_path = SCORPIO_CSS_PATH;
					}
				} else {
					if ($sys == 0) {
						$css_path = SITE_CONTENTS_PATH;
					} else {
						$css_path = SCORPIO_CONTENTS_PATH;
					}				
				}
			} else {
				$css_path = SCORPIO_TYPES_PATH;
			}
						

			//if (@array_search($css_path . $css . ".css", $this->CORE['PAGE']['CSS_LINK']) === false) {		
				$this->CORE['PAGE']['CSS_LINK'][] = $css_path . $css . ".css";
			//}
			
			set_function("set_css", $css . " - " . $sys);
		}	
		
		function parse_css_link() {
			if (is_array($this->CORE['PAGE']['CSS_LINK'])) {
				foreach ($this->CORE['PAGE']['CSS_LINK'] as $css) {
					$return .= "\n\t\t<link href=\"$css\" rel=\"stylesheet\" type=\"text/css\">";
				}
			}
			
			set_function("parse_css_link", "css");
			
			return $return;
		}			

		function set_css($css_name, $css_value) {
			$this->CORE['PAGE']['CSS'][$css_name] = $css_value;	
			
			set_function("set_css", "$js - $sys - $pos");
		}

		function parse_css() {
			if (is_array($this->CORE['PAGE']['CSS'])) {
				foreach ($this->CORE['PAGE']['CSS'] as $css_name => $css_value) {
					$css .= $css_name . ' { ' . $css_value . ' } ';
				} 
				
				$css_html = 
				 '<STYLE type="text/css">' . 
					$css . 
				'</STYLE>';
			}


			
			set_function("set_css", "$js - $sys - $pos");
			
			return $css_html; 
		}
		
		function set_js($js,$sys=0,$pos=0) {
			if ($pos == 0) {
				$js_pos = "TOP";
			} else {
				$js_pos = "BOT";
			}	
				
			//if (@array_search($js, $this->CORE['PAGE']['JS'][$js_pos]) === false) {				

				$this->CORE['PAGE']['JS'][$js_pos][] = $js;	
			//}		
			
			set_function("set_js", "$js - $sys - $pos");
		}	
					
		function parse_js($pos=0) {
			if ($pos == 0) {
				$JS = $this->CORE['PAGE']['JS']['TOP'];
			} else {
				$JS = $this->CORE['PAGE']['JS']['BOT'];
			}			

			if (is_array($JS)) {
				foreach ($JS as $js) {
					$return .= "\n\t\t<script type=\"text/javascript\" language=\"javascript\" src=\"$js\"></script>";
				}			
			}
			
			set_function("parse_js", "js");
			
			return $return;
		}	
		
		function last_updated() {
			$time = time();
			
			$DB = new db(-1);
			
			$id = $this->CORE['SITE']['id'];
			
			$query 		= "UPDATE `sites` SET `mdate` = '$time' WHERE `id` = $id";
			$DB->query($query);

			set_function("last_updated", $time);
			
			return $time;
		}
		
		function is_cached() {
			$DB 		= new db();
			
			if (CACHE) {  //v3.22
				$id 		= qs_load();//$this->CORE['SESSION']['active_url'];
				if ($id == "") {$id = "?p=home";} // replace home par CONSTANT	
				
				$query 		= "SELECT * FROM `sys_cache` WHERE `id` = '$id'";
				$RESULT 	= $DB->select($query,3);
	
				if ($RESULT['html'] != "") {
					$this->cached = $RESULT['html'];
					$return = true;
				} else {
					$return = false;
				}
			}
			
			set_function("is_cached", $return);
			
			return $return;
		}		
		
		function load_cache() {
			$html = $this->cached;
			
			set_function("load_cache", true);
			
			return $html;
		}		
					
		function set_cache($html) {
			$DB 		= new db();
			
			$cdate = time();
			$id 		= qs_load();//$this->CORE['SESSION']['active_url'];
			if ($id == "") {$id = "?p=home";} // replace home par CONSTANT
			
			$html = addslashes($html);
			
			$query 		= "INSERT INTO `sys_cache` (`id`, `html`, `cdate`) VALUES ('$id', '$html', '$cdate');";		
			$result 	= $DB->query("$query");

			set_function("set_cache", $result);	
			
			return $result;
		}
		
		function update_cache() {
			//$html = $this->cached;
			
			set_function("set_cache", $id);
			
			return $html;
		}		
		
		function clear_cache($clear_all=0) {
			$DB 		= new db();
			
			unset_action();

			if ($clear_all) {		
				$query 		= "TRUNCATE TABLE `sys_cache`";							 	
				$RESULT 	= $DB->query($query);
				
				set_function("clear_cache_all", true);
			} else {
				$location 	= qs_load();
	
				$id 		= $location;
				
				if ($id == "") {$id = "?p=home";} // replace home par CONSTANT	
				
				$query 		= "DELETE FROM `sys_cache` WHERE `id` = '$id'";							 	
				$RESULT 	= $DB->select($query,3);
				
				set_function("clear_cache", true);			
			}
			
			return true;
		}		



		
						
	}










?>