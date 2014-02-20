<?php 
	global $CORE;

	if ($PAR['type'] == 'small') {
		$account_file_html 		= t_load_file("account_file", "session", false, 'mod_session/themes/default/templates/');	
		$account_login_html 	= t_set_block ("account_file", "ACCOUT_SMALL_LOGIN");

		$LOGIN_VARS	= array("LOGIN_USERNAME"			=> lang_arr(array('Courriel', 'Email')), 
										"LOGIN_PASSWORD" 		=> lang_arr(array('Mot de passe', 'Password')),
										"B_LOGIN_LABEL"				=> lang_arr(array('Se connecter', 'Login')), 
										);	
		
		$return	= set_var($account_login_html, $LOGIN_VARS);
		
		
	} else {
		switch(MODE_GET()){
			case "login":
				if (isset($CORE['POST']['b_login'])) {
					$SESSION = new session();
		
					$username = $_POST['username']; //$CORE['POST_VAR']['username'];
					$password = $_POST['password']; //$CORE['POST_VAR']['password'];
					$user_id = $SESSION->login($username,$password);
					 
					if ($user_id != 0) {
						$session_id = $SESSION->create_session($user_id);
						$result = $SESSION->create_session_db($session_id);
						
						if ($result == 1) {
							$_SESSION['id'] = $session_id;
						} else {
							echo "cannot create db session";
							exit;
						}
						
						goto_url('p=' . PAGE_AFTER_LOGIN); //v3.25
					}	
				}				
			break;		
			
			case "logout":
				unset($_SESSION['id']);
				goto_url();
			break;			  

			default:
				if ($CORE['USER']['id'] == 1 || is_allowed(5)) {
					if ($PAR['create'] != 'false') {
						$create_html = '<tr>
											<td align="center">
												<br />
												<a href="?p=account&account_new">[créer un compte]</a>
												<br />
											</td>
										</tr>';
					}			
			
					$return .= '
						<table width="100%">
							<tr>
								<td height="75" align="center" valign="top"><br>
									<br />
									<form name="loginform" method="post" action="?p=session&m=login">
										nom d\'usager (courriel)
										<br />
										<input name="username" type="text" value="" size="50">
										<br />
										mot de passe
										<br />
										<input name="password" type="password" size="50">
										<br />
										<br />
										<input type="submit" name="b_login" value="se connecter">
									</form>	
								</td>
							</tr>'
							. $create_html .
						'</table>
					';				
				}
				
				if ($CORE['USER']['id'] != 1) {
					if ($PAR['edit'] != 'false') {
						$edit_html = '	<br />
										<a href="?p=account&account_edit">[modifier mon compte]</a>	';
					}
				
					$return .= '
						<table width="100%">
							<tr>
								<td align="center">
									' . $edit_html . '
									<br />
									<a href="?p=session&m=logout">[se déconnecter]</a>
									<br />	
								</td>
							</tr>
						</table>
					';				
				}	

				$return .= BR.BR.BR.BR;
			
			break;		  
		}
	}
?>