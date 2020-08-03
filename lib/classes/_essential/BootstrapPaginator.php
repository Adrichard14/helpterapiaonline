<?php
	class BootstrapPaginator {
		private $element_count;
		private $limit;
		private $link;
		private $link_count;
		private $page;
		private $pages;
		private $colspan;
		private $width;
        private $is_function;
		
		public function __construct($element_count, $link, $page, $limit = 15, $autoprint = false, $colspan = -1, $link_count = 4, $width = -1, $is_function = false) {
			if($element_count > $limit) {
				$this->pages = ceil($element_count/$limit);
				$this->element_count = $element_count;
				$this->link = $link;
				$this->page = $page;
				$this->limit = $limit;
				$this->colspan = $colspan > 0 ? $colspan : -1;
				$this->link_count = $link_count;
				$this->width = $width > 0 ? ' style="max-width: '.$width.'"' : "";
                $this->is_function = $is_function;
				if($autoprint === true) $this->_print();
			} elseif($page != 1) {
				header("location: ".$link."1");
				exit();
			}
		}
		
		public function overflow() {
			return $this->pages > 1 && $this->page < $this->pages;
		}
		
		public function set($var, $value) { $this->{$var} = $value; }
		
		public function isTable() { return $this->colspan != -1; }
		
		public function listLinks($init, $end, $conditional_value, $higher = true) {
			$list = "";
            $link = $this->is_function ? $this->link : $this->link.'{page}';
			for($i = $init; $i <= $end; $i++)
				if(($higher && $i >= $conditional_value) || (!$higher && $i <= $conditional_value)) $list.='<li class="page-item"><a href="'.str_replace('{page}', $i, $link).'" class="page-link">'.$i.'</a></li>';
			return $list;
		}
		
		public function _print(){
			echo $this->getPrint();
		}
		
		public function getPrint() {
            $link = $this->is_function ? $this->link : $this->link.'{page}';
			return $this->element_count != NULL ? ($this->isTable() ? "<tr><td class='text-center' colspan='".$this->colspan."'><ul class='pagination'".$this->width." style='margin: 0px;max-height: 28px;'>" : "<div class='text-center' style='margin: auto auto'>".
			"<ul class='pagination'".$this->width." style='display: -webkit-inline-box;'>").
				($this->page != 1 || $this->pages < $this->link_count ? '<li class="page-item"><a href="'.str_replace('{page}', '1', $link).'" class="page-link">&laquo;</a></li>' : '').
				$this->listLinks($this->page-$this->link_count, $this->page-1, 1).
				'<li class="page-item active"><a href="#" class="page-link">'.$this->page.'</a></li>'.
				$this->listLinks($this->page+1, $this->page+$this->link_count, $this->pages, false).
				($this->page != $this->pages || $this->pages < $this->link_count ? '<li class="page-item"><a href="'.str_replace('{page}', $this->pages, $link).'" class="page-link">&raquo;</a></li>' : '').
			'</ul>'.
			($this->isTable() ? "</td></tr>" : "</div>") : "";
		}
	}
?>