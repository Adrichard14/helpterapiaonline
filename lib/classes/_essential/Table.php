<?php
	/** Sample:
	
	$headers = array(
		array('id' => 1, "value" => "Campo 1", "class" => "teste"),
		array('id' => "umid", "value" => "Campo 2"),
		array("value" => "Campo 3"),
		array("value" => "Campo 4", "colspan" => 2, "class" => "colspanado -q")
	); //Campo 4 = colspan = 2!
	$table = new Table($headers, Table::$TOP);
	$table->addCell("1 x Linha 1");
	$table->addCell("2 x Linha 1");
	$table->addCell("3 x Linha 1");
	$table->addCell("4 x Linha 1");
	$table->addCell("5 x Linha 1");
	$table->fetch();
	$table->addCell("1 x Linha 2");
	$table->addCell("2 x Linha 2");
	$table->addCell("3 x Linha 2");
	$table->addCell("4 x Linha 2");
	$table->addCell("5 x Linha 2");
	$table->fetch();
	$table->addCell("1 x Linha 3");
	$table->addCell("2 x Linha 3");
	$table->addCell("3 x Linha 3");
	$table->addCell("4 x Linha 3");
	$table->addCell("5 x Linha 3");
	$table->fetch();
	$table->addCell("1 x Linha 4");
	$table->addCell("2 x Linha 4");
	$table->addCell("3 x Linha 4");
	$table->addCell("4 x Linha 4");
	$table->addCell("5 x Linha 4");
	$table->fetch();
	$table->show();
	
	***************************************/

	class Table {
		private $ID;
		private $class;
		private $responsive;
		private $current_row;
		private $header_mode;
		private $headers;
		private $current_cells;
		/** Header samples for each mode:
		
		TOP/LEFT/RIGHT/BOTTOM:
		$headers = array(array('value' => $value, 'class' => "text-center",  'colspan' => $colspan, "click" => "your javascript function"), array('value' => $value, 'class' => "text-center",  'colspan' => $colspan, "click" => "your javascript function"), ...);
		-----------------WHERE array('value' => $value, 'class' => "text-center", 'colspan' => $colspan, "click" => "your javascript function") is a table cell!
		#you will put data on the same way to all, but know lets go harder:
		
		TOP_LEFT/TOP_RIGHT/BOTTOM_LEFT/BOTTOM_RIGHT: $headers = array('row' => array $row, 'column' => array $column);
		-----------where $row = array(array('value' => $value, 'class' => "text-center",  'colspan' => $colspan, "click" => "your javascript function"), array('value' => $value, 'class' => "text-center",  'colspan' => $colspan, "click" => "your javascript function"), ...);
		-----------and $column = array(array('value' => $value, 'class' => "text-center",  'colspan' => $colspan, "click" => "your javascript function"), array('value' => $value, 'class' => "text-center",  'colspan' => $colspan, "click" => "your javascript function"), ...);
		like an array of two headers. =D
		
			IF YOU DON'T FOLLOW THESE RULES, YOUR OBJECT WILL FAIL!
		**/
		private $dataspace; //$dataspace[$row][$column] = array("value" => $value, "class" => "text-center");
		private $paginator; //paginator Object or NULL
		//header modes:
		public static $TOP = 1; // only first row (row index 0) [DEFAULT]
		public static $LEFT = 2; // only first column (column index 0)
		public static $RIGHT = 3; // only last column (last column index)
		public static $TOP_LEFT = 4; // first row + first column
		public static $TOP_RIGHT = 5; // first row + last column
		public static $BOTTOM = 6; // only last row (last row index)
		public static $BOTTOM_LEFT = 7; // last row + first column
		public static $BOTTOM_RIGHT = 8; // last row + last column
		public $PUBLIC_VARS = array('class', 'responsive', 'current_row', 'header_mode', 'headers', 'current_cells', 'dataspace');
		
		public function __construct(array $headers, $header_mode = 1, $paginator = NULL, $ID = NULL, $class = "table table-hover table-bordered", $responsive = true) {
			$this->headers = $headers;
			$this->header_mode = $header_mode;
			$this->paginator = $paginator;
			$this->ID = $ID;
			$this->class = $class;
			$this->responsive = $responsive;
			$this->current_row = 0;
			$this->current_cells = array();
		}
		public function get($var) { return $this->{$var}; } 
		public function set($var, $value) { $this->{$var} = $value; }
		
		public function addCell($value, $ID = NULL, $class = "text-center", $click = NULL, $colspan = 1) {
			$cell['value'] = $value;
			$cell['class'] = $class;
			if($id != NULL) $cell['id'] = $ID;
			if($click != NULL) $cell['click'] = $click;
			if($colspan > 1) $cell['colspan'] = $colspan;
			$this->current_cells[] = $cell;
		}
		
		public function clearCell() {
			$this->current_cells = array();
		}
		
		public function fetch() {
			if(!empty($this->current_cells)) {
				$this->dataspace[$this->current_row++] = $this->current_cells;
				$this->current_cells = array();
			}
		}
		
		// Put an row without change any data on current_cells
		// Useful for small tables
		//$entirerow = array(array("id" => $ID, "value" => $value, "class" => "text-center", "click" => "your javascript function"), array("id" => $ID, "value" => $value, "class" => "text-center", "click" => "your javascript function"), ...);
		public function addRow(array $row) {
			if(!empty($row)) {
				$this->dataspace[$this->current_row++] = $row;
			}
		}
		
		public function show() {
			if(!empty($this->dataspace)) {
				$ID = $this->ID != NULL ? ' id="'.$this->ID.'"' : '';
				if($this->paginator != NULL && sizeof($this->dataspace) > 18) $this->paginator->_print();
				if($this->responsive) echo '<div class="table-responsive">';
				$class = $this->class != NULL ? ' class="'.$this->class.'"' : "";
				echo "<table".$class.$ID.">";
				$mode = $this->header_mode;
				$topRow = $mode == Table::$TOP || $mode == Table::$TOP_LEFT || $mode == Table::$TOP_RIGHT;
				$bottomRow = $mode == Table::$BOTTOM || $mode == Table::$BOTTOM_LEFT || $mode == Table::$BOTTOM_RIGHT;
				$leftCol = $mode == Table::$LEFT || $mode == Table::$TOP_LEFT || $mode == Table::$BOTTOM_LEFT;
				$rightCol = $mode == Table::$RIGHT || $mode == Table::$TOP_RIGHT || $mode == Table::$BOTTOM_RIGHT;
				if(!empty($this->headers) && $topRow) {
					echo '<tr>';
					$top_headers = $mode == Table::$TOP ? $this->headers : $this->headers['row'];
					foreach($top_headers as $row) {
						$ID = isset($row['id']) && $row['id'] != NULL ? ' id="'.$row['id'].'"' : "";
						$class = isset($row['class']) && $row['class'] != NULL ? ' class="'.$row['class'].'"' : "";
						$colspan = isset($row['colspan']) && $row['colspan'] != NULL ? ' colspan="'.$row['colspan'].'"' : '';
						$click = isset($row['click']) && $row['click'] != NULL ? ' onClick="'.str_replace('"', "'", $row['click']).'"' : '';
						echo '<th'.$ID.$class.$colspan.$click.'>'.$row['value'].'</th>';
					}
					echo '</tr>';
				}
				foreach($this->dataspace as $i => $row) {
					echo "<tr>";
					if(!empty($this->headers) && $leftCol) {
						$th = $mode == Table::$LEFT ? $this->headers[$i] : $this->headers['column'][$i];
						$ID = isset($th['id']) && $th['id'] != NULL ? ' id="'.$th['id'].'"' : "";
						$class = isset($th['class']) && $th['class'] != NULL ? ' class="'.$th['class'].'"' : "";
						$colspan = isset($th['colspan']) && $th['colspan'] != NULL ? ' colspan="'.$th['colspan'].'"' : "";
						$click = isset($th['click']) && $th['click'] != NULL ? ' onClick="'.str_replace('"', "'", $th['click']).'"' : '';
						echo '<th'.$ID.$class.$colspan.$click.'>'.$th['value'].'</th>';
					}
					foreach($row as $col) {
						$ID = isset($col['id']) && $col['id'] != NULL ? ' id="'.$col['id'].'"' : "";
						$class = isset($col['class']) && $col['class'] != NULL ? ' class="'.$col['class'].'"' : "";
						$colspan = isset($col['colspan']) && $col['colspan'] != NULL ? ' colspan="'.$col['colspan'].'"' : "";
						$click = isset($col['click']) && $col['click'] != NULL ? ' onClick="'.str_replace('"', "'", $col['click']).'"' : '';
						$extra = "";
						if(isset($col["extra"]) && !empty($col["extra"]))
							foreach($col["extra"] as $key => $e) $extra.=' data-'.$key.'="'.$e.'"';
						echo "<td".$ID.$class.$colspan.$click.$extra.">".$col['value']."</td>";
					}
					if(!empty($this->headers) && $rightCol) {
						$th = $mode == Table::$RIGHT ? $this->headers[$i] : $this->headers['column'][$i];
						$ID = isset($th['id']) && $th['id'] != NULL ? ' id="'.$th['id'].'"' : "";
						$class = isset($th['class']) && $th['class'] != NULL ? ' class="'.$th['class'].'"' : "";
						$colspan = isset($th['colspan']) && $th['colspan'] != NULL ? ' colspan="'.$th['colspan'].'"' : "";
						$click = isset($th['click']) && $th['click'] != NULL ? ' onClick="'.str_replace('"', "'", $th['click']).'"' : '';
						echo '<th'.$ID.$class.$colspan.$click.'>'.$th['value'].'</th>';
					}
					echo "</tr>";
				}
				if(!empty($this->headers) && $bottomRow) {
					echo '<tr>';
					$bottom_headers = $mode == Table::$BOTTOM ? $this->headers : $this->headers['row'];
					foreach($bottom_headers as $row) {
						$ID = isset($row['id']) && $row['id'] != NULL ? ' id="'.$row['id'].'"' : "";
						$class = isset($row['class']) && $row['class'] != NULL ? ' class="'.$row['class'].'"' : "";
						$colspan = isset($row['colspan']) && $row['colspan'] != NULL ? ' colspan="'.$row['colspan'].'"' : '';
						$click = isset($row['click']) && $row['click'] != NULL ? ' onClick="'.str_replace('"', "'", $row['click']).'"' : '';
						echo '<th'.$ID.$class.$colspan.$click.'>'.$row['value'].'</th>';
					}
					echo '</tr>';
				}
				echo "</table>";
				if($this->responsive) echo "</div>";
				if($this->paginator != NULL) $this->paginator->_print();
			}
		}
	}
?>