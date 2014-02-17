<?php 

	//e($PAR);
	$path = "files/";
	
	if (isset($_GET['name']) && file_exists($path . $_GET['name'])) {
		$file_name		= $_GET['name'];
		$file_pathname 	= $path . $_GET['name'];
		$image			= "<img src=\"$file_pathname\" alt=\"$file_name\" $width $height $border $align/>";
	} else {
		$image 			= "IMAGE INEXISTANTE";
	}

	$t_file_html		= t_load_file('pop_image', 'pop_image');
	$t_block_html		= t_set_block('pop_image', 'POP');
	$IMAGE				= array('IMAGE' => $image, 'CLOSE' => 'FERMER CETTE FENÊTRE'); 
	$html 				= set_var($t_block_html, $IMAGE);

/// RETURN	
	$return = $html;
	
?>