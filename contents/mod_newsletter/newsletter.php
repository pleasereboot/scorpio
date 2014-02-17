<?php

	/* SCORPIO engine - newsletter.php - v3.17	*/
	/* created on 2008-01-31	 						*/
	/* updated on 2008-01-31	 						*/
	/* YANNICK MENARD									*/

	global $CORE;
	
	$PAR = explode_par($par);

/// FILL TEMPLATE 
	if ((isset($_POST['newsletter_number']) && $_POST['newsletter_number'] == substr($_SESSION['id'],-5,5))
		  && (validate_email($_POST['newsletter_email']))) {

		/// recipients
			$name 		= htmlentities($PAR['name']);
			$mail 		= htmlentities($PAR['mail']);
			
			$to  		= "$name <$mail>";//"Claude Gladu <info@aubergeduzoo.com>";  //Test <yannickmenard@sympatico.ca>

		/// subject
			$subject 	= "NOUVEAU COURRIEL POUR LA LISTE DE DIFFUSION";
			
		/// message
			$message = '
				<html>
					<head>
					 <title>Nouveau courriel pour la liste de diffusion</title>
					</head>
					<body>
						<p><strong>Nouveau courriel pour la liste de diffusion</strong></p>
						<table>
						
							<tr>
								<td width="300">
									Courriel :</td><td>' . htmlentities($_POST['newsletter_email']) . '</td>
							</tr>
						</table>
					</body>
				</html>
			';
		
		/// HEADERS		
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html;charset=ISO-8859-9\n";	
			$headers .= "From: " . "Scorpio" . " <" . "web@scorpioserver.com" . ">\r\n";
			$headers .= "Reply-To: " . $name . " <" . $mail . ">\r\n";
			$headers .= "Return-Path: " . $name . " <" . $mail . ">\r\n";
			$headers .= 'Bcc: Yannick Menard <yannick@ledevin.com>' . "\r\n";
			
		/// MAIL IT
			if (mail($to, $subject, $message, $headers)) {
				//echo "$to - $subject - $message - $headers";
				$return .= "<div style=\"text-align:center\">";
				$return .= "Courriel enregisté !";
				$return .= "	<br>
							<br>
							<br>
							<a href=\"index.php?p=home\">RETOUR À LA PAGE D'ACCUEIL</a>
							";
				$return .= "</div>";			
			} else {
				$return .= "erreur";
			}	
	} else {
		if (!validate_email($_POST['newsletter_email'])) {
			$message .= "<font style=\"color:#FF0000;font-weight:bold;\">Courriel invalide</font><br />";
		}
		
		if (isset($_POST['newsletter_number']) && $_POST['newsletter_number'] != substr($_SESSION['id'],-5,5)) {
			$message .= "<font style=\"color:#FF0000;font-weight:bold;\">Caractères de validation invalides</font><br />";
		}	
		
		if (isset($_POST['newsletter_email'])) {
			$email = htmlentities($_POST['newsletter_email']);
		} else {
			$email = "Votre courriel";
		}
		
		$form_file_html 		= t_load_file("newsletter", "newsletter", false, "contents/newsletter/templates/"); //should come from ini, genre $CORE	
		$form_input_html 		= t_set_block ("newsletter", "EMAIL_INPUT");
	
		$scorpio_path = SCORPIO_PATH;
		$code = substr($_SESSION['id'],-5,5);
	
		$FORM_VARS	= array("NEWSLETTER_EMAIL"		=> $email, 
							"NEWSLETTER_NUMBER" 	=> $code,  // "<img src=\"" . $scorpio_path . "img.php?code=$code\">"
							"NEWSLETTER_MESSAGE" 	=> $message,
	
							);	
		
		$return	 			= set_var($form_input_html, $FORM_VARS);	
	}
	
	
	
	
	
	
?>