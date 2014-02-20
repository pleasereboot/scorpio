<?php 

//e($PAR);	
	if (isset($PAR['html'])) {$html_name = $PAR['html'];} else {$html_name = $CORE['GET']['p'];}
	if (isset($PAR['form'])) {$form = $PAR['form'];} else {$form = 'true';}
	if (isset($PAR['struct'])) {$struct = $PAR['struct'];} else {$struct = 'struct';}
	
	$list_name = "htmllist" . $html_name;	
	
/// LIST INI
	$INI = array(	'list' 			=> $list_name,
						'table' 		=> "content_html",
						'limit' 			=> 1,
						'root' 		=> "html_cat",
						'item_id' 	=> "html_" . $html_name,
						
						);

	$GENRE = list_ini($INI);

/// CATS PARSE	
	$CATS_INI = array(	'list' 			=> $list_name, 
								'type' 			=> "cats",
								'rs_name' 		=> "htmllist",
								'template'		=> "htmllist",
								);

	//$html .= list_parse($CATS_INI);	
	
/// ITEMS PARSE	
	$ITEMS_INI = array(	'list' 			=> $list_name,
									'rs_name' 	=> "htmllist",
									'template'	=> "htmllist",
									'add'			=> 'false',
									'form'			=> $form,
									'struct '		=> $struct 
									);

	$html .= list_parse($ITEMS_INI);		

/// ITEMS NAV	
	$ITEMS_NAV = array(	'list' 		=> "htmllist"
	 					);

	//$html .= list_nav($ITEMS_NAV);	

/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>