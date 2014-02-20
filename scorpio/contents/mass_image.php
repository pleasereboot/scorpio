<?php 

	$pid = implode_pid(data_switch("contents", "files_cat"));
	$type = "image/jpeg";

	if ($handle = opendir(SITE_FILES_BATCH_PATH)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$FILES[] = $file;
			}
		}
		
		closedir($handle);

		$DB = new db();
	
		$LIST['files'] 			= db_select("files");
		
		foreach ($LIST['files']['DATA'] as $ekey => $EFILES) {
			$EXISTING[$ekey] = $EFILES['name'];
		}
		
		if (1 == 1) {
			foreach($FILES as $file) {
				$file_name 		= $file;
				$file_path 		= SITE_FILES_PATH;
				$file_pathname 	= $file_path . $file_name;
				$batch_pathname = SITE_FILES_BATCH_PATH . $file_name;
				
				if (!in_array($file_name,$EXISTING)) {
				/// add file to db
					$time = time();
				
					if (isset($PAR['cat'])) {
						$pid = implode_pid($PAR['cat']);
					} else {
						$pid = implode_pid(data_switch("contents", "files_cat"));
					}
				
					$INSERT = array("pid" =>"$pid","name" =>$file_name,"type" =>$type,"size" =>"999999","label_fr" =>$file_name,"label_en" =>$file_name,"desc_fr" =>$file_name,"desc_en" =>$file_name,"cdate" =>$time,"mdate" =>$time,"order" =>1000,"owner" =>$CORE['USER']['id'],"allowed" =>1,"status" =>1);
			
					$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
					$val_item = "'" . implode("','", array_values($INSERT)) . "'";					
				
					$query = "INSERT INTO `files` ( $val_column ) VALUES ( $val_item);";
					//echo $query."<br>";
					$DB->query($query);
					$id = mysql_insert_id();
		
									//						
					if ($id) {$image_ori_ress = @imagecreatefromjpeg($batch_pathname);
						list($width_old, $height_old) = getimagesize($batch_pathname);
						
					/// create thumbnail
						if (!isset($PAR['tsize'])) {$PAR['tsize'] = 50;}
						$SIZE = new_size($width_old, $height_old, $PAR['tsize']);
						$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);		
						imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
						imagejpeg($new_images_ress, substr_replace($file_pathname, '_t', -4, 0));
		
					/// create small
						if (!isset($PAR['ssize'])) {$PAR['ssize'] = 125;}
						$SIZE = new_size($width_old, $height_old, $PAR['ssize']);
						$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);		
						imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
						imagejpeg($new_images_ress, substr_replace($file_pathname, '_s', -4, 0));
		
					/// create medium
						if (!isset($PAR['msize'])) {$PAR['msize'] = 400;}
						$SIZE = new_size($width_old, $height_old, $PAR['msize']);
						$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);		
						imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
						imagejpeg($new_images_ress, substr_replace($file_pathname, '_m', -4, 0));
		
					/// create large
						if (!isset($PAR['lsize'])) {$PAR['lsize'] = 800;}
						$SIZE = new_size($width_old, $height_old, $PAR['lsize']);
						$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);		
						imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
						imagejpeg($new_images_ress, $file_pathname); //substr_replace($file_pathname, '_large', -4, 0)
		
						//@unlink($file_pathname);
						imagedestroy($image_ori_ress);
					}
					
					if ($count++ > 10) break;
				} else {
					$return .= "file exists : $file_name <br>";
				}			
			}
		}	
	}			

?>