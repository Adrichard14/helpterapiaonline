<?php
	class Captcha {
		private $code;
		private $ucode;
		
		public function __construct($min = 1000, $max = 9999) {
			if($min >= $max) {
				$min = 1000;
				$max = 9999;
			}
			$this->code = rand($min,$max);
			$this->ucode = md5($this->code."_".($this->code%100)).":".($this->code%200);
		}
		
		public function get($var) { return $this->{$var}; }
		
		public function getImage($class = "img-responsive") {
			$base = "";
			while(!file_exists($base."lab/lib")) $base.="../";
            $base.="lab/";
			$folder = $base."coding/";
			if(!file_exists($folder.$this->ucode.".jpg")) {
				if(!file_exists($folder)) mkdir($base."coding");
				$w = (strlen((string)$this->code)*11)+14;
				$im = imagecreatetruecolor($w, 20);
				$text_color = imagecolorallocate($im, 233, 14, 91);
				imagestring($im, $w, 7, 3, $this->code."", $text_color);
				imagejpeg($im, $folder.$this->ucode.".jpg", 100);
				imagedestroy($im);
			}
			return "<img src='".$folder.$this->ucode.".jpg' class='".$class."' />";
		}
		
		public static function check($input, $captcha) {
			return md5($input."_".($input % 100)).":".($input % 200) === $captcha;
		}
	}
?>