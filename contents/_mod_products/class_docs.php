<?php 

	/* SCORPIO engine - class_session.php - v2.5		*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2007-01-22	 						*/	
	/* KAMELOS MARKETING INC	163/220					*/

	class doc {
		var $CORE;
 		var $DB;
		var $TABLES;
		var $LIST;
		
		var $id;
		var $new_id;
		var $DOC;
		var $DETAILS;
		var $DETAILS_INFOS;
		var $TYPES;
		
		function doc($id='') {
			$this->DB = new db();
			$this->id = $id;
			$this->LIST = &$GLOBALS['LIST'];
			$this->TYPES = $this->LIST['document_type']['DATA'];
			
			if ($id != '') {
				$this->load();
				$this->details_load();
			} else {
				//create doc
			}
		}
	
		function load($id='') {
			if ($id == '') {$id = $this->id;} else {$this->id = $id;}
			 
			$DOC = db_select('prod_documents', array('id' => $id), true);
			
			$this->DOC = $DOC['DATA'][$id];
		}
		
		function change_type($type) {
			$TYPES = array_flip($this->TYPES);
			
			$this->DOC['pid'] = $TYPES[$type];
		}	

		function change_mdate($time='') {
			if ($time == '') {
				$time = time();
			}
			
			$this->DOC['mdate'] = $time;
		}
		
		function change_docid($id) {
			$this->DOC['document_id'] = $id;
		}		
		
		function change_ref($id, $types='') {
			$this->DOC['ref_id'] = $type . $id;
		}	
			
		function change_comments($text,$append=false) {
			if ($append) {
				$this->DOC['comments'] .= $text;
			} else {
				$this->DOC['comments'] = $text;
			}
		}			
			
		function details_load() {
				$ITEMS_INI 	= array('where' => "`document_id` = '" . $this->id . "'");
										
				$DETAILS = db_select('prod_details', $ITEMS_INI, true);
				
				$this->DETAILS = $DETAILS['DATA'];
				
				unset($DETAILS['DATA']);
				$this->DETAILS_INFOS = $DETAILS;
		}	
			
		function details_change_docid($new_id) {
			foreach($this->DETAILS as $key => $DETAIL) {
				$this->DETAILS[$key]['document_id'] = $new_id;
			}
		}
					
		function stock_update($type, $side='neg') {
			foreach($this->DETAILS as $ITEM) {
				$IDS[] = $ITEM['product_id'];
			}
			
			reset($ITEMS_DATA);
	
			$STOCK_DATA = db_select('prod_products', array('in' => implode(",", $IDS)));

			foreach($this->DETAILS as $key => $DETAIL) {
				foreach($DETAIL as $field => $value) {
					$item_id = $DETAIL['product_id'];
					
					if (strstr($field,'size') && $value != 0) {
						$to_field 		= str_replace('size',$type,$field);
						$num_instock	= $STOCK_DATA['DATA'][$item_id][$to_field];
						if ($side == 'neg') {
							$num_update = $num_instock - $value;
						} else {
							$num_update = $num_instock + $value;
						}

						$TO_UPDATE[$to_field] = $num_update;				
					}
				}

				$this->DB->update('prod_products', $item_id, $TO_UPDATE);	
			}
		}	

		function get_next_id($type) {	
			$query = "SELECT MAX(document_id) FROM `prod_documents` WHERE `pid`='$type'"; 

			$RESULTS = $this->DB->select($query, 3);

			$new_number = $RESULTS['MAX(document_id)'] + 1;

			return $new_number;		
		}			

		function save() {
			$this->DB->update('prod_documents', $this->id, $this->DOC);		
		}

		function saveas($type) {
			$TYPES = array_flip($this->TYPES);

			$new_doc_id = $this->get_next_id($TYPES[$type]);

			$this->new_id = contents_duplicate($this->id, $name='', $PAR='', $table='prod_documents');

			$NEW_DOC = $this->DOC;
			$NEW_DOC['document_id']	= $new_doc_id;
			$NEW_DOC['type']		= $TYPES[$type];
			unset($NEW_DOC['id']);

			$this->DB->update('prod_documents', $this->new_id, $NEW_DOC);		
			
			$this->details_change_docid($this->new_id);
			$this->details_saveas();
		}
		
		function details_saveas() {
			foreach($this->DETAILS as $key => $DETAIL) {
				$new_id = contents_duplicate($key, $name='', $PAR='', $table='prod_details');

				unset($DETAIL['id']);	
	
				$this->DB->update('prod_details', $new_id, $DETAIL);	
			}
		}		
		
									
	}








?>