<?php 

	global $SCORPIO;
	global $CORE;
	
	switch ($_GET['m']) {
		case 'css':
			if (count($_POST) > 0) {
				e($_POST);
			
			} else {
				if (isset($_GET['live_id'])) {
					$css_ress = fopen(SITE_CSS_PATH . 'default.css', 'r');
					$css_html = fread($css_ress, filesize(SITE_CSS_PATH . 'default.css'));
					fclose($css_ress); 
				
					preg_match_all('/(\.?)(' . strtoupper($_GET['live_id']) . '\s*\{)(.*)(\})/', $css_html, $EIN, PREG_SET_ORDER);
					
					$onsubmit = " live_css('live_content','" . $_GET['live_id'] . "',this);";				
					
					$html .= form(input($EIN[0][3], array('size' => 75)), array('form_name' => 'form_live_css', 'onsubmit' => $onsubmit));
					
				}
			}
		break;
		default:
			$html .= span('X CLOSE X', array('onclick' => "document.getElementById('live_content').style.visibility='hidden';"));	 

		/// PARENT PAGE PARSE	
			if (isset($_GET['live_id']) || isset($_POST)) {	
				$PARENT_INI = array(	'list' 		=> "structslist",
										'rs_name' 	=> "structslist",
										'template'	=> "page_parent",
										'sys'		=> 1, 
										'item_id' 	=> $_GET['live_id'],
										'mode' 		=> "list",
										'mod'		=> "mod_admin",
										'add'		=> "false", 
										//'struct'	=> "false",
										'edit'		=> 1, 
									);
									
				$GENRE = list_ini($PARENT_INI); 
				$html .= list_parse($PARENT_INI);
				
			}		

			$html .= span('X CLOSE X', array('onclick' => "document.getElementById('live_content').style.visibility='hidden';"));
		break;
	
	
	}
	
	
	$return = $html;

?>