<?php 

	/* SCORPIO engine - functions_admin.php - v2.5	*/	
	/* created on 2006-12-09	 					*/
	/* updated on 2007-02-23	 					*/	
	/* KAMELOS MARKETING INC	10/0				*/

	
	function  addSepForm($pid="", $action="", $returnUrl="") { 
		global $CORE;
		
		$DB = new db();

		if ($returnUrl !=  "") {$returnUrlValue = "<input name=\"returnUrl\" type=\"hidden\" id=\"returnUrl\" value=\"$returnUrl\"/>\n";}

		$sep_add_form = "
				<br /><br />
				<form id=\"sep_add\" name=\"sep_add\" method=\"post\" action=\"$action\">
					$returnUrlValue

					<input type=\"radio\" name=\"class\" value=\"sep_s\" /> small
					<br />
					<input type=\"radio\" name=\"class\" value=\"sep_l\" checked /> large
					<br />
					<input type=\"radio\" name=\"class\" value=\"other\" /> autre : <input name=\"class_other\" type=\"text\" id=\"class_other_text\" />
					<br />
					
					<input name=\"pid\" type=\"hidden\" id=\"pid\" value=\"$pid\"/>\n				
					<input name=\"b_sepadd_submit\" type=\"submit\" id=\"b_sepadd_submit\" value=\"Ajouter un séparateur\" /><br />
				</form>
				<br /><br />";		

		return $sep_add_form;
	}	
	
	function  addHtmlForm($pid="", $action="", $returnUrl="") { 
		global $CORE;
		
		$DB = new db();

		//if ($pagename !=  "") {$pagenamevalue = " value=\"$pagename\" ";}
		if ($returnUrl !=  "") {$returnUrlValue = "<input name=\"returnUrl\" type=\"hidden\" id=\"returnUrl\" value=\"$returnUrl\"/>\n";}

		$html_add_form = "
				<br /><br />
				<form id=\"page_add\" name=\"html_add\" method=\"post\" action=\"$action\">
					$returnUrlValue
					Name : <input name=\"name\" type=\"text\" id=\"name\" /><br />
					Titre fr : <input name=\"title_fr\" type=\"text\" id=\"title_fr\" /><br />
					Titre en : <input name=\"title_en\" type=\"text\" id=\"title_en\" /><br />

					Titre content : <input type=\"checkbox\" name=\"title_content\" value=\"yes\" /><br />
					
					<input name=\"pid\" type=\"hidden\" id=\"pid\" value=\"$pid\"/>\n				
					<input name=\"b_htmladd_submit\" type=\"submit\" id=\"b_htmladd_submit\" value=\"Ajouter un html\" /><br />
				</form>
				<br /><br />";		

		return $html_add_form;
	}	
	
	function  addPageForm($pagename="", $action="", $returnUrl="") {
		global $CORE;
		$DB = new db();

		if ($pagename !=  "") {$pagenamevalue = " value=\"$pagename\" ";}
		if ($returnUrl !=  "") {$returnUrlValue = "<input name=\"returnUrl\" type=\"hidden\" id=\"returnUrl\" value=\"$returnUrl\"/>\n";}

		$query = "SELECT * FROM `contents`  WHERE `type` = '1' ORDER BY 'name' ;";
		//echo $query."<br>";
		$PAGES_SELECT = $DB->select($query);
	
		$parent_select = "<select name=\"parentpage\">";
		$parent_select .= "<option value=\"|236|\" selected>PAGES</option>";
		
		foreach ($PAGES_SELECT['ROWS'] as $PAGE_OPTIONS) {
			$pid 			= $PAGE_OPTIONS['id'];
			$name		 	= $PAGE_OPTIONS['name'];
			$parent_select .= "<option value=\"$pid\">$name</option>";
		}
	
		$parent_select .= "</select>";
	
		$type_select .= "<select name=\"type\">
							<option value=\"rte\">RTE</option>"; 
							if (is_allowed(6)) {$type_select .= "<option value=\"php\">PHP</option>";}
							if (is_allowed(6)) {$type_select .= "<option value=\"html\">HTML</option>";}
		$type_select .= 	"</select>";
	
		if (!is_allowed(6)) {$par_disabled = "disabled";}
	
		$page_add_form = "
				<br /><br />
				<form id=\"page_add\" name=\"page_add\" method=\"post\" action=\"$action\">
					$returnUrlValue
					Name : <input name=\"pagename\" type=\"text\" id=\"pagename\" $pagenamevalue/><br />
					Titre fr : <input name=\"title_fr\" type=\"text\" id=\"title_fr\" $pagenamevalue/><br />
					Titre en : <input name=\"title_en\" type=\"text\" id=\"title_en\" $pagenamevalue/><br />
					parent page : $parent_select <br />
					type : $type_select <br />
					par : <input name=\"par\" type=\"text\" id=\"par\" $par_disabled /><br />
					div : <input name=\"div\" type=\"text\" id=\"div\" $par_disabled /><br />
					___________________<br /><br />
					sub par : <input name=\"subpar\" type=\"text\" id=\"subpar\" $par_disabled /><br />
					sub div : <input name=\"subdiv\" type=\"text\" id=\"subdiv\" $par_disabled /><br /><br />
					<input name=\"b_pageadd_submit\" type=\"submit\" id=\"b_add_submit\" value=\"Ajouter la page\" /><br />
				</form>
				<br /><br />";	

		return $page_add_form;
	}

	function  rs_get($table, $rs) {
		global $CORE;
		
		if (list_search($table, "name", "$rs", "name") == false) {			
			$DB = new db();
			$time = time();
			
			$INSERT = array("pid" =>"|36|","name" =>$rs,"type" =>0,"par" =>"","label_fr" =>$rs,"label_en" =>$rs,"cdate" =>$time,"mdate" =>$time,"order" =>1000,"owner" =>6,"allowed" =>1,"status" =>1);

			$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
			$val_item = "'" . implode("','", array_values($INSERT)) . "'";
			
			$query = "INSERT INTO `contents` ( $val_column ) VALUES ( $val_item);";
			//echo $query."<br>";
			$DB->query($query);
			$id = mysql_insert_id();
			
			$RESULTS = $DB->metadata($table,false);
			e($RESULTS);
						
			$count = 200;			
						
			foreach ($RESULTS as $META) {
				$INSERT = array("pid" =>"|$id|","name" =>$META['name'],"type" =>0,"par" =>"","label_fr" =>$META['name'],"label_en" =>$META['name'],"cdate" =>$time,"mdate" =>$time,"order" =>$count,"owner" =>6,"allowed" =>1,"status" =>1);
			
				$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
				$val_item = "'" . implode("','", array_values($INSERT)) . "'";
				
				$query = "INSERT INTO `contents` ( $val_column ) VALUES ( $val_item); \n";
				//echo $query."<br>";
				$DB->query($query);
				$this_id = mysql_insert_id();	
				
				$INSERT = array("pid" =>"|$this_id|","name" =>"input","type" =>17,"par" =>"","label_fr" =>"input","label_en" =>"input","cdate" =>$time,"mdate" =>$time,"order" =>10000,"owner" =>6,"allowed" =>5,"status" =>1);
			
				$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
				$val_item = "'" . implode("','", array_values($INSERT)) . "'";
				
				$query = "INSERT INTO `contents` ( $val_column ) VALUES ( $val_item); \n";
				//echo $query."<br>";
				$DB->query($query);
				$this_id = mysql_insert_id();							
				$count += 200;
			}			
			
		}	
	}



?>