<?
class Paging
{
	var $links;
	var $pager;
	
	var $begin_index;
	var $end_index;
	var $paging_data;
	
	var $html;

	function Paging($total_of_items,$items_for_page,$actual_page,$links,$type)
	{
		$this->links  = $links;
		$this->pager  = $this->getPagerData($total_of_items, $items_for_page, $actual_page);
		
		$this->begin_index = $this->pager->offset;
		$this->end_index = $this->pager->limit_plus_offset;

		if($this->pager->total > 1 && $this->pager->numPages > 1)
		{
			$this->getPagingData();
			
			if($type == 1) $this->desenhaPaginacaoCompleta();
			elseif($type == 2)  $this->desenhaPaginacaoSingular();
		}
	}
	
	function getPagingData() {
		$paging_data = array();
		$url_query_string = $this->links."&actual_page=";
		
		$first = ($this->pager->numPages > 1 && $this->pager->page != 1) ? array(1,$url_query_string."1") : array();//index,link
		$previous = ($this->pager->page > 1) ? array($this->pager->page-1,$url_query_string.($this->pager->page-1)) : array();
		
		$page_numbers = array();
		for($i = 1; $i <= $this->pager->numPages; $i++) 
			$page_numbers[count($page_numbers)] = array($i,$url_query_string.$i);
		
		$next = ($this->pager->page != $this->pager->numPages) ? array($this->pager->page+1,$url_query_string.($this->pager->page+1)) : array();
		$last = ($this->pager->numPages > 1 && $this->pager->page != $this->pager->numPages) ? array($this->pager->numPages,$url_query_string.$this->pager->numPages) : array();//index,link
		
		$paging_data[count($paging_data)] = $first;
		$paging_data[count($paging_data)] = $previous;
		$paging_data[count($paging_data)] = $page_numbers;
		$paging_data[count($paging_data)] = $next;
		$paging_data[count($paging_data)] = $last;
		
		$this->paging_data = $paging_data;
	}
	
	function desenhaPaginacaoCompleta()
	{
		if ($this->pager->page > 1) 
			$html .= "<a href=\"?".$this->links."&actual_page=".($this->pager->page - 1)."\">Previous</a> | "; 

		for($i = 1; $i <= $this->pager->numPages; $i++) 
		{ 
			if($i > 1) $html .= " | "; 
			
			if ($i == $this->pager->page) 
				$html .= "<font style=\"font-style:italic; font-size:13px \">$i</font>";
			else 
				$html .= "<a href=\"?".$this->links."&actual_page=".$i."\">$i</a>"; 
		} 
	
		if ($this->pager->page != $this->pager->numPages) 
			$html .= " | <a href=\"?".$this->links."&actual_page=".($this->pager->page + 1)."\">Next</a>"; 

		$this->html = $html;
	}
	
	function desenhaPaginacaoSingular()
	{
		if ($this->pager->numPages > 1 && $this->pager->page != 1) 
			$html .= "<a  href=\"?".$this->links."&actual_page=0\">First</a>"; 
		if ($this->pager->page > 1) 
			$html .= " | <a href=\"?".$this->links."&actual_page=".($this->pager->page - 1)."\">Previous</a>"; 
		if ($this->pager->page != $this->pager->numPages) 
			$html .= " | <a href=\"?".$this->links."&actual_page=".($this->pager->page + 1)."\">Next</a>"; 
		if ($this->pager->numPages > 1 && $this->pager->page != $this->pager->numPages) 
			$html .= " | <a href=\"?".$this->links."&actual_page=".$this->pager->numPages."\">Last</a>"; 

		$this->html = $html;
	}
	
	function getPagerData($total, $limit, $page) 
    { 
		if(!$page) $page = 0;
		if(!$total) $total = 0;
		
    	$total  = (int) $total; 
        $limit    = max((int) $limit, 1); 
        $page     = (int) $page; 
        $numPages = ceil($total / $limit); 

        $page = max($page, 1); 
        $page = min($page, $numPages); 

		$offset = 0;
		if($total > 0)
	        $offset = ($page - 1) * $limit; 
		
		$limit_plus_offset = min($offset+$limit,$total);
		
        $ret = new stdClass; 
        $ret->total   = $total; 
        $ret->offset   = $offset; 
        $ret->limit    = $limit; 
        $ret->numPages = $numPages; 
        $ret->page     = $page; 
        $ret->limit_plus_offset = $limit_plus_offset; 
        return $ret; 
    } 
}
?>
