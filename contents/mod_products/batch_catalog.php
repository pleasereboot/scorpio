<?php 


	global $IMAGES_SIZE;
	
	$file_path  = 'files/'; 
	$batch_path = 'files/_batch/';
	$done_path  = 'files/_batch/_done/';


	$CAT['BLB'] = '|5574|';
	$CAT['BLE'] = '|5573|';
	$CAT['BLN'] = '|5572|';
	
	$CAT['BRB'] = '|5588|';
	$CAT['BRE'] = '|5587|';
	$CAT['BRN'] = '|5586|';	
	
	$CAT['GRB'] = '|5562|';
	$CAT['GRE'] = '|5561|';
	$CAT['GRN'] = '|5560|';

	$CAT['PKB'] = '|5592|';
	$CAT['PKE'] = '|5591|';
	$CAT['PKN'] = '|5590|';

	$CAT['RDB'] = '|5566|';
	$CAT['RDE'] = '|5565|';
	$CAT['RDN'] = '|5564|';
	
	$CAT['WHB'] = '|5570|';
	$CAT['WHE'] = '|5569|';
	$CAT['WHN'] = '|5568|';	

	$count 		= 1;
	$count_max 	= 50;

	$FILES = dir_scan($batch_path);
//e($FILES);
	$pid = implode_pid(data_switch("contents", "files_cat"));
	$type = "image/jpeg";

	if (count($FILES) > 0) {
		$DB = new db();
	
	/// LOAD IMAGE INI
		$IMAGES_INI = &$INI['IMAGES_SIZE']; //pas besoin si autre que images ex.: pdf	
	//e($IMAGES_INI);
		$LIST['files'] 			= db_select("files");
		
		foreach ($LIST['files']['DATA'] as $ekey => $EFILES) {
			$EXISTING[$ekey] = $EFILES['name'];
		}
		
		if (1 == 1) {
			foreach($FILES['FILES'] as $file) {
				list($item_fullcode, $dump) = explode('-', $file);
				list($item_fullprice, $ext) = explode('.', $dump);
				
				$item_code = substr(trim($item_fullcode), 0,3);
				$item_number = substr(trim($item_fullcode), 3,4);
				$item_price = substr(trim($item_fullprice),-5,-1);
				$item_pid = $CAT[$item_code];
				
				$orifilename	= $file;
				$title			= $item_code . $item_number;
				$file_name 		= $item_code . $item_number . '.jpg';
				$file_pathname 	= $file_path . $file_name;
				$batch_pathname = $batch_path . $file_name;
				$done_pathname  = $batch_path . '_done' . $file_name;
				
				if (!in_array($file_name,$EXISTING)) {
					$time = time();
				
					if (isset($PAR['cat'])) {
						$pid = implode_pid($PAR['cat']);
					} else {
						$pid = implode_pid(data_switch("contents", "files_cat"));
					}
				
					$INSERT = array("pid" =>"$pid","name" =>$file_name,"type" =>$type,"size" =>"00","label_fr" =>$file_name,"label_en" =>$file_name,"desc_fr" =>$file_name,"desc_en" =>$file_name,"cdate" =>$time,"mdate" =>$time,"order" =>1000,"owner" =>$CORE['USER']['id'],"allowed" =>1,"status" =>1);
			
					$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
					$val_item = "'" . implode("','", array_values($INSERT)) . "'";					
				
					$query = "INSERT INTO `files` ( $val_column ) VALUES ( $val_item);";
				//echo $query."<br>";
					$DB->query($query);
					$id = mysql_insert_id();
						
				/// ADD TO PRODUCTS
					$INSERT = array("pid" =>"$item_pid", 'img' => $file_name, "name" =>$file_name,"price" =>$item_price, "label_fr" =>$title,"label_en" =>$title,"desc_fr" =>$title,"desc_en" =>$title,"cdate" =>$time,"mdate" =>$time,"order" =>1000,"owner" =>$CORE['USER']['id'],"allowed" =>1,"status" =>1);
			
					$val_column = "`" . implode("`,`", array_keys($INSERT)) . "`";
					$val_item = "'" . implode("','", array_values($INSERT)) . "'";					
				
					$query = "INSERT INTO `prod_products` ( $val_column ) VALUES ( $val_item);";
				//echo $query."<br>";
					$DB->query($query);
					$album_id = mysql_insert_id(); 
														
					if ($id) {
						$image_ori_ress = @imagecreatefromjpeg($batch_path . $orifilename);

						list($width_old, $height_old) = getimagesize($batch_path . $orifilename);
	
						foreach ($IMAGES_SIZE as $image => $IMAGE_INI) {
							$SIZE = new_size($width_old, $height_old, $IMAGE_INI['max_hor']);

							$new_images_ress = imagecreatetruecolor($SIZE['width'], $SIZE['height']);
							imagecopyresampled($new_images_ress, $image_ori_ress, 0, 0, 0, 0, $SIZE['width'], $SIZE['height'], $width_old, $height_old);
							$new_image_name = substr_replace($file_pathname, $IMAGE_INI['ext'], -4, 0);
							imagejpeg($new_images_ress, $new_image_name);
							chmod($new_image_name, 0644);
						}
					
						rename($batch_path . $orifilename, $done_path . $orifilename);
						imagedestroy($image_ori_ress);

						$new_size 	= filesize($file_pathname);
						$query 		= "UPDATE `files` SET `size` = '$new_size' WHERE `id` = $id";
						$DB->query($query);
					}
					
					$return .= "$count - file ok : $file_name <br>";
					
					if ($count++ >= $count_max) break;
				} else {
					$return .= "file exists : $file_name <br>";
				}			
			}
		}	
	}	

?>