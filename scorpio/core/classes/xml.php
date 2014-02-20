<?php 

	/* SCORPIO engine - softvoyage.php - v3.18			*/	
	/* created on 2006-12-09	 						*/
	/* updated on 2008-02-14	 						*/	
	/* YANNICK MENARD	163/220							*/
	 

	class XMLToArray {

		var $parser;
		var $node_stack = array();
		
		function XMLToArray($xmlstring="") {
			if ($xmlstring) return($this->parse($xmlstring));
			return(true);
		}
		
		function parse($xmlstring="") {
			// set up a new XML parser to do all the work for us
			$this->parser = xml_parser_create();
			xml_set_object($this->parser, $this);
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
			xml_set_element_handler($this->parser, "startElement", "endElement");
			xml_set_character_data_handler($this->parser, "characterData");
			
			// Build a Root node and initialize the node_stack...
			$this->node_stack = array();
			$this->startElement(null, "root", array());
			
			// parse the data and free the parser...
			xml_parse($this->parser, $xmlstring);
			xml_parser_free($this->parser);
			
			// recover the root node from the node stack
			$rnode = array_pop($this->node_stack);
			
			// return the root node...
			return($rnode);
		}
		
		function startElement($parser, $name, $attrs) {
		/// create a new node...
			$node = array();
			$node["_NAME"] = $name;
			foreach ($attrs as $key => $value) {
			$node[$key] = $value;
			}
			
			$node["_DATA"] = "";
			$node["_CHILDS"] = array();
			
			// add the new node to the end of the node stack
			array_push($this->node_stack, $node);
		}
		
		function endElement($parser, $name) {
			// pop this element off the node stack
			$node = array_pop($this->node_stack);
			$node["_DATA"] = trim($node["_DATA"]);
			
			// and add it an an element of the last node in the stack...
			$lastnode = count($this->node_stack);
			array_push($this->node_stack[$lastnode-1]["_CHILDS"], $node);
		}
		
		function characterData($parser, $data) {
			// add this data to the last node in the stack...
			$lastnode = count($this->node_stack);
			$this->node_stack[$lastnode-1]["_DATA"] .= $data;
		}
	}
	
?>