<?php 

	if ($_GET['go'] == "true") {
		$file_path 		= SITE_FILES_PATH;
		
		if ($handle = opendir($file_path)) {
			while (false !== ($file_name = readdir($handle))) {
				if ($file_name != "." && $file_name != "..") {
					$file_pathname 	= $file_path . $file_name;
					echo chmod($file_pathname, 0644);
					//echo "$file_pathname <br />";
				}
			}
		
			closedir($handle);
		}
	}
	
?>