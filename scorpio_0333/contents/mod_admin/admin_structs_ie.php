<?php 
//phpinfo();
	switch($_GET['m']) {
	    case 'structs_export':
			$tree_id = $_GET['id'];
			$file_name = SITE_NAME . '_' . $_GET['name'] . '_' . $tree_id . TIME . '.php';
			
			$TREE 		= tree($tree_id);
			$TREE_LIST 	= tree_to_list('struct_ie', $TREE);
			
			if ($fp = @fopen(SCORPIO_INSTALL_PATH . $file_name, 'w')) {
				$head .= '<?php ';		
				
				foreach($TREE_LIST as $id => $ROW) {
					foreach($ROW as $field => $value) {
						if(!is_numeric($value)) {
							$value = '\'' . $value . '\'';
						} else {
							$value = addslaches($value);
						}
						
						$main .= '$TREE_IMPORT[' . $id . '][\'' . $field . '\'] = ' . $value . ';';			
					}
					
					$html .= spacer($ROW['level']) . $id . ' - ' . $ROW['name'] . BR;
				}
				
				$foot .= ' ?>';	
					
				fwrite($fp, $head . $main . $foot);
				fclose($fp);
			}
			
			$html = 'PROCESSED : ' . BR . $html; 
			
	    break;

	    case 'structs_importlist':
			$PID[1] =  $_GET['id']; //1027;
			
			$FILES = dir_scan(SCORPIO_INSTALL_PATH);
					
			foreach($FILES['FILES'] as $file) {
				$url = '?p=admin_structs_ie&m=structs_import&file=' . $file . '&id=' . $_GET['id'];
				
				$html .= url($file, $url) . url(' (NP)', $url . '&parent=no') . BR;
			}
			
			
	    break;

	    case 'structs_import':
		    include(SCORPIO_INSTALL_PATH . $_GET['file']);	
			
			$PID[1] =  $_GET['id']; //1027;
			
			if(isset($_GET['parent']) && $_GET['parent'] == 'no') {
				array_shift($TREE_IMPORT);
				$PID[2] =  $_GET['id']; //1027;
			}
	
			foreach($TREE_IMPORT as $id => $ROW) {
//				foreach($ROW as $row_id => $value) {
//					$ROW[$row_id] = stripslashes($value); 
//				}
				
				$new_id = contents_add($PID[$ROW['level']], $ROW['name'], $ROW);
				$PID[$ROW['level'] + 1] = $new_id;
			}
			
			header("Location:" . $_SERVER['HTTP_REFERER']);
			
	    break;

	    default:
			$FILES = dir_scan(SCORPIO_INSTALL_PATH);

			foreach($FILES['FILES'] as $file) {
				$html .= url($file, '?p=admin_structs_ie&m=structs_import&file=' . $file . '&id=' . $_GET['id']) . BR;
			}
		
	    break;
	}
	
	$html .= BR . url('<<-- RETURN', $_SERVER['HTTP_REFERER']) . BR; 

/// RETURN	
	$return = $html;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>