<?php
	class Display {
		public static $types = array('sc', 'err', 'inf', 'war');
		public static $sc = array('class' => ' alert alert-success', 'precontent' => "");
		public static $err = array('class' => ' alert alert-danger', 'precontent' => "Erro: ");
		public static $inf = array('class' => ' alert alert-info', "precontent" => "");
		public static $war = array('class' => ' alert alert-warning', "precontent" => "Aviso: ");
		public static $display_class = 'clickable';
		public static $modal_header = "Mensagem do sistema";
		public static $onclick = 'this.remove();';
		
		/**
		* To add a message: Display::Message($type, 'Your message'); //$type must be on the static array $types, on this class.
		* To print a message: Display::Messages();
		*
		* To print a modal message (requires modal_constructor.js AND the DIV refered on the js): Display::ModalMessages();
		* OBS: ModalMessages must be echoed insid a script tag, like <script></script> or Events (onclick, onload, et al).
		**/
		
		public static function Message($type, $msg) {
			isset($_SESSION) or session_start();
            if(!isset($_SESSION['display']))
                $_SESSION['display'] = array();
			if(in_array($type, Display::$types) && Display::${$type} != NULL) {
				$msg = Display::${$type}['precontent'].$msg;
				if(!isset($_SESSION['display'][$type])) {
					$_SESSION['display'][$type]=$msg;
				} else $_SESSION['display'][$type].="<br/>".$msg;
			}
            return $msg;
		}
		
		public static function Messages() {
			isset($_SESSION) or session_start();
			if(isset($_SESSION['display'])) {
				foreach($_SESSION['display'] as $type => $msg)
					if(in_array($type, Display::$types) && Display::${$type} != NULL)
						echo '<div class="'.Display::$display_class.Display::${$type}['class'].'" onClick="'.Display::$onclick.'">'.$msg.'</div>';
				unset($_SESSION['display']);
			}
		}
		
		public static function ModalMessages() {
			isset($_SESSION) or session_start();
			if(isset($_SESSION['display'])) {
				echo 'modal("'.str_replace('"', "'", Display::$modal_header).'", "';
				foreach($_SESSION['display'] as $type => $msg)
					if(in_array($type, Display::$types) && Display::${$type} != NULL)
						echo str_replace('"', "'", $msg).'<br/>';
				echo '", null);';
				unset($_SESSION['display']);
			}
		}
		
		public static function hasMessage() {
			return isset($_SESSION['display']) && !empty($_SESSION['display']);
		}
	}
?>