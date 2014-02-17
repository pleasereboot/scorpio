<?php

	/* SCORPIO engine - upload.php - v3.13				*/
	/* created on 2007-04-30	 						*/
	/* updated on 2007-12-04	 						*/
	/* YANNICK MENARD			126						*/

	global $CORE;
	global $IMAGES_SIZE;
	global $LIST;

	$DB = new db();
//e($_FILES);
	if ($_FILES != NULL) {
		$CORE['FILES'] = $_FILES;

		$FILES_TYPES = $LIST['files_types']['DATA'];

//e($CORE['FILES']);
////		if (substr(sprintf('%o', fileperms('files')), -4) != 0777) {
////			set_message("files no perms", "acc�s non permis � FILES", 1);
////		}
//
		foreach($_FILES as $FILE) { // error for file size
			if ($FILE['error'] == 0) {
				if (is_uploaded_file($FILE['tmp_name'])) {
				/// check if its not a theme image file (god only for now)
					if ($_POST['files_themes'] != "true") {
					/// set dir_path
						if (isset($CORE['GET']['fileslist_cat_id'])) {$cat_path = substr(data_switch("contents", $CORE['GET']['fileslist_cat_id']),6);}
	
						if (file_exists(SITE_FILES_PATH . "/" . $cat_path) && $cat_path != "") {
							$dir_path = $cat_path . "/";
						} else {
							$dir_path = "";
						}
	
					/// set name and path
						$file_name 		= $FILE['name'];
						$file_path 		= SITE_FILES_PATH . $dir_path;
						$file_pathname 	= $file_path . $file_name;
						
					/// VALIDATE FORMAT
						if (in_array($FILE['type'], $FILES_TYPES)) {

						/// LOOK FOR EXISTING FILE
							if (!file_exists($file_pathname) || $_POST['files_replace'] == 'true') { // added replace v.3.25
								if (move_uploaded_file($FILE['tmp_name'], $file_pathname)) {
								/// LOAD IMAGE INI
									$IMAGES_INI = &$INI['IMAGES_SIZE']; //pas besoin si autre que images ex.: pdf
		
								/// add file to db
									$time = time();
		
								/// set pid
									if (isset($CORE['GET']['fileslist_cat_id'])) {
										$pid = implode_pid($CORE['GET']['fileslist_cat_id']);
									} else {
										$pid = implode_pid(data_switch("contents", "files_cat"));
									}
		
								/// INSERT query
									$INSERT = array("pid" =>"$pid", "name" =>$file_name, "type" =>$FILE['type'], "path" =>$dir_path, "size" =>$FILE['size'], "label_fr" =>$file_name, "label_en" =>$file_name, "desc_fr" =>$file_name, "desc_en" =>$file_name, "cdate" =>$time, "mdate" =>$time, "order" =>1000, "owner" =>$CORE['USER']['id'], "allowed" =>1, "status" =>1);
		
									$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
									$val_item = "'" . implode("','", array_values($INSERT)) . "'";
		
									$query = "INSERT INTO `files` ( $val_column ) VALUES ( $val_item);";  // INSERT IF OK ??
									//echo $query."<br>";
									$DB->query($query);
									$id = mysql_insert_id();
		
									if ($id) {		
										switch ($FILE['type']) {
											case 'image/gif':
												$image_ori_ress = @imagecreatefromgif($file_pathname);
												list($width_old, $height_old) = getimagesize($file_pathname);
												
												foreach ($IMAGES_SIZE as $image => $IMAGE_INI) {
													$SIZE = new_size($width_old, $height_old, $IMAGE_INI['max_hor']);
				
													$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);
													
													imagefilledrectangle($new_images_ress, 0, 0, $SIZE['width'] - 1, $SIZE['height'] - 1, 0xFFFFFF);
													imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
													$new_image_name = substr_replace($file_pathname, $IMAGE_INI['ext'], -4, 0);
													imagegif($new_images_ress, $new_image_name);
													chmod($new_image_name, 0644);
												}
				
												imagedestroy($image_ori_ress);
				
												$new_size 	= filesize($file_pathname);
												$query 		= "UPDATE `files` SET `size` = '$new_size' WHERE `id` = $id";
												$DB->query($query);
											break;	
											
											case 'image/pjpeg':
											case 'image/jpeg':
												$image_ori_ress = @imagecreatefromjpeg($file_pathname);
												list($width_old, $height_old) = getimagesize($file_pathname);
												
												foreach ($IMAGES_SIZE as $image => $IMAGE_INI) {
													$SIZE = new_size($width_old, $height_old, $IMAGE_INI['max_hor']);
				
													$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);
													imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
													$new_image_name = substr_replace($file_pathname, $IMAGE_INI['ext'], -4, 0);
													imagejpeg($new_images_ress, $new_image_name);
													chmod($new_image_name, 0644);
												}
				
												imagedestroy($image_ori_ress);
				
												$new_size 	= filesize($file_pathname);
												$query 		= "UPDATE `files` SET `size` = '$new_size' WHERE `id` = $id";
												$DB->query($query);
											break;	
											
											case 'image/png':									
											case 'image/x-png':
												$image_ori_ress = @imagecreatefrompng($file_pathname);
												list($width_old, $height_old) = getimagesize($file_pathname);
																						
												foreach ($IMAGES_SIZE as $image => $IMAGE_INI) {
													$SIZE = new_size($width_old, $height_old, $IMAGE_INI['max_hor']);
													$new_image_name = substr_replace($file_pathname, $IMAGE_INI['ext'], -4, 0);
												
													$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);
														
												  	imagealphablending($new_images_ress, false);
													imagesavealpha($new_images_ress,true);
													
													$transparent = imagecolorallocatealpha($new_images_ress, 255, 255, 255, 127);

													imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
													
													imagepng($new_images_ress, $new_image_name,5);
													chmod($new_image_name, 0644);
												}
				
												imagedestroy($image_ori_ress);
				
												$new_size 	= filesize($file_pathname);
												$query 		= "UPDATE `files` SET `size` = '$new_size' WHERE `id` = $id";
												$DB->query($query);
											break;
											case 'audio/mp3':
												e('genre');
	


											break;
											
										}									
									}
		
									set_message("file upload " . $FILE['name'], "Fichier " . $FILE['name'] ." transfere avec succes.", 1, 1);
								} else {
									set_message("file upload " . $FILE['name'], "Fichier " . $FILE['name'] ." transfere sans succes, erreur no " . $FILE['error'], 1);
								}
							} else {
								set_message("file upload ". $FILE['name'], "Le fichier ". $FILE['name'] ." existe deja, transfere sans succes.", 1);
							}
						} else {
							set_message("file upload ". $FILE['name'], "Le format ". $FILE['type'] ." n'est pas permis, transfere sans succes.", 1);
						}
					} else {
					/// set name and path
						$file_name 		= $FILE['name'];
						$file_path 		= SITE_IMAGES_PATH;
						$file_pathname 	= $file_path . $file_name;
						
						if (move_uploaded_file($FILE['tmp_name'], $file_pathname)) {
							chmod($file_pathname, 0644);
							set_message("file upload " . $FILE['name'], "Fichier " . $FILE['name'] ." transfere avec succes dans themes/images.", 1, 1);
						} else {
							set_message("file upload " . $FILE['name'], "Fichier " . $FILE['name'] ." transfere sans succes, erreur no " . $FILE['error'], 1);
						}				
					}					
				} else {
					set_message("file upload ". $FILE['name'], "Fichier ". $FILE['name'] ." transfere sans succes, erreur no " . $FILE['error'], 1);
				}
			} else {
				//this form input is blank
			}
		}
	}

