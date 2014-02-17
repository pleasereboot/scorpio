<?php 

	global $CORE;
	
	$DB = new db();

	$list_name 	= "account";
	$user_id	= $CORE['USER']['id'];


		switch($_GET['m']){
			case "account_new":
				if ($CORE['SESSION']['userid'] == 1 || is_allowed(5)) {					
					$PAR['pid'] = 35;
					$PAR['FIELDS'] = array('lang' => 1, 'status' => 5, 'conf_number' => shuffle_id(32), 'allowed' => "1,2");
					
					$new_id 	= contents_new(3, "user", $PAR, "users");
					
					$SESSION = new session();
					
					if ($new_id != 0 && !is_allowed(5)) {
					/// SET USER OWNER TO NEW USER ID	
						$query = "UPDATE `users` SET `owner` = $new_id WHERE `id` = $new_id"; 
						$DB->query($query);					
					
						$session_id = $SESSION->create_session($new_id);
						$result = $SESSION->create_session_db($session_id);
						
						if ($result == 1) {
							$_SESSION['id'] = $session_id;
						} else {
							echo "cannot create db session";
							exit;
						}
					}			
					
					$page 		= "p=account&account_newedit=$new_id";
					goto($page);
				} else {
					$return .= BR . BR . 'un compte est déjé en cours' . BR . BR;
					$return .= url('voir votre compte', "?p=account&account_newedit=$user_id");					
				}
				
			break;		
		
			case "account_newedit":
			/// SET EDIT ID
				if (isset($_GET[$list_name . "_id"])) {$edit_id = $_GET[$list_name . "_id"];}	else {$edit_id = $user_id;}
				
				if ($edit_id == $CORE['SESSION']['userid'] && $CORE['SESSION']['userid'] != 1 || is_allowed(5)) {
				/// USER PARSE	
					if (is_allowed(5)) {$return .= div(url("retour à la liste","?p=admin_users"),array('style' => 'clear:both;','align' => 'center'));}

					$return .= BR . BR . 'Vous devez entrer ces informations afin de créer votre compte : ' . BR . BR;
				
					$USER_INI = array(	'list' 		=> $list_name,
										'table' 	=> "users",
										'rs_name' 	=> "userslist",
										'ci_name' 	=> "userslist", 
										'template'	=> "userslist",
										'sys'		=> 1,
										'item_id' 	=> $edit_id,
										'mode' 		=> "list",
										'mod'		=> "mod_account",
										'add'		=> "false",
										'edit'		=> 1,
										'form_url'	=> "?p=account&account_sendconf=1",
									  );
										
					$GENRE   = list_ini($USER_INI);
					
					$return .= list_parse($USER_INI);
					
					$return .= BR . BR . 'vous recevrez un courriel afin de vérifier votre adresse';
				} else {
					$return .= div("Ce compte ne vous appartient pas !",array('style' => 'clear:both;height:200px;vertical-align:middle;','align' => 'center'));
				}
				
			break;		

			case "account_sendconf":
			/// USER PARSE	
				if (is_allowed(5)) {$return .= div(url("retour à la liste","?p=admin_users"),array('style' => 'clear:both;','align' => 'center'));}
			
				$USER_INI = array(	'list' 		=> $list_name,
									'table' 	=> "users",
									'rs_name' 	=> "userslist",
									'template'	=> "userslist",
									'sys'		=> 1,
									'item_id' 	=> $user_id,
									'mode' 		=> "list",
									'mod'		=> "mod_account",
									'add'		=> "false",
									'edit'		=> 1,
									//'form_url'	=> "?p=account&account_sendconf",
								  );
									
				$GENRE = list_ini($USER_INI);
			
				$USER = $LIST[$list_name]['ITEMS'][$user_id];
				//e($USER,1);
				if ($USER['status'] == 5 && $USER['email'] != "" && $USER['firstname'] != "" && $USER['lastname'] != "" && $USER['password'] != "") {
				/// HEADERS		
					//$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=ISO-8859-1\n";	
					$headers .= "From: " . "Scorpio" . " <" . "noreply@scorpioserver.com" . ">\r\n";
					$headers .= "Reply-To: " . $name . " <" . $mail . ">\r\n";
					$headers .= "Return-Path: " . $name . " <" . $mail . ">\r\n";
					//$headers .= 'Bcc: Yannick Menard <yannick_menard@hotmail.com>' . "\r\n";
					
				/// MESSAGE	
					$confirm_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?p=account&account_confirm=' . $USER['conf_number'];
								
					$message = 'pour confirmer le compte, cliquer sur le lien ci-dessous <br />
								<a href="' . $confirm_url . '">' . $confirm_url . '</a>';

					$mail_result = mail($USER['email'], "new user : " . $USER['firstname'], $message, $headers);

					if ($mail_result == 1) {
						$query = "UPDATE `users` SET `status` = 3 WHERE `id` = $user_id"; 
						$DB->query($query);	
						
						$pass_md5 = md5($CORE['USER']['password']);
						$query = "UPDATE `users` SET `password` = '$pass_md5' WHERE `id` = $user_id"; 
						$DB->query($query);
																	
						$return .= "un courriel vous a été envoyé pour confirmer votre adresse !";
						$return .= BR . url('retour à l\'accueil', '?p=home');
					} else {
						$return .= "oops";
					}
				} else {  // chie solide, apra le mail() ca redirect tout seul et revient ici... jama vu ca
					$return .= "un courriel vous a été envoyé pour confirmer votre adresse !!";
					$return .= BR . url('retour à l\'accueil', '?p=home');
					//$return .= "oops de criss";
					//goto($page);						
				}
				
			break;

			case "account_confirm":
				$query   = "SELECT * FROM users WHERE `conf_number` = '" . $_GET[$list_name . "_confirm"] . "'"; 
				$RESULTS = $DB->select($query,3);	
				
				$user_id = $RESULTS['id'];
				if (APPROVE_USER) {$status = 4;} else {$status = 1;}
				
				if (count($RESULTS) >= 1 && $RESULTS['status'] != 1) {
					$query = "UPDATE `users` SET `status` = $status WHERE `id` = $user_id ; ";
					$DB->query($query);	

					$query = "UPDATE `users` SET `allowed` = '1,2,3' WHERE `id` = $user_id ; ";
					$DB->query($query);	
					 
					if ($user_id != 0) {
						$session_id = $SESSION->create_session($user_id);
						$result = $SESSION->create_session_db($session_id);
						
						if ($result == 1) {
							$_SESSION['id'] = $session_id;
							//goto();
						} else {
							echo "cannot create db session";
							exit;
						}
					}
										
					$return .= "courriel confirmé, vous pouvez maintenant modifier votre ";	
					$return .= url('compte', '?p=account');		
				} else {
					$return .= "votre courriel est déjà confirmé !";	
				}
				
			break;

			case "account_edit":
				if ($CORE['USER']['status'] != 5) {
				/// SET EDIT ID
					if (isset($_GET[$list_name . "_edit"]) && $_GET[$list_name . "_edit"] != '') {$edit_id = $_GET[$list_name . "_edit"];}	else {$edit_id = $user_id;}

					if ($edit_id == $CORE['SESSION']['userid'] && $CORE['SESSION']['userid'] != 1 || is_allowed(5)) {
					/// USER PARSE	
						if (is_allowed(5)) {$return .= div(url("retour à la liste","?p=admin_users"),array('style' => 'clear:both;','align' => 'center'));}
			
						$USER_INI = array(	'list' 		=> $list_name,
											'table' 	=> "users",
											'rs_name' 	=> "userslist",
											'ci_name' 	=> "userslist",
											'template'	=> "userslist",
											'sys'		=> 1,
											'item_id' 	=> $edit_id,
											//'mode' 		=> "list",
											'mod'		=> "mod_account",
											'add'		=> "false",
											'form'		=> 1,
											'edit'		=> 1,
											//'limit'		=> 1,
										  );
											
						$GENRE   = list_ini($USER_INI);
						
						if ($CORE['USER']['status'] == 5) {goto("p=account&account_newedit=$edit_id");}
				
						$return .= list_parse($USER_INI);	
					} else {
						$return .= div("Ce compte ne vous appartient pas !",array('style' => 'clear:both;height:200px;vertical-align:middle;','align' => 'center'));
					}
				} else {
					$page 		= "p=account&account_newedit";
					goto($page);					
				}
			break;			  
			default: 
				$page 		= "p=account&account_edit=$user_id";
				goto($page);			
			
		}
	//}
	
?>