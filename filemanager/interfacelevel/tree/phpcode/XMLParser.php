<?
class XMLParser 
{
    var $parser;
    var $error_code;
    var $error_string;
    var $current_line;
    var $current_column;
    var $data = array();
    var $datas = array();
    
    function parse($data)
    {
        $this->parser = xml_parser_create('UTF-8');
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
        xml_set_element_handler($this->parser, 'tag_open', 'tag_close');
        xml_set_character_data_handler($this->parser, 'cdata');
        if (!xml_parse($this->parser, $data)):
            $this->data = array();
            $this->error_code = xml_get_error_code($this->parser);
            $this->error_string = xml_error_string($this->error_code);
            $this->current_line = xml_get_current_line_number($this->parser);
            $this->current_column = xml_get_current_column_number($this->parser);
        else:
            $this->data = $this->data['childs'];
        endif;
        xml_parser_free($this->parser);
    }

    function tag_open($parser, $tag, $attribs)
    {
        $this->data['childs'][] = array('tag' => $tag, 'data' => '', 'attribs' => $attribs, 'childs' => array());
        $this->datas[] =& $this->data;
        $this->data =$this->data['childs'][count($this->data['childs'])-1];
    }

    function cdata($parser, $cdata)

    {
	echo $cdata.'<br>';
        $this->data['data'] .= $cdata;
    }

    function tag_close($parser, $tag)
    {
        $this->data =& $this->datas[count($this->datas)-1];
        array_pop($this->datas);
    }
	
	function toString($array_node) {
		$xml = "";
		for($i = 0; $i < count($array_node); ++$i) {
			$node = $array_node[$i];
			$tag = $node['tag'];
			$data = $node['data'];
			$attribs = $node['attribs'];
			$childs = $node['childs'];
			
			$attribs_data = "";
			$keys = array_keys($attribs);
			for($j = 0; $j < count($keys); ++$j)
				$attribs_data .= " ".$keys[$j]."='".$attribs[$keys[$j]]."'";
			
			$xml .= "<".$tag.$attribs_data.">";
			$xml .= XMLParser::configureData($data);
			$xml .= XMLParser::toString($childs);
			$xml .= "</".$tag.">";
		}
		return $xml;
	}
	
	function configureData($data) {
		$data = str_replace("&amp;","&",$data);
		$data = str_replace("&lt;","<",$data);
		$data = str_replace("&gt;",">",$data);
		
		$data = str_replace("&","&amp;",$data);
		$data = str_replace("<","&lt;",$data);
		$data = str_replace(">","&gt;",$data);
		
		return $data;
	}
}
?>