/// LOAD FORM
	$t_files_file_html	 = t_load_file("files", "files", 1,'mod_files/themes/default/templates/');
	$t_files_input_html .= t_set_block("files", "INPUT");
	$t_files_form_html  .= t_set_block("files", "FORM");

/// SET NUMBER OF INPUT BOX
	if (isset($CORE['GET']['files_box_num'])) {
		$input_num = $CORE['GET']['files_box_num'];
		unset($CORE['QS']['files_box_num']);
	} else {
		$input_num = 5;
	}

	for ($i = 1; $i <= $input_num; $i++) {
		$input_html .= set_var($t_files_input_html,"NUM",$i);
	}

	if (is_allowed(6)) {
		$t_files_form_html = set_var($t_files_form_html,"FILES_THEME","<br> <input name=\"files_themes\" type=\"checkbox\" value=\"true\" /> FICHIERS THEMES");
	}

 // REPLACE OPTION	
	$t_files_form_html = set_var($t_files_form_html,"FILES_REPLACE","<br> <input name=\"files_replace\" type=\"checkbox\" value=\"true\" /> REMPLACER FICHIERS");


	$num_url  = qs_load() . "&files_box_num";
	$num_link = "<a href=\"$num_url=5\">5</a> - <a href=\"$num_url=10\">10</a> - <a href=\"$num_url=15\">15</a>";
	$t_files_form_html = set_var($t_files_form_html,"NUM_LINK",$num_link);

///	PARSE FORM
	$html .= set_var($t_files_form_html,"INPUT",$input_html);

/// FILE LISTING
	$list_name = "fileslist";

/// LIST INI
	$INI = array(		'list' 		=> $list_name,
						'table' 	=> "files",
						'limit' 	=> 20,
						'root' 		=> "files_cat",
						'order' 	=> "cdate",
						'order_dir' => "DESC",
						'mod'		=> 'mod_files',
						);

	$GENRE = list_ini($INI);

/// CATS PARSE
	$CATS_INI = array(	'list' 		=> $list_name,
						'type' 		=> "cats",
						'rs_name' 	=> $list_name,
						'template'	=> "files",
						'sys'		=> 1,
						'form'		=> 0,
						'mod'		=> 'mod_files',
						);

	$html .= list_parse($CATS_INI);

/// ITEMS PARSE
	$ITEMS_INI = array(	'list' 		=> $list_name,
						'rs_name' 	=> $list_name,
						'template'	=> "files",
						'sys'		=> 1,
						'add'		=> "false",
						'where'		=> "`type` NOT IN ('application/vnd.ms-excel','application/pdf')",
						'mod'		=> 'mod_files',
						);

	$html .= list_parse($ITEMS_INI);

/// ITEMS NAV
	$ITEMS_NAV = array(	'list' 		=> $list_name,
						'template'	=> "files",
						'mod'		=> 'mod_files',
						);

	$html .= list_nav($ITEMS_NAV);

/// RETURN
	$return = $html;//print_r($GENRE, 1);

?>