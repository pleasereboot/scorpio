<?php 

	$query = 'SELECT * FROM prod_items_types';

	$PROD_ITEMS_TYPES = $DB->select($query);
	
	$query = 'SELECT * FROM prod_styles';

	$PROD_STYLES = $DB->select($query);

	$query = 'SELECT * FROM prod_styles_types';

	$PROD_STYLES_TYPES = $DB->select($query);
	
	$LIST['prod_items_types']['DATA'] 	= $PROD_ITEMS_TYPES['ROWS'];
	$LIST['prod_styles']['DATA'] 		= $PROD_STYLES['ROWS'];
	$LIST['prod_styles_types']['DATA'] 	= $PROD_STYLES_TYPES['ROWS'];


?>