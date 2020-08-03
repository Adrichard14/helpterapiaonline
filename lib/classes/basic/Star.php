<?php
    define('STAR_CSS', '<style data-copyright="https://codepen.io/jamesbarnett/pen/vlpkh">@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);fieldset.star-system, fieldset.star-system label {margin:0;padding: 0;}fieldset.star-system h1 {font-size:1.5em;margin:10px;}fieldset.star-system {border:none;float:none;width:132px;margin:auto auto;}fieldset.star-system > input {display:none;} fieldset.star-system > label:before {cursor: pointer;margin:5px;font-size:1.25em;font-family:FontAwesome;display:inline-block;content:"\f005";}fieldset.star-system > .half:before {content:"\f089";position:absolute;}fieldset.star-system > label {color:#ddd;float:right;}fieldset.star-system > input:checked ~ label,fieldset.star-system .rating:not(:checked) > label:hover,fieldset.star-system .rating:not(:checked) > label:hover ~ label {color:#FFD700;}fieldset.star-system > input:checked + label:hover,fieldset.star-system > input:checked ~ label:hover,fieldset.star-system > label:hover ~ input:checked ~ label,fieldset.star-system > input:checked ~ label:hover ~ label {color:#FFED85;}</style>');
    class Star {
        public $level;
        private $elegible;
        private $input_name;
        public static $LEVELS = array(
            5 => 'Excelente',
            4 => 'Muito bom',
            3 => 'Razoável',
            2 => 'Poderia melhorar',
            1 => 'Ruim'
        );
        public function __construct($level = 0, $elegible = false, $input_name = "") {
            if($level >= 0) {
                if(!isset(self::$LEVELS[$level])) { // try 1
                    $level = floatval(Format::Digits($level, 1, ".", ""));
                    if(!isset(self::$LEVELS[$level])) // try 2
                        $level = floor($level);
                    if(!isset(self::$LEVELS[$level])) // invalid level
                        $level = 0;
                }
            }
            $this->level = $level;
            $this->elegible = $elegible;
            $this->input_name = $input_name;
        }
        public static function newInstance($level = 0, $elegible = false, $input_name = "") {
            return new self($level, $elegible, $input_name);
        }
        public function HTML($css = false) {
            $output = ($css ? STAR_CSS : '').'<fieldset class="star-system">';
            foreach(self::$LEVELS as $lv_value => $lv_name) {
                $lv_int = floor($lv_value);
                $cl = $lv_int == $lv_value ? 'full' : 'half';
                $id = 'star'.$lv_int.$cl;
                $checked = $this->level == $lv_value ? ' checked' : '';
                $disabled = $this->elegible ? '' : ' disabled';
                $output.='<input type="radio" id="'.$id.$this->input_name.'" name="'.$this->input_name.'" value="'.$lv_value.'"'.$checked.$disabled.' />';
                $output.='<label class="'.$cl.'" for="'.$id.$this->input_name.'" title="'.$lv_name.'"></label>';
            }
            return $output.'</fieldset>';
        }
    }
?>