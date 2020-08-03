<?php
	class ColumnAdapter {
		private $count;
		private $counter;
		private $line;
		private $lastcounter;
		private $fit;
		private $lines;
		private $columns;
		private $col_by_columns;
		private $col_by_lastcounter;
		private $flexible;
		
		public function __construct($count, $columns, $flexible = true, $maxcolumns = 12) {
			$this->counter = 0;
			$this->line = 1;
			if($count > 0) {
				$this->count = $count;
				$this->columns = $columns;
				$this->flexible = $flexible;
				$this->lastcounter = $count%$columns;
				$this->fit = $this->lastcounter == 0;
				$lines = $columns > 0 ? $count/$columns : 1;
				$lines = intval($lines) < $lines ? intval($lines)+1 : intval($lines);
				$this->lines = $lines > 1 ? $lines : 1;
				$cols = $maxcolumns/$columns;
				$this->col_by_columns = intval($cols) + (intval($cols) < $cols ? 1 : 0);
				$cols = $this->lastcounter != 0 ? $maxcolumns/$this->lastcounter : $this->col_by_columns;
				$this->col_by_lastcounter = intval($cols) + (intval($cols) < $cols ? 1 : 0);
			}
		}
		
		public function get($var) {
			return $this->{$var};
		}
		
		public function getCol() { //Para colocar diretamente no elemento, "col-md-{$var->getCol()}"
			return $this->fit || !$this->flexible || !$this->lastLine() ? $this->col_by_columns : $this->col_by_lastcounter;
		}
		
		public function putCol() { //Se !putCol(), adicione a div que encerra a linha (class row)
			if(!$this->endLine()) {
				$this->counter++;
				return true; //true por poder adicionar uma coluna ao lado
			} else {
				$this->line++;
				$this->counter = 0;
				return false; //falso por terminar a linha, não colocando outra coluna ao lado
			}
		}
		
		public function newLine() { //Se newLine(), adicione a div que inicia uma nova linha (class row)
			return $this->counter == 0;
		}
		
		public function lastLine() {
			return $this->line == $this->lines;
		}
		
		public function endLine() {
			return $this->counter >= $this->columns-1 || (!$this->fit && $this->line == $this->lines && $this->counter == $this->lastcounter-1);
		}
	}
?>