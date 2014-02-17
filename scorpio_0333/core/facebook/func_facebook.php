<?php

	function fb_tabs($actual) {
		global $PAGES;
	
		$html .= "<fb:tabs> ";
		
		 foreach($PAGES as $name => $PAGE) {
			if($name == $actual) {$selected = "selected='true'";}
			if($PAGE['align'] == '') {$align = "left";} else {$align = "right";}
			if($PAGE['file'] != '') {$file = $PAGE['file'];} else {$file = $name;}
		
			$html .= "<fb:tab-item 
							href='http://apps.facebook.com/jet_set/" . $file . ".php' 
							title='" . $PAGE['title'] . "' 
							align='$align'/> 
							$selected";
		}
	
		$html .= "</fb:tabs>";
		
		return $html;
	}


?>