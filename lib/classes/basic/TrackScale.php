<?php
    define('TRACKSALE_CSS', "
<style>fieldset.tracksale {display:block;width:100%;text-align:center;font-size:0;}fieldset.tracksale label {float:left;width:9%;padding-left:2px;padding-right:2px;}fieldset.tracksale span {position:relative;display: inline-block;box-sizing: border-box;margin: 3px;padding-top: 10px;padding-bottom: 10px;font-size: 16px;font-weight: 100;width: 100%;color: #fff;border: 2px solid transparent;border-radius: 0.25em;cursor: pointer;}fieldset.tracksale span.track0 {background: #b72025;}fieldset.tracksale span.track1 {background: #d62027;}fieldset.tracksale span.track2 {background: #f05223;}fieldset.tracksale span.track3 {background: #f36f21;}fieldset.tracksale span.track4 {background: #faa823;}fieldset.tracksale span.track5 {background: #ffca27;}fieldset.tracksale span.track6 {background: #ecdb12;}fieldset.tracksale span.track7 {background: #e8e73d;}fieldset.tracksale span.track8 {background: #c5d92d;}fieldset.tracksale span.track9 {background: #afd136;}fieldset.tracksale span.track10 {background: #64b64d;}fieldset.tracksale span:before {content: ' ';visibility: hidden;position: absolute;bottom: -8px;left: 50%;transform: translateX(-50%);border-top: 8px solid #000;border-left: 8px solid transparent;border-right: 8px solid transparent;}fieldset.tracksale span:after {content: ' ';visibility: hidden;position: absolute;top: -8px;left: 50%;transform: translateX(-50%);border-bottom: 8px solid #000;border-left: 8px solid transparent;border-right: 8px solid transparent;}fieldset.tracksale input {display: none;}fieldset.tracksale input:checked ~ span {border: 2px solid #000;}fieldset.tracksale input:checked ~ span:after,fieldset.tracksale input:checked ~ span:before {visibility: visible;}</style>");
    class TrackSale {
        private $input_name;
        public function __construct($input_name) {
            $this->input_name = $input_name;
        }
        public static function newInstance($input_name) {
            return new self($input_name);
        }
        public function HTML($css = true) {
            $output = ($css ? TRACKSALE_CSS : '').'<fieldset class="tracksale">';
            for($i=0;$i<=10;$i++) {
                $output.='<label><input type="radio" name="'.$this->input_name.'" value="'.$i.'" /><span class="track'.$i.'">'.$i.'</span></label>';
            }
            return $output.'</fieldset>';
        }
    }
?>