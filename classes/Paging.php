<?php
class Paging {


	private $_records;
	private $_max_pp;
	private $_numb_of_pages;
	private $_numb_of_records;
	private $_current;
	private $_offset = 0;
	private $_key = "page";
	public $_url;
	
	
	
	public function __construct($rows, $max = 6) {
		$this->_records = $rows;
		$this->_numb_of_records = count($this->_records);
		$this->_max_pp = $max;
		$this->currentPage();
		$this->numberOfPages();
		$this->getOffset();
	}
	
	
	private function numberOfPages() {
		$this->_numb_of_pages = ceil($this->_numb_of_records / $this->_max_pp);
	}	
	
	private function getOffset() {
		$this->_offset = ($this->_current - 1) * $this->_max_pp;
	}

	public function currentPage(){
		$this->_current = (is_numeric(Url::getParam($this->_key))) ? (int)Url::getParam($this->_key) : 1;
	}
	
	public function getRecords() {
		$out = array();
		if ($this->_numb_of_pages > 1) {
			$last = ($this->_offset + $this->_max_pp);
			
			for($i = $this->_offset; $i < $last; $i++) {
				if ($i < $this->_numb_of_records) {
					$out[] = $this->_records[$i];
				}
			}
		} else {
			$out = $this->_records;
		}
		return $out;
	}
	
	
	private function getLinks() {
		$out = array();
		if ($this->_numb_of_pages >= 1 && $this->_current <= $this->_numb_of_pages) {
			for($i = 1; $i <= $this->_numb_of_pages; $i++){
				if($i == $this->_current){
					$out[] = "<li class=\"page-item active\">
								<a href=\"?page=".$i."\" class=\"page-link\">".$i."</a>
							</li>";
				} else {
					$out[] = "<li class=\"page-item\">
								<a href=\"?page=".$i."\" class=\"page-link\">".$i."</a>
							</li>";
				}
			}
		}
		return "<ul class=\"pagination justify-content-start\">".implode("", $out)."</ul>";
	}	
	
	public function getPaging() {
		$links = $this->getLinks();
		if (!empty($links)) {
			$out = $links;
			$out .= "<p> Showing page ".$this->_current."/".$this->_numb_of_pages."</p>";
		}
		return $out;
	}
	
}