<?
require_once("XMLParser.php");

class HtmlTree {
	
	var $config_nodes = array();
	var $data_nodes = array();
	var $html_tree;
	var $xml_config_file;
	var $xml_data_file;
	
	function HtmlTree($xml_config_file,$xml_data_file) {
		$this->xml_config_file = $xml_config_file;
		$this->xml_data_file = $xml_data_file;
	}
	
	function designTree() {
		print ($this->html_tree);
	}
	
	function createTreeByGetMethod() {
		$xml_config_data = file_get_contents(str_replace(" ","%20",$this->xml_config_file));
		$xml_data = file_get_contents(str_replace(" ","%20",$this->xml_data_file));
		$this->createTree($xml_config_data,$xml_data);
	}

	function createTree($xml_config_data,$xml_data) {
		$config_xml_parser = new XMLParser;
		$config_xml_parser->parse($xml_config_data);
		$this->config_nodes = $config_xml_parser->data;
		
		$data_xml_parser = new XMLParser;
		$data_xml_parser->parse($xml_data);
		$this->data_nodes = $data_xml_parser->data;
		
		$this->html_tree = $this->createRootNode();
	}
	
	function createRootNode() {
		$root = isset($this->data_nodes[0]) ? $this->data_nodes[0] :'';
		$node_attribs = isset($root['attribs']) ? $root['attribs'] : '';

		$class = $this->getNodeConfigElement('mainUlClass',$this->config_nodes[0]['childs']);
		$attribs = $this->getAttributesInString($node_attribs);
		//$attribs = ereg_replace('/id="([a-zA-Z0-9_])*"/','',$attribs);
		
		$html_tree = '<ul id="ul_'.$node_attribs['id'].'" '.$attribs.' class="'.$class.'" style="display: block;">';
		$html_tree .= $this->createNode($root['childs'],true);
		$html_tree .= '</ul>';
		
		return $html_tree;
	}
		
	function createNode($array_nodes,$is_root_node) {
		$html_node='';
		for($i=0; $i < count($array_nodes); ++$i) {
			$node_tag = $array_nodes[$i]['tag'];
			$node_data = $array_nodes[$i]['data'];
			$node_attribs = $array_nodes[$i]['attribs'];
			$node_childs = $array_nodes[$i]['childs'];
			
			$config_elements = $this->getNodeConfigElements($node_tag);
			$html_config = $this->getNodeConfigElement('html',$config_elements);
			$liAttributes = $this->getNodeConfigElement('liAttributes',$config_elements);
			$li_class_name = $this->getLiClassName(count($array_nodes),$i,count($node_childs),$is_root_node);
			
			$html_config = $this->updateNodeConfigElement($html_config,$node_data,$node_attribs);
			$liAttributes = $this->updateNodeConfigElement($liAttributes,$node_data,$node_attribs);
			$ul_class = $this->getNodeConfigElement('mainUlClass',$this->config_nodes[0]['childs']);
			
			$html_node .= '<li id="li_'.$node_attribs['id'].'" class="'.$li_class_name.'" onmouseout="this.className=this.className.replace(new RegExp(\' over\\b\'), \'\');this.className+=\' out\';" onmouseover="this.className=this.className.replace(new RegExp(\' out\\b\'), \'\');this.className+=\' over\';" '.$liAttributes.' tag="'.$node_tag.'">'.$html_config;
			if(count($node_childs) > 0)
				$html_node .= '<ul id="ul_'.$node_attribs['id'].'" class="'.$ul_class.'">'.$this->createNode($node_childs,false).'</ul>';
			$html_node .= '</li>';
		}
		return $html_node;
	}
	
	function getNodeConfigElements($node_tag) {
		$childs = $this->config_nodes[0]['childs'];
		for($i=0; $i < count($childs); ++$i)
			if($childs[$i]['tag'] == 'tags')  {
				$tags = $childs[$i]['childs'];
				for($j=0; $j < count($tags); ++$j) 
					if($tags[$j]['tag'] == 'row') {
						$row_elements = $tags[$j]['childs'];
						for($w=0; $w < count($row_elements); ++$w)
							if($row_elements[$w]['tag'] == 'tag') {
								if($row_elements[$w]['data'] == $node_tag)
									return $row_elements;
								break;
							}
					}
			}
		return false;
	}
	
	function getNodeConfigElement($tag,$config_elements) {
		for($i=0; $i < count($config_elements); ++$i)
			if($config_elements[$i]['tag'] == $tag)
				return $config_elements[$i]['data'];
		return false;
	}
	
	function updateNodeConfigElement($config_element,$node_data,$node_attribs) {
		//$config_element = str_replace('#_DATA',$node_data,$config_element);

		$node_keys = array_keys($node_attribs);
		for($i=0; $i < count($node_keys); ++$i)
			$config_element = str_replace('#_ATTRIBUTE['.$node_keys[$i].']',$node_attribs[$node_keys[$i]],$config_element);

		//$config_element = ereg_replace('/#_ATTRIBUTE\[([a-zA-Z0-9_])*\]/','#',$config_element);
		
		return $config_element;
	}
	
	function getAttributesInString($node_attribs) {
		$str='';
		if(is_array($node_attribs)) {
			$node_keys = array_keys($node_attribs);
			for($i=0; $i < count($node_keys); ++$i)
				$str .= ' '.$node_keys[$i].'="'.$node_attribs[$node_keys[$i]].'"';
		}
		return $str;
	}

	function getLiClassName($root_node_childs_size,$current_node_index,$current_node_childs_size,$is_root_node) {
		$class_name = 'tree';
		
		if($current_node_index == $root_node_childs_size-1) 
			$class_name .=  ' tree-lines-b';
		elseif($current_node_index == 0 && $is_root_node == true)
			$class_name .= ' tree-lines-t';
		else $class_name .= ' tree-lines-c';
		
		if($current_node_childs_size > 0 && $current_node_index != $root_node_childs_size-1)
			$class_name .= ' tree-lined';
		
		return $class_name;
	}
}
?>