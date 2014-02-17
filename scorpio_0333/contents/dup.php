<?php 

	global $CORE;
	global $LIST;
	
	function build_request($site_from, $site_to, $id_from, $id_to) {
		$request = "?p=admin_dup";
		
		if ($site_from !="") {$request .= "&site_from=$site_from";}
		if ($site_to !="") {$request .= "&site_to=$site_to";}
		if ($id_from !="") {$request .= "&id_from=$id_from";}
		if ($id_to !="") {$request .= "&id_to=$id_to";}
		
		return $request;
	}	
		
	if (isset($_POST['b_dup'])) {
		contents_tree_duplicate ($_GET['id_from'], $_GET['id_to'], $_GET['site_from'], $_GET['site_to']);
		$redirect = build_request( $_GET['site_from'], $_GET['site_to'], $_GET['id_from'], $_GET['id_to']);
		header("Location:$redirect");	
	} else { 
	/// SETUP QUERY VARS
		if (isset($_GET['site_from'])) {$site_from = $_GET['site_from'];} else {$site_from = $CORE['SITE']['id'];}
		if (isset($_GET['site_to'])) {$site_to = $_GET['site_to'];} else {$site_to = $CORE['SITE']['id'];}
		if (isset($_GET['id_from'])) {$id_from = $_GET['id_from'];} else {$id_from = "";}
		if (isset($_GET['id_to'])) {$id_to = $_GET['id_to'];} else {$id_to = "";}
	
	/// LIST SITES				
		$LIST['SITES'] = db_select("sites",array('db' => -1));
		$SITES = &$LIST['SITES']['DATA'];
		
		$html .= "<table width=\"75%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">";

		foreach ($SITES as $SITE) {
			$html .= "<tr>
						<td width=\"45%\">
							<a href=\"" . build_request($SITE['id'], $site_to, $id_from, $id_to) . "\">" . $SITE['name'] . "</a>" . 
							"</td><td width=\"10%\"></td><td width=\"45%\">" . "<a href=\"" . build_request($site_from, $SITE['id'], $id_from, $id_to) . "\">" . $SITE['name'] . "</a>"
					  .	"</td>
					  </tr>";
		}	

	/// ACTUAL SITE INFO
		if ($site_from != "") {$site_from_name = $SITES[$site_from]['name'];}
		if ($site_to != "") {$site_to_name = $SITES[$site_to]['name'];}
		if ($id_from != "") {$id_from_name = $LIST['contents']['DATA'][$id_from]['label_fr'];}
		if ($id_to != "") {$id_to_name = $LIST['contents']['DATA'][$id_to]['label_fr'];}
		
		$html .= "<tr><td><strong>$site_from_name</strong></td><td></td><td><strong>$site_to_name</strong></td></tr>";
		$html .= "<tr><td><strong>$id_from_name</strong></td><td></td><td><strong>$id_to_name</strong></td></tr>";		
		

	/// LIST CONTENTS		
		$html .= "<tr><td valign=\"top\">";
				
		$FROM_TREE = tree_to_list("contents_$db", tree(0,0,array('db'  => $site_from,'gen'  => 4)));

		foreach ($FROM_TREE as $CONTENT) {
			$html .= spacer($CONTENT['level'], "--") . "<a href=\"" . build_request($site_from, $site_to, $CONTENT['id'], $id_to) . "\">" . $CONTENT['label_fr'] . "</a><br />";
		}
		
		$html .= "</td><td></td><td valign=\"top\">";
		
		$TO_TREE = tree_to_list("contents_$db", tree(0,0,array('db'  => $site_to,'gen'  => 4)));

		foreach ($TO_TREE as $CONTENT) {
			$html .= spacer($CONTENT['level'], "--") . "<a href=\"" . build_request($site_from, $site_to, $id_from, $CONTENT['id']) . "\">" . $CONTENT['label_fr'] . "</a><br />";
		}		
		
		$html .= "</td></tr>";
		$html .= "</table>";
		
		$html .= "
				<form action=\"\" method=\"post\" name=\"dup\" onsubmit=\"dup\">
					<input name=\"site_from\" type=\"hidden\" value=\"$site_from\">
					<input name=\"site_to\" type=\"hidden\" value=\"$site_to\">
					<input name=\"id_from\" type=\"hidden\" value=\"$id_from\">
					<input name=\"id_to\" type=\"hidden\" value=\"$id_to\">
					<center><input name=\"b_dup\" type=\"submit\" id=\"b_dup\" value=\"DUPLICATE\">
				</form>
		";
		
		$return = $html;	
	}
	
?>