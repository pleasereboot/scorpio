<?php 

/// INI
	global $SCORPIO;
	global $CORE;
	
	$SCORPIO = new scorpio();
	
	$SCORPIO->load_tables();
	
	$TABLES_SYS = $CORE['TABLES'];

///

	$DB_AMDIN = new db();
	
	$TABLES = $DB_AMDIN->table_list();

//	ALTER TABLE `mod_dossiers` ADD `expert_dossier` VARCHAR( 11 ) NOT NULL AFTER `adress_sinister` ;
//	ALTER TABLE `mod_dossiers` ADD `expert_dossier` VARCHAR( 11 ) DEFAULT '-NA-' AFTER `adress_sinister` ;
//	ALTER TABLE `mod_dossiers` CHANGE `expert_dossier` `expert_dossier` VARCHAR(10) NULL DEFAULT '-NA-'
//  ALTER TABLE `mod_dossiers` DROP `test1`

/// CHANGE
	if (isset($_POST['b_dbchange_submit'])) {
		$db_table 		= $_POST['table'];
		$field_new		= $_POST['field'];
		$field_old		= $_POST['field_old'];
		$type_new		= strtoupper($_POST['type']);
		//$length_new		= "(" . $_POST['length'] . ")";
		if ($_POST['length_new'] != "") {$length_new	= "(" . $_POST['length'] . ")";}
		if ($_POST['default'] != "") {$default_new	= "DEFAULT '" . $_POST['default'] . "'";}
		if ($_POST['after'] != "") {$after_new	= "AFTER `" . $_POST['after'] . "`";}
		
		$query = "ALTER TABLE `$db_table` CHANGE `$field_old` `$field_new` $type_new$length_new $default_new $after_new ;";
		//echo $query."<br>";
		$DB_AMDIN->query($query);

		$redirect = qs_load();
		header("Location:$redirect");
	}

/// ADD
	if (isset($_POST['b_dbadd_submit'])) {
		$db_table 		= $_POST['table'];
		$field_new		= $_POST['field'];
		$type_new		= strtoupper($_POST['type']);
		$length_new		= "( " . $_POST['length'] . " )";
		if ($_POST['default'] != "") {$default_new	= "DEFAULT '" . $_POST['default'] . "'";}
		if ($_POST['after'] != "") {$after_new	= "AFTER `" . $_POST['after'] . "`";}
		
		$query = "ALTER TABLE `$db_table` ADD `$field_new` $type_new$length_new $default_new $after_new ;";
		//echo $query."<br>";
		$DB_AMDIN->query($query);

		$redirect = qs_load();
		header("Location:$redirect");
	}

/// DROP
	if (isset($_POST['b_dbdrop_submit'])) {
		$db_table 		= $_POST['table'];
		$field_new		= $_POST['field'];
		
		$query = "ALTER TABLE `$db_table` DROP `$field_new` ;";
		//echo $query."<br>";
		$DB_AMDIN->query($query);

		$redirect = qs_load();
		header("Location:$redirect");
	}
	
	if (isset($_GET['db_table'])) {
		$active_table = $_GET['db_table'];
		$COLUMN = $DB_AMDIN->table_show($active_table);
		//e($COLUMN);
		
		$html .= "<table width=\"600\">
					<tr>
						<td>field</td>
						<td>type</td>
						<td>length</td>
						<td>default</td>
						<td>null</td>
						<td>admin</td>
					</tr>";	
								
									
		foreach ($COLUMN as $DATA) {
			list($type, $length)	= explode("(",$DATA['Type']); 
			$length					= trim($length, ")");
			$field 					= $DATA['Field'];
			$default 				= $DATA['default'];
			$null  					= $DATA['Null'];			
			
			$html .= "	<form id=\"db_change\" name=\"db_change\" method=\"post\" action=\"\">
							<input name=\"table\" type=\"hidden\" id=\"table\" value=\"$active_table\" />
							<input name=\"field_old\" type=\"hidden\" id=\"field_old\" value=\"$field\" />
							<tr>
								<td><input name=\"field\" type=\"text\" id=\"field\" value=\"$field\" size=\"10\" /></td>
								<td><input name=\"type\" type=\"text\" id=\"type\" value=\"$type\" size=\"6\" /></td>
								<td><input name=\"length\" type=\"text\" id=\"length\" value=\"$length\" size=\"1\" /></td>
								<td><input name=\"default\" type=\"text\" id=\"default\" value=\"$default\" size=\"5\" /></td>
								<td><input name=\"null\" type=\"text\" id=\"null\" value=\"$null\"  size=\"1\"/></td>
								<td><input name=\"b_dbchange_submit\" type=\"submit\" id=\"b_dbchange_submit\" value=\"change\" />
								<input name=\"b_dbdrop_submit\" type=\"submit\" id=\"b_dbdrop_submit\" value=\"drop\" /></td>
							</tr>	
						</form>	";
						
			$after_options .= "<option value=\"$field\">$field</option>";
		}
		
		$html .= "</table>";

		$after_select = "<select name=\"after\">
							<option value=\"\">--insert after</option>
							$after_options
						</select>";

		$type_select = "<select name=\"type\">
							<option value=\"TINYINT\">TINYINT</option>
							<option value=\"INT\">INT</option>
							<option value=\"VARCHAR\">VARCHAR</option>
							<option value=\"TEXT\">TEXT</option>
						</select>";
		
		$html .= BR . BR;
		$html .= "	<form id=\"db_add\" name=\"db_add\" method=\"post\" action=\"\">
						<input name=\"table\" type=\"hidden\" id=\"table\" value=\"$active_table\" />
						field <input name=\"field\" type=\"text\" id=\"field\" size=\"10\" /><br />
						type $type_select <br />
						length <input name=\"length\" type=\"text\" id=\"length\" size=\"1\" /><br />
						default <input name=\"default\" type=\"text\" id=\"default\" size=\"5\" /><br />
						null <input name=\"null\" type=\"text\" id=\"null\"  size=\"1\"/><br />
						after $after_select <br />
						<input name=\"b_dbadd_submit\" type=\"submit\" id=\"b_dbadd_submit\" value=\"add\" />
					</form>	";
	}

	$html .= BR . BR;

	$html .= "<table width=\"600\">";

	foreach ($TABLES as $table) {
		$html .= "<tr>";		
		$sys_add = "";
		$sys_struct = "";
	
		if (!in_array($table,$TABLES_SYS)) {
			$sys_add = "<a href=\"?p=admin_db&db_table=$table\">add</a> ";
		} else {
			$sys_struct = "<a href=\"?p=admin_db&db_table=$table\">struct</a> "; 
		}
		
		$html .= "<td>$sys_add</td>  <td>$sys_struct</td>  <td><a href=\"?p=admin_db&db_table=$table\">db edit</a></td> <td>$table</td>";
		$html .= "</tr>";
	}

	$html .= "</table>";

	//e($TABLES);


/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>