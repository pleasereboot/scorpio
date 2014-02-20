<?php 

	$page_id = 3267;

	if (isset($_POST['pages_selector']) && isset($_POST['page_id'])) {
		$page_id = $_POST['page_id'];
	}

	$SITE_LAYOUT = tree2(8);
	$PAGE_LAYOUT = tree2(3834);
	$PAGES_LIST	 = tree2(236);
	$PAGE_ACTIVE = tree2($page_id);

	$PAGES_LIST = tree_to_list ('prout', $PAGES_LIST);

/// LIVE CONTENT UPDATE	
	$html .= div('live content goes here', array('id' => 'live_content')); 
	$html .= div('live content trigger' . I_EDIT, array('onclick' => "live_php('live_content','?p=live_contents&live_id=30&live=true');"));	

/// FORM
	foreach ($PAGES_LIST as $PAGE) {
		if (in_array($PAGE['type'], array(0,1))) {
			$PAGE['name'] = spacer($PAGE['level']*2) . ' ' . $PAGE['name'];
			
			$PAGES[] = $PAGE;		
		}
	}
	
	$select_html = select_build($PAGES, 'designer_page_sel', 'id', 'name', 'page_id', $page_id, $blank=false, $multiple=false);

	$form_html = form($select_html, array('form_name' => 'pages_selector'));
	
	$html 	   .=	$form_html;
	
/// CONTENT STRUCT	
	function childindiv ($TREE, $page='', $reset=0) {	
		global $LIST;
		
		$border_color = '#CCCCCC';
		$border_style = 'solid';
		$live_id = $TREE['id'];
		
		if ($reset == 1) {$reset = 0; $border_color = '#000000';}
		
		$TYPES = &$LIST['types']['DATA'];

		foreach ($TREE['CHILDS'] as $key => $CONTAINER) {
			$result .= childindiv ($CONTAINER, $page);
		}
		
		if ($TREE['name'] == 'center_main') {$page_html = $page; }	
		if ($TREE['name'] == 'page_content') {$page_html = $page; }	
		if ($TREE['type'] == 1) {$border_color = '#610B0B'; }		
		if ($TREE['status'] == 0) {$border_style = 'dashed'; }
		
		$html = "<div style=\"margin:5px 5px 5px 5px; padding:5px 5px 5px 5px; border: 1px $border_style $border_color;\">"
		. $TREE['status'] . ' '
		. span(HS . I_EDIT . HS, array('onclick' => "live_php('live_content','?p=live_contents&live_id=$live_id&live=true');"))
		. url(b($TREE['name']), '?p=admin_layouts&layoutslist_cat_id=' . $TREE['id'], '_blank')
		//. ' (' . span($TREE['class'], array('id' => 'css-' . $TREE['id'], 'onmouseover=\"live_css(\"css-\"+' . $TREE['id'] . ', ' . $TREE['class'] . ')"' => ";")) . ')' 
		. '(' .span(HS . I_EDIT . HS, array('onclick' => "live_css('css-" . $TREE['id'] . '\',\'' . $TREE['class'] . '\', event);")')) . $TREE['class'] . ' )'
		. ' type : ' . $TYPES[$TREE['type']]['name']
		. ' <span id="' . 'css-' . $TREE['id'] . '"></span>'		
		. $result
		. $page_html 
		. "</div>";
		
		return $html;
	}
	
	$main_html 	= childindiv ($PAGE_ACTIVE, '', 1);	
	$page_html 	= childindiv ($PAGE_LAYOUT, $main_html, 1);
	$html 	   .= childindiv ($SITE_LAYOUT, $page_html, 1);


/// RETURN	
	$return = $html;//print_r($GENRE, 1);
	
?>