<?php

	/* SCORPIO engine - commons.php - v4.0		*/	
	/* created on 2009-03-23	 				*/
	/* updated on 2009-03-23	 				*/	
	/* YYY							29/0		*/
	
/// FORMS
	function form($toform='', $PAR='') {
		$form_name = $PAR['form_name'];
		
		if (isset($PAR['onsubmit'])) {$onsubmit = " onsubmit=\"" . $PAR['onsubmit'] . "\"";}
		if (isset($PAR['value'])) {$value = $PAR['value'];}	else {$value = 'GO';}
		if (isset($PAR['action'])) {$action = $PAR['action'] ;}	else {$value = '';}	
		
		$html = "<form action=\"$action\" method=\"post\" enctype=\"multipart/form-data\" name=\"$form_name\" id=\"$form_name\" $onsubmit $par>" 
				. $toform 
				. "<input name=\"$form_name\" type=\"submit\" id=\"$form_name\" value=\"$value\">"
				. "</form>"; 
		
		return $html;
	}

	function input($value, $PAR='') {
		if (isset($PAR['format']) && $PAR['format'] == 'float') {$content = number_format($content, 2, '.', '');}
		if (isset($PAR['size'])) {$size = " size=\"" . $PAR['size'] . "\"";}
		if (isset($PAR['class'])) {$class = " class=\"" . strtoupper($PAR['class']) . "\"";}
		
		if (isset($PAR['type'])) {
			$type_begin 	= "textarea";
			$value_outside 	= $content;
			$type_end   	= "</textarea>";
			if (isset($PAR['cols'])) {$cols = " cols=\"" . $PAR['cols'] . "\"";}
			if (isset($PAR['rows'])) {$rows = " rows=\"" . $PAR['rows'] . "\"";}
		} else {
			$type_begin 	= "input";
			$value_inside 	= " value=\"$value\"";
		}
		
		$return = "<$type_begin name=\"$field_name$id\" $value_inside$size$cols$rows$class>$value_outside$type_end";

		return $return;
	}
	

/// TABLES	
	function table($html,$OPTION = ""){
		$inside = '';
		
		if(is_array($OPTION)){			
			if(!isset($OPTION['name'])){
				$OPTION['cellpadding']="0"; 
			}
			if(!isset($OPTION['name'])){
				$OPTION['cellspacing']="0";
			}			
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<table '.$inside.' >'.$html.'</table>';
		return $html;
	}
	
	function tr($html,$OPTION = ""){
		$inside = '';
		
		if(is_array($OPTION)){
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<tr '.$inside.'>'.$html.'</tr>';
		return $html;
	}

	function td($html = "",$OPTION = ""){
		$inside = '';
		
		if(is_array($OPTION)){
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<td '.$inside.'>'.$html.'</td>';
		return $html;
	}

	function arraytotable($ROWS, $PAR='') { //v3.29
		$OPTIONS = array();
	
		if(!isset($PAR['EXCEP'])) {$PAR['EXCEP'] = array();}
		if(!isset($PAR['headers'])) {$PAR['headers'] = '';}
		if(!isset($PAR['border'])) {$OPTIONS['border'] = 1;} else {$OPTIONS['border'] = $PAR['border'];}
		
		$trs = '';
		$headers = '';
		$data = '';
	
		foreach ($ROWS as $ROW) {
			$tds = '';

			foreach ($ROW as $name => $col) {
				if(!in_array($name, $PAR['EXCEP'])) {
					if(isset($PAR['RENAME'][$name])) {
						$name = $PAR['RENAME'][$name];
					}
					
					$HEADERS[$name] = $name;

					if(is_numeric($col)) {$col = str_replace('.', ',', $col);}
				
					$tds .= td($col);
				}
			}
			
			$trs .=  tr($tds); 
		}
		
		if ($PAR['headers'] == true) {
			$headers = tr('<td>' . implode('</td><td>', array_flip($HEADERS)) . '</td>');
		}
		
		$data .= table($headers . $trs, $OPTIONS);
		
		return $data; 
	}		

	function url($label,$url = "",$PAR=''){
		if(is_array($PAR)){
			while(list($key, $value) = each($PAR)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}
	
		if($url !=""){
			return "<a href='$url' $inside>$label</a>";
		}
		else{
			return "$label";
		}
	}

	
	function div($html,$OPTION = ""){
		if(is_array($OPTION)){
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<div '.$inside.'>'.$html.'</div>';
		return $html;
	}

	function span($html,$OPTION = ""){
		if(is_array($OPTION)){
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<span '.$inside.'>'.$html.'</span>';
		return $html;
	}	
	
	function b($html){
		$html = '<strong>'.$html.'</strong>';
	
		return $html;
	}
	
	function center($html){
		$html = '<center>'.$html.'</center>';
	
		return $html;
	}	

	function goto($url="") {
		//if (strstr($url,'?')) {$goto = $url;} else {$goto = "?" . $url;} //v3.25
	
		
		header("Location:$url");
	}
	
	function select_build($LIST, $select_name, $id_field, $label_field, $select_id, $selected=false, $blank=false, $multiple=false) { //v3.22
		global $SELECT;
		
		if (!isset($SELECT[$select_name])) {
			if ($blank) {
				$OPTIONS['_'] = "<option value=\"\">&nbsp;</option>";
			}
						
			foreach ($LIST as $key => $VALUE) {
				if ($VALUE[$id_field] != "") {
					$OPTIONS[$VALUE[$id_field]] = "<option value=\"" . $VALUE[$id_field] . "\">" . $VALUE[$label_field] . "</option>";
				}
			}

			$SELECT[$select_name] = $OPTIONS;	
		} else {
			$OPTIONS = $SELECT[$select_name];
		}	

		if ($selected) {
			if (is_array($selected)) {
				foreach($selected as $selected_id) {
					$OPTIONS[$selected_id] = str_replace("<option ", "<option selected ", $OPTIONS[$selected_id]);
				}
			} else {
				$OPTIONS[$selected] = str_replace("<option ", "<option selected ", $OPTIONS[$selected]);
			}
			
		}
		
		if ($multiple) {
			$select_multiple = ' multiple';
			$select_braket	= '[]';
			if (is_numeric($multiple)) {
				$select_size = ' size="' . $multiple . '"';
			} else {
				$select_size = ' size="5"';
			}
			
		}
		
		$select = "<select id=\"$select_id\" name=\"$select_id$select_braket\"$select_multiple$select_size>" . implode('', $OPTIONS) . "</select>";
	
		return $select;
	}
	
	function dir_scan($path) {
		$dh  = opendir($path);
		
		while (false !== ($filename = readdir($dh))) {
			if (!in_array($filename, array(".", ".."))) {
				if (strpos($filename, ".")) {
					$DIR['FILES'][] = $filename;
				} else {
					$DIR['FOLDERS'][] = $filename;
				}
			}
		}
		
		closedir($path); //v3.31
		
		sort($DIR['FILES']);
		sort($DIR['FOLDERS']);
		
		return $DIR;
	}

	function div_wrap($content, $class="", $style="") {
		if ($class != "") {
			$class = strtoupper($class);
			$div_class = " class=\"$class\"";
		}

		if ($style != "") {
			$div_style = " style=\"$style\"";
		}

		$return = "<div$div_class$div_style>$content</div>";

	  	return $return;
	}

	function validate_email($email) {
		if (strstr($email, "@") && strstr($email, ".")) {
			return true;
		} else {
			return false;
		}
	}

	function div_fix() {
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
			$return = " style=\"margin-bottom:-3px;\"";
		}

	  	return $return;
	}	

	function br($num) {
		while ($num > 0) {
			$return .= "<br>";
			$num -= 1;		
		}

	  	return $return;
	}


/// return bytes with suffix 
/// updated v4.0
	function humansize($bytes, $max = NULL) {
		$TYPE  = array("b", "k", "m", "g", "t", "p", "e", "z", "y");
		$index = 0 ;
	  
	  	while($bytes >= 1024 || $TYPE[$index] == $max) {
			$bytes /= 1024;
			$index++;
	  	}
		
	  	return("" . ceil($bytes) . " " . $TYPE[$index]);
	}
	
	function array_flip_multi($ARRAY, $field_value="id", $field_key="") {
		foreach ($ARRAY as $ROW) {
			if ($field_key != "") {
				$RETURN[$ROW[$field_key]] = $ROW[$field_value];
			} else {
				$RETURN[] = $ROW[$field_value];
			}
		}

		return $RETURN;
	}	
	
	function array_order($ARRAY, $field="name", $direction="asc") {
		$FLIPPED = array_flip_multi($ARRAY, $field_value=$field, $field_key="id");
		
		if ($direction == "asc") {asort($FLIPPED);} else {arsort($FLIPPED);}
		
		foreach ($FLIPPED as $key => $ROW) {
			$RETURN[$key] = $ARRAY[$key];
		}
		
		return $RETURN;
	}
		
	function new_size($width_old, $height_old, $max_size) {
		if ($height_old < $max_size && $width_old < $max_size){
			$SIZE['height'] = $height_old;
			$SIZE['width']  = $width_old;
		} else{
			if($height_old >= $width_old){
				$SIZE['height'] = $max_size;
				$SIZE['width']  = ($width_old / $height_old) * $max_size;	
			} else{
				$SIZE['width']  = $max_size;
				$SIZE['height'] = ($height_old / $width_old) * $max_size;	
			}		
		}	
		
		return $SIZE;
	}	
	
	function fastimagecopyresampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
		if (empty($src_image) || empty($dst_image)) { return false; }
		
		if ($quality <= 1) {
			$temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);
			imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);
			imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);
			imagedestroy ($temp);
		} elseif ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
			$tmp_w = $dst_w * $quality;
			$tmp_h = $dst_h * $quality;
			$temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);
			imagecopyresized ($temp, $src_image, $dst_x * $quality, $dst_y * $quality, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);
			imagecopyresampled ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);
			imagedestroy ($temp);
		} else {
			imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		}
		
		return true;
	}
		

	function spacer($value, $char="-") {
		$return = str_repeat($char, $value * 1);
		
		return $return;
	}	



	function to_array($value) {
		if ($value != "" && !is_array($value)) {
			$return = array($value);
		} else {
			$return = $value;
		}

		return $return;
	}	

	function format_rmspace($str) {
		$str = trim(str_replace("\n", " ",$str));
		$str = str_replace("\t", " ",$str);
		
		while (strstr($str, "  ")) {
			$str = str_replace("  ", " ",$str);
		}

		return $str;
	}

	function ein() {
		echo "<br>ein<br>";
	}
	
	function shuffle_id($num){
		$letters = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
		$numbers = array(1,2,3,4,5,6,7,8,9,0);
	
		for($i=1;$i<=$num;$i++){
			$wich = mt_rand(1,2);
			if($wich == 1) {
				$char = $letters[array_rand($letters)];
				$caps = mt_rand(1,2);
				if($caps == 2) {
					$char = strtoupper($char);
				}
			} else {
				$char = array_rand($numbers);
			}
			$id .= $char;
		}
		return $id;
	}	
	
	function stripslashes_deep($value){
	   $value = is_array($value) ?
				   array_map('stripslashes_deep', $value) :
				   stripslashes($value);
	
	   return $value;
	}
	
	function e($x = "", $access=6, $color = "WHITE") { //3.17
		echo "<div style='BACKGROUND-COLOR:$color;text-align:left;'><pre>";	
		print_r($x);
		echo "</pre></div>";
	}
			
	function chrono() {
		static $start;		
		if($start == 0) {
			$start = microtime();	
			return "started : $start - ";
		} else {
			$end = microtime();			
			$delta = $end - $start;
			//$start = $end;			
			return abs(round($delta,5)). " sec";
		}		
	}

	function array_neighbor($arr, $key)	{
	   $keys = array_keys($arr);
	   $keyIndexes = array_flip($keys);
	   $return = array();
	   
	   	if (isset($keys[$keyIndexes[$key] - 1])) {
		   	$return[] = $keys[$keyIndexes[$key] - 1];
	   	} else {
		   	$return[] = $keys[sizeof($keys) - 1];
	   	}
	
	  	if (isset($keys[$keyIndexes[$key] + 1])) {
		   	$return[] = $keys[$keyIndexes[$key] + 1];
	   	} else {
		   	$return[] = $keys[0];
	   	}
	
		$return[] = $keyIndexes[$key] + 1;
	
	   return $return;
	}
		
	function sep() {
		echo "<br>------------------------------------------------------------<br>";			
	}


?>