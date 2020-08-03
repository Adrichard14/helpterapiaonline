<?php
    class Routine {
        public static $hr = "#########################################";
        public static $br = "<br/>";
        public function __construct() {
            echo self::$hr.self::$br.
                "Inicializando rotinas".self::$br.
                self::$hr.self::$br.
                Transaction::expiration_routine().self::$br.
                self::$hr;
        }
    }
?>