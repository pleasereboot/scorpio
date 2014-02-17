<?php 

	/* SCORPIO engine - commons.php - v3.17		*/	
	/* created on 2006-12-09	 					*/
	/* updated on 2008-01-31	 					*/	
	/* YANNICK MENARD			176/1388			*/

//	function js_confirm($action, $message='', $PAR='') {
//		//$action = $list_name . "_$table" . "_del=$id";
//		//$message = 'Voulez-vous vraiment supprimer cet item (' . $id . ' - ' . addslashes($AC[lang('label')]) . ') ?';
//		//$redirect = "$page&$action";
//		$return .= " onclick=\"valid_delete('$message','$action');\" onMouseOver=\"this.style.cssText='cursor:hand'\" ";
//			
//		return $return;
//	}

	function piasses($value, $ext=' $') {
		$return = number_format($value, 2, '.', '') . $ext;

		return $return;
	}

	function calendar($value, $id, $PAR='') {
		global $CORE;
		global $SCORPIO;
		
		$PAR = explode_par($par);
		
		//$id 		= $AC['id'];
		//$value 		= $AC[$field_name];
		
		if (isset($PAR['date_def']) && ($value == 0 || $value == '')) { //v3.25
			$value = TIME + ($PAR['date_def'] * 24 * 60 * 60);
		}
		
		if (isset($PAR['format'])) {  // mettre tout ca dans une fonction pour reusabilite
			$date_str = $PAR['format'];  //'Y-m-d\ H\hi\'
		} else {
			$date_str = 'Y-m-d'; 
		}
			
		$date_output = date($date_str, $value); //'Y-m-d\ \- \  H\ \h i \ \: \  s'
			
		if (is_allowed(5)) { //� mettre dans les types
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/calendar.js");
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/calendar-setup.js"); //added calendar/ 3.15
			$SCORPIO->set_js(SCORPIO_TYPES_PATH . "calendar/lang/calendar-" . lang() . ".js");
			$SCORPIO->set_css_link("calendar-win2k-1");
			
			$inputfield 		= $id;
			$outputfield 		= "output-" . $id;
			$imggif_fullpath	= SCORPIO_TYPES_PATH . "calendar/img.gif"; 
			$trigger 			= "trigger-" . $id;
			if ($PAR['showtime'] == 1) {$showtime = true;} else {$showtime = false;}
			
			if ($PAR['daformat'] != "") {$daformat = "daFormat	   :    \"" . $PAR['daformat'] . "\",";}
			
			$content = "	
					<input type=\"hidden\" size=\"15\" name=\"$inputfield\" id=\"$inputfield\" value=\"$value\" readonly=\"1\" />
					<img src=\"$imggif_fullpath\" name=\"$trigger\" id=\"$trigger\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
					onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />
		
					<script type=\"text/javascript\">
						Calendar.setup({
							inputField     :    \"$inputfield\",     // id of the input field
							displayArea	   :	\"$outputfield\",
							ifFormat       :    \"%s\",      // format of the input field\"%B %e, %Y\",
							$daformat
							button         :    \"$trigger\",  // trigger for the calendar (button ID)
							date           :    $value,  
							singleClick    :    true,
							showsTime	   :    \"$showtime\"
						});
					</script>
					";	
	
		
			/// FILL TEMPLATE   cette partie pourrait quasiment etre un par si on veut le template
				$form_file_html 	= t_load_file("form_items_new", "form_items_new", true);	
				$form_rte_html 		= t_set_block("form_items_new", "CALENDAR_SHORT");
		
				$FORM_VARS	= array(//"FIELD_LABEL"		=> $TYPE_PAR[lang("label")],
									"FIELD_DATE_ID" 	=> $outputfield, 
									"FIELD_DATE_OUTPUT" => $date_output, 
									"FIELD_VALUE" 		=> $content,
									//"NAME"				=> $inputfield,
									);	
				
				$return	 			= set_var($form_rte_html, $FORM_VARS);
			
							
			
		} else {
			$return = $date_output;
		}
		
			
		set_function("type_calendar", $AC['name']);
		return $return;
	}


	function drop($LIST, $PAR) { //v3.33
		//$LIST, $select_name, $id_field, $label_field, $select_id, $selected=false, $blank=false, $multiple=false
	
//		global $CORE;
//		global $SELECT;
//		
//		if (!isset($SELECT[$select_name])) {
//			if ($blank) {
//				$OPTIONS['_'] = "<option value=\"\">&nbsp;</option>";
//			}
//						
//			foreach ($LIST as $key => $VALUE) {
//				if ($VALUE[$id_field] != "") {
//					$OPTIONS[$VALUE[$id_field]] = "<option value=\"" . $VALUE[$id_field] . "\">" . $VALUE[$label_field] . "</option>";
//				}
//			}
//
//			$SELECT[$select_name] = $OPTIONS;	
//		} else {
//			$OPTIONS = $SELECT[$select_name];
//		}	
//
//		if ($selected) {
//			if (is_array($selected)) {
//				foreach($selected as $selected_id) {
//					$OPTIONS[$selected_id] = str_replace("<option ", "<option selected ", $OPTIONS[$selected_id]);
//				}
//			} else {
//				$OPTIONS[$selected] = str_replace("<option ", "<option selected ", $OPTIONS[$selected]);
//			}
//			
//		}
//		
//		if ($multiple) {
//			$select_multiple = ' multiple';
//			$select_braket	= '[]';
//			if (is_numeric($multiple)) {
//				$select_size = ' size="' . $multiple . '"';
//			} else {
//				$select_size = ' size="5"';
//			}
//			
//		}
//		
//		$select = "<select id=\"$select_id\" name=\"$select_id$select_braket\"$select_multiple$select_size>" . implode('', $OPTIONS) . "</select>";
//	
//		return $select;
	}

	function hidden($value, $id, $PAR='') {

		$return = "<input type=\"hidden\" name=\"$id\" value=\"$value\">";

		return $return;
	}

	function button($id, $label='', $type='submit') {
		if ($label == '') {$label = $id;}
		
		$return = "<input name=\"$id\" type=\"$type\" id=\"$id\" value=\"$label\">";

		return $return;
	}
	
	function input($value, $id, $PAR='') {
		//if (isset($PAR['format']) && $PAR['format'] == 'float') {$content = number_format($content, 2, '.', '');}
		if (isset($PAR['size'])) {$size = " size=\"" . $PAR['size'] . "\"";}
		if (isset($PAR['class'])) {$class = " class=\"" . strtoupper($PAR['class']) . "\"";}
		
		$return = "<input name=\"$id\" value=\"$value\" $size$class>";

		return $return;
	}	
	
	function form($toform, $action, $id, $onsubmit='') {
		$form_name = $PAR['form_name'];
		
		if ($onsubmit != '') {$onsubmit = " onsubmit=\"" . $PAR['onsubmit'] . "\"";}
		
		$html = "<form action=\"$action\" method=\"post\" enctype=\"multipart/form-data\" name=\"$id\" id=\"$id\" $onsubmit>" 
				. $toform 
				//. "<input name=\"$form_name\" type=\"submit\" id=\"$form_name\" value=\"GO\">"
				. "</form>"; 
		
		return $html;
	}
	
	function arraytotable($ROWS, $PAR='') { //v3.29
		$OPTIONS = array();
	
		if (!isset($PAR['EXCEP'])) {$PAR['EXCEP'] = array();}
		if (!isset($PAR['headers'])) {$PAR['headers'] = '';}
		if (!isset($PAR['border'])) {$OPTIONS['border'] = 1;} else {$OPTIONS['border'] = $PAR['border'];}
		
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
				} else {
					//$tds .= td(arraytotable($col));
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
		
	function sys_array($ARRAY, $key_field='id', $value_field='title_fr') {
		foreach ($ARRAY as $key => $value) {
			$NEW_ARRAY[] = array($key_field => $key, $value_field => $value); 
		}
	
		return $NEW_ARRAY;
	}

	function imageComposeAlpha( &$src, &$ovr, $ovr_x, $ovr_y, $ovr_w = false, $ovr_h = false) {
		if( $ovr_w && $ovr_h )
		$ovr = imageResizeAlpha( $ovr, $ovr_w, $ovr_h );
		
		/* Noew compose the 2 images */
		imagecopy($src, $ovr, $ovr_x, $ovr_y, 0, 0, imagesx($ovr), imagesy($ovr) );
	}
	
	function imageResizeAlpha(&$src, $w, $h) {
		/* create a new image with the new width and height */
		$temp = imagecreatetruecolor($w, $h);
		
		/* making the new image transparent */
		$background = imagecolorallocate($temp, 0, 0, 0);
		ImageColorTransparent($temp, $background); // make the new temp image all transparent
		imagealphablending($temp, false); // turn off the alpha blending to keep the alpha channel
		
		/* Resize the PNG file */
		/* use imagecopyresized to gain some performance but loose some quality */
		//imagecopyresized($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		/* use imagecopyresampled if you concern more about the quality */
		imagecopyresampled($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		return $temp;
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

	function new_explode_par($PAR) {  // to $SCORPIO
		if (strstr($PAR,"::")) {
			$PAR = constant_replace($PAR);
			$PAR = core_replace($PAR);
		
			$ARR_TEMP = explode("||",$PAR);
			while (list($prout, $TO_EXPLODE) = each($ARR_TEMP)) {
				list($key, $value) = explode("::",$TO_EXPLODE);
				
				if (strstr($value,",")) {
					$VALUE_ARR = explode(",",$value); 
				} else {
					$VALUE_ARR = $value;
				}
				
				$ARR[$key] = $VALUE_ARR;	
			}
				
			return $ARR;
		} else {
			$ARR[] = $PAR;
			
			return $ARR;
		}
	}

	function table($html,$OPTION = ""){
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
		if(is_array($OPTION)){
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<tr '.$inside.'>'.$html.'</tr>';
		return $html;
	}

	function td($html = "",$OPTION = ""){
		if(is_array($OPTION)){
			while(list($key, $value) = each($OPTION)) {
			 	$inside .= ' '.$key.'="'.$value.'"';
			}
		}	
		$html = '<td '.$inside.'>'.$html.'</td>';
		return $html;
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
	
	function select_build($LIST, $select_name, $id_field, $label_field, $select_id, $selected=false, $blank=false, $multiple=false) { //v3.22
		global $CORE;
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
	
//-----------------------------------------------------------------------------------------------------
	
	function unset_action() {
		global $CORE;
		
		unset($CORE['QS']['action']);
	}	

	function makerte($rte_id, $content, $width, $height, $x, $y) {
		$return	= "
			<div class=\"RTE_BACK\">
				<script language=\"JavaScript\" type=\"text/javascript\">
					function submitForm() {
						updateRTEs();
						return true; 
					}

					initRTE(\"themes/default/images/rte/\", \"" . SCORPIO_TYPES_PATH . "rte/\", \"themes/default/css/\");
				</script>
				<script language=\"JavaScript\" type=\"text/javascript\">
					writeRichText('$rte_id', '$content', $width, $height, true, false);
				</script>
			</div>
		";	
				
		return $return;
	}	

	/// return image with secret code in it 
	/// created v3.15 agora
	function secretcode($code) {
//		$back_path = SCORPIO_IMAGES_PATH . "validation_1.jpg";
//		
//		if (file_exists($back_path)) {
//			
//		}
//
//		$back_ress = @imagecreatefromjpeg($back_path);
//		
//		
//		$font = SCORPIO_FONTS_PATH . 'Mushu.ttf';
//		
//		
//		imagettftext($back_ress, 12, 0, 5, 5, imagecolorallocate($im, 255, 255, 255), $font, $code);
//
//	
//		$return = $back_ress;
		
		return $code;
	}

/// return ARRAY witn files and folders 
/// created v3.15
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
		if (strstr($email, "@") && strstr($email, ".")) { //updated v3.25
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

	function lang_arr($ARR="", $lang="") {
		global $CORE;
		global $LIST;
		
		if ($lang == "") {$lang = $CORE['SESSION']['lang'];}

		$return = $ARR[$lang - 1];
		
	  	return $return;
	}
	
	function lang($field="", $lang="") {
		global $CORE;
		global $LIST;

		if ($lang == "") {$lang = $CORE['SESSION']['lang'];}

		$lang_label = &$LIST['lang']['DATA'][$lang];

		if ($field != "") {$return = $field . "_" . $lang_label;} else {$return = $lang_label;}
		
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
		
	function explode_pid($pid) {
		$return = substr($pid, 1, -1);
		
		return $return;
	}
		
	function implode_pid($PID) {
		if (is_array($PID)) {
			$return = "|" . implode("|", $PID) . "|";
		} else {
			$return = "|" . $PID . "|";
		}
		
		return $return;
	}	

	function spacer($value, $char="-") {
		$return = str_repeat($char, $value * 1);
		
		return $return;
	}	

	function set_var($html, $VAR, $VALUE = NULL) {	
		if(is_array($VAR)){
			if($VALUE == NULL){			
				$VALUE = array_values($VAR);
				$VAR = array_keys($VAR);
			}
			while(list($key, $preg) = each($VAR)) {			
				$VARIABLE[$key] = '/{'.strtoupper($preg).'}/';
			}		
		} else{
			$VARIABLE = '/{'.$VAR.'}/';
		}	
			
		$html = preg_replace($VARIABLE,$VALUE, $html);
		return $html;
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

	function qs_add($QS_NEW) {
		global $CORE;
		$QS = &$CORE['QS'];
		
		if(is_array($QS_NEW)){		
			foreach($QS_NEW as $key => $value) {		
				$QS[$key] = "$value";
			}				
		}
	}	

	function qs_load($NEW_QS="") {
		global $CORE;
		
		if ($NEW_QS != "") {$QS = $NEW_QS;} else {$QS = &$CORE['QS'];}
		
		if(count($QS) > 0){
			$qs .= "?";
				
			foreach($QS as $key => $value) {			
				$QS_TEMP[] = $key . "=". $value;
			}
			
			$return = $qs . implode("&", $QS_TEMP);
			
			return $return; 
		} else {
			$return = "?p=home";
			
			return $return;
		}
	}	

	function page_validate($page) {
		global $CORE;
		
		$valid_page = $page;
		
		if($page == "") {
			if (SPLASH && $_SESSION['splash_done'] != 1) {  //v3.25
				$valid_page = 'splash'; //PAGE_SPLASH
				$CORE['DEBUG']['page_default'] = 'splash';	
				$_SESSION['splash_done'] = 1;		
			} else {
				$valid_page = PAGE_DEFAULT;
				$CORE['DEBUG']['page_default'] = PAGE_DEFAULT;			
			}

		} else if ($group = list_search("contents", "name", $page, "allowed")){
			if (!is_allowed($group)) {
				$valid_page = PAGE_ERROR_ACCESS;
				set_message("access error" . $page, "l'acces a la page <b>$page</b> n'est pas permis", 2);
			}
		} else {
			$valid_page = PAGE_ERROR_NOTFOUND;
			$CORE['DEBUG']['page_not_found'] = $page;
			set_message("page error" . $page, "la page <b>$page</b> n'existe pas", 2);
		}
		
		$_SESSION['valid_page'] = $valid_page;
		
		set_function("page_validate", "$page | $valid_page");	
		return $valid_page;
	}

	function ein() {
		echo "<br>ein<br>";
	}

	function db_count() {
		static $count;
		$count++;
		return $count - 1;
	}
	
	function db_queries($query) {
		global $CORE;
		$CORE['DEBUG']['QUERIES'][] = $query;
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
		if (is_allowed($access) || DEBUG) {
			echo "<div style='BACKGROUND-COLOR:$color;text-align:left;'><pre>";	
			print_r($x);
			echo "</pre></div>";
		}	
	}
	
	function constant_replace($text) {  // to $SCORPIO
		if (strstr($text,"%%")) {
			$reg = "/[ \t]*%%\s*?\n?(\s*.*?\n?)\s*%%\s*?\n?/sm";
			$result = preg_match_all($reg, $text, $RESULTS);	
			$count = 0;
			
			foreach ($RESULTS[0] as $to_replace) {				
				$text = str_replace($to_replace, constant($RESULTS[1][$count]),$text);
				$count++;
			}
		}
		
		return $text;
	}	
	
	function core_replace($text) {  // to $SCORPIO
	
		return $text;
	}	
	
	function explode_par($PAR) {  // to $SCORPIO
		if (strstr($PAR,":")) {
			$PAR = constant_replace($PAR);
			$PAR = core_replace($PAR);
		
			$ARR_TEMP = explode("|",$PAR);
			while (list($prout, $TO_EXPLODE) = each($ARR_TEMP)) {
				list($key, $value) = explode(":",$TO_EXPLODE);
				
				if (strstr($value,",")) {
					$VALUE_ARR = explode(",",$value); 
				} else {
					$VALUE_ARR = $value;
				}
				
				$ARR[$key] = $VALUE_ARR;	
			}
				
			return $ARR;
		} else {
			$ARR[] = $PAR;
			
			return $ARR;
		}
	}
	
	function set_function($function,$result = ""){ // pour en debug seulement
		global $CORE;
		
		$function = "$function -- " . chrono() . " -- $result";
		
		$CORE['DEBUG']['FUNCTIONS'][] = $function;		
		return $function;
	}
	
	function set_message($bug, $what, $admin = 1, $good = 0){ // pour en debug seulement
		global $CORE;
		static $message_count;
		
		$message_count++;
		
		if ($admin == 1 || DEBUG) {    // DEBUG v3.23
			if (is_allowed(6) || DEBUG) {$to  = "<strong>god</strong> -> ";}
			if (is_allowed(5)) {
				if (is_allowed(6)) {$to  = "<strong>admin</strong> -> ";}
				
				$who = "_ADMIN";			
			}
		} else {
			$who = "_USER";
		}

		if ($good == 1) {
			$how = "_GOOD";
		} else {
			$how = "_BAD";
		}

		if (is_allowed(6) && $admin == 1) {
			$message = "<div class=\"MESSAGE$who$how\">$to$what</div>";
		}
		
		if ($admin != 1 || DEBUG) {
			$message = "<div class=\"MESSAGE$who$how\">$to$what</div>";
		}
		
		$CORE['DEBUG']['MESSAGES'][$bug . $message_count] = $message;		
		return $where;
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

	function is_allowed($access){
		global $CORE;

		if (in_array($access,$CORE['GROUPS'])) {
			$return = true;
		} else {
			$return = false;
		}
		
		set_function("is_allowed", "$access | $return");
		return $return;
    } 

	function is_owner($user_id){
		global $CORE;
		
		if (in_array($user_id,$CORE['USER']['id'])) {
			return true;
		} else {
			return false;
		}
		
		return true;
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