<?php 

	/* SCORPIO engine - class_session.php - v2.5		*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2007-01-22	 						*/	
	/* KAMELOS MARKETING INC	163/220					*/

	class session {
		var $CORE = array();
		var $LIST;
 		var $DB;
		
		function session() {
			$this->CORE = &$GLOBALS['CORE'];
			$this->LIST = &$GLOBALS['LIST'];
			$this->DB = new db();
		}
		
		function start() {
			$this->clean(30,24*60);   //a mettre dans un ini keke part

			if (isset($_SESSION['id'])) {;
				$user_id = $this->load_session($_SESSION['id']);
				$this->load_user_profile($user_id);
				$this->update();
			} else {
				$user_id = 1;
				$this->load_user_profile($user_id); ///ramasser le guest id dans sys_clients
				$session_id = $this->create_session($user_id);
				$result = $this->create_session_db($session_id);
				
				if ($result == 1) {
					$_SESSION['id'] = $session_id;
					$this->hit();
				} else {
					echo "cannot create db session";
					exit;
				}
			}
			
			set_function("session->start", "$user_id");
		}
		
		function load_session($session_id) {
			$query = "--  load_session $session_id
						  SELECT *
						  FROM `sessions`
						  WHERE `id` = '$session_id' AND `status` = 1
					 ";
			
			$RESULTS = $this->DB->select($query, 3);	
												
			if (is_array($RESULTS)) {  // if status = 2, you've been bumped
				$this->CORE['SESSION'] = $RESULTS;
			} else 	{
				$this->create_session(1);
				$this->create_session_db(1);
			}
			
			set_function("session->load_session", "$session_id");
			return $this->CORE['SESSION']['userid'];
		}
		
		function load_user_profile($user_id) {
			$this->CORE['USER']		= db_select("users",array('id'=>$user_id, 'type'=>3));	
			
			if (!is_array($this->CORE['USER'])) { // v3.23
				unset($_SESSION['id']);
				goto_url();				
			}
			
			$this->CORE['GROUPS'] 	= explode(",", $this->CORE['USER']['allowed']);
			
			set_function("session->load_user_profile", "$user_id | ". $this->CORE['USER']['groups']);
			return $user_id;
		}

		function create_session($user_id) {
			if ($_GET['p'] == "") {$session_active_page = PAGE_DEFAULT;} else {$session_active_page = $_GET['p'];}
			
			$this->CORE['SESSION']['id'] 			= shuffle_id(32);
			$this->CORE['SESSION']['ip'] 			= $_SERVER['REMOTE_ADDR'];
			$this->CORE['SESSION']['referer'] 		= $_SERVER['HTTP_REFERER'];
			$this->CORE['SESSION']['active_page'] 	= $session_active_page;
			$this->CORE['SESSION']['active_url'] 	= $_SERVER['QUERY_STRING'];
			$this->CORE['SESSION']['userid'] 		= $user_id;
			$this->CORE['SESSION']['lang'] 			= $this->CORE['USER']['lang'];
			$this->CORE['SESSION']['cdate'] 		= time();
			$this->CORE['SESSION']['mdate'] 		= time();
			$this->CORE['SESSION']['status'] 		= 1;
			$_SESSION['id'] 						= $this->CORE['SESSION']['id'];
			
			set_function("session->create_session", "$user_id | ". $_SESSION['id']);
			return $this->CORE['SESSION']['id'];
		}
		
		function create_session_db() {		
			if (is_array($this->CORE['SESSION'])) {
				while (list($key, $value) = each($this->CORE['SESSION'])) {
					$INSERT[$key] = $value;
				}
				
				$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
				$val_item = "'" . implode("','", array_values($INSERT)) . "'";
								
				$query = "--  load_session 
							  INSERT INTO `sessions` ( $val_column ) VALUES ( $val_item)";
							   
				$result =  $this->DB->query("$query");	
				
				set_function("session->create_session", "$user_id | ". $_SESSION['id']);
				return $result;				
			}	
		}		

		function login($username,$password) {
			if($username != "") {
				//if(	ctype_alnum($username)){
					if($password != "") {
						if(	ctype_alnum($password)){
							$query = "SELECT * 
									  FROM `users`
									  WHERE `email` = '$username' 
									  OR `user_name` = '$username' ";
														
							$RESULTS = $this->DB->select($query,3);	
		
							if(is_array($RESULTS)){
								$USER = $RESULTS;
		
								if(md5($password) == $USER['password']) {
									$return = $USER['id'];
								} else {
									set_message("login failed", "mot de passe incorrect", 2);
								}
							} else{
								set_message("login failed", "utilisateur non trouvé", 2);
							}					// valid
						
						
						}else{
							set_message("login failed", "mot de passe non conforme", 2);
						} 
					} else {
						set_message("login failed", "manque password", 2);
					}
//				}else{
//					set_message("login failed", "utilisateur non conforme", 2);
//				} 	
			} else {
				set_message("login failed", "manque username", 2);
			}
			
			return $return;
		}

		function clean($expire, $kill) {
			$now = time();
			$expired = $now - ($expire * 60);
			$killed = $now - ($kill * 60);
			
			$query = "--  session->clean 
						  UPDATE `sessions` SET `status` = '2' WHERE mdate < $expired AND `userid` NOT IN (0)" ;
			$this->DB->query("$query");				
			
			$query = "--  session->delete 
						  DELETE FROM sessions WHERE mdate < $killed " ;
						  
			$this->DB->query("$query");
			set_function("session->clean", "$expire | $kill");			
		}
		
		function update() {
		
			$now 					= time();
			$session_date 			= $now;
			$session_id				= $_SESSION['id'];
			//$session_active_page 	= $this->CORE['GET_VAR']['p'];
			$session_active_url 	= $_SERVER['QUERY_STRING'];
			$session_previous_url 	= $this->CORE['SESSION']['previous_url'];
			
			if ($_GET['p'] == "") {$session_active_page = PAGE_DEFAULT;} else {$session_active_page = $_GET['p'];}

			if (!in_array($session_active_page,$this->LIST['noprevious']) && substr($this->CORE['SESSION']['active_url'],0,4) != "lang" && $session_active_url != $this->CORE['SESSION']['active_url'] && !strstr($this->CORE['SESSION']['active_url'],"_new=true")) {
				//e($session_active_page);
				//e($_SESSION['referer']);
				$session_previous_url 	= $this->CORE['SESSION']['active_url'];	
			}

			$this->CORE['SESSION']['active_page'] 	= $session_active_page;
			$this->CORE['SESSION']['active_url'] 	= $session_active_url;
			
			
			if ($this->CORE['SESSION']['lang'] == "") {
				$this->CORE['SESSION']['lang'] 			= $this->CORE['USER']['lang'];
			}
			$this->CORE['SESSION']['mdate'] 		= $now;
			
			$query = "--  session->update 
						  UPDATE `sessions` SET `active_page` = '$session_active_page', `active_url` = '$session_active_url', `previous_url` = '$session_previous_url',`mdate` = '$session_date' WHERE `id` = '$session_id'" ;
			
			$this->DB->query("$query");	
			set_function("session->update", "$session_id");			
		}		
		
		function hit() {  // bug quand user se logout, ca fait une nouvelle session guess
			$DB = new db(-1);
			
			$site_id 	= $this->CORE['SITE']['id'];
			$ahits 		= $this->CORE['SITE']['hits'] + 1;
			
			$query = "--  session->hit 
						  UPDATE `sites` SET `hits` = '$ahits' WHERE `id` = '$site_id'" ;
			
			$DB->query("$query");
				
			set_function("session->hit", "$session_id");	
		}		
		
		function switch_lang($lang=1) { // a integrer dans le load session, check action
			$session_id						= $_SESSION['id'];
			$this->CORE['SESSION']['lang'] 	= $lang;
			$_SESSION['lang'] 				= $lang;

			$query = "--  session->switch_lang 
						  UPDATE `sessions` SET `lang` = '$lang' WHERE `id` = '$session_id'" ;
			
			$this->DB->query("$query");	
				
			set_function("session->switch_lang", "$lang");	
		}
		
		function stats($chrono_end,$from_cache) {	//sortir les par de la
			if (!is_allowed(6) && STATS) { //v3.22
				if ($_GET['p'] == "") {$page = PAGE_DEFAULT;} else {$page = $_GET['p'];}
				if ($from_cache == " from cache") {$cache = 1;} else {$cache = 0;}
				
				if ($_SERVER['HTTP_REFERER'] != "") {
					if (strstr($_SERVER['HTTP_REFERER'],"http://www." . $this->CORE['SITE']['label_fr']) || strstr($_SERVER['HTTP_REFERER'],"http://" . $this->CORE['SITE']['label_fr'])) {// tentative
						$referer = "local";
					} else {
						$referer = $_SERVER['HTTP_REFERER'];
					}
				} else {
					$referer = "direct";
				}
			
				$INSERT = array(
								"cdate" 		=> $this->CORE['SESSION']['mdate'],
								"page" 			=> $page,
								"ip" 			=> $_SERVER['REMOTE_ADDR'],
								"referer" 		=> $referer,
								"chrono"		=> $chrono_end,		
								"lang" 			=> $this->CORE['SESSION']['lang'],
								"userid" 		=> $this->CORE['SESSION']['userid'],
								"cache" 		=> $cache,
								);
								
				$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
				$val_item = "'" . implode("','", array_values($INSERT)) . "'";
								
				$query = "--  stats 
							  INSERT INTO `sys_stats` ( $val_column ) VALUES ( $val_item)";
							   
				$result =  $this->DB->query("$query");	
				
				set_function("session->stats", "$user_id | ". $_SESSION['id']);
				return $result;	
			}				
		}	
	}

?>