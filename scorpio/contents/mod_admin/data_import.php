<?php 

/// INI
	global $SCORPIO;
	global $CORE;

	$file_name 	= 'clients_.txt';
	$table_name = 'users';
	
	if ($_GET['a'] == 'do') {
		$DB = new db();
	
		if ($FILE = file('files/' . $file_name)) {
			$FIELDS = explode(';', $FILE[0]);
			
			$FIELDS = array_map('trim', array_values($FIELDS));
			
			array_shift($FILE);
			
			foreach($FILE as $row) {
				$ROW = explode(';', $row);
				
				$ROW = array_map('trim', array_values($ROW));
				//$INSERT = array("pid" =>"|$pid|","name" =>$name,"type" =>$PAR['type'],"par" =>$PAR['par'],"label_fr" =>$PAR['label_fr'],"label_en" =>$PAR['label_en'],"cdate" =>$time,"mdate" =>$time,"order" =>$PAR['order'],"owner" =>$PAR['owner'],"allowed" =>$PAR['allowed'],"status" =>$PAR['status'],"class" =>$PAR['class']);
		
				$val_column = "`" . implode("`,`", $FIELDS) . "`";
				$val_item = "'" . implode("','", array_map('addslashes', array_values($ROW))) . "'";
				
				$query = "INSERT INTO `$table_name` ( $val_column ) VALUES ( $val_item);";
				//echo $query."<br>";
				$DB->query($query);
				$id = mysql_insert_id();		
				$ids .= $id . BR;
			}
		}
		
		$html .= 'ids created : ' . BR . $ids;
	} else {
		$html .= url("do it (table : $table_name) (file : $file_name) ", qs_load() . '&a=do');
	}

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>