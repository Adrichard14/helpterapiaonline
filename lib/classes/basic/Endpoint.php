<?php
    class Endpoint {
        public static $NONE = 0;
        public static $XML = 1;
        public static $JSON = 2;
        private static function prepareXML($x) {
            $o = array();
            $x = (is_object($x) || is_array($x)) ? $x : simplexml_load_string($x);
            foreach((array) $x as $i => $n) {
                $o[$i] = (is_object($n) || is_array($n)) ? self::prepareXML($n) : $n;
            }
            return $o;
        }
        private static function prepareJSON($x) {
            return json_decode($x, true);
        }
        public static function CURL($URL, $translate_from = 1) {
            $opts = array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_TIMEOUT => 30,
//                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_CAINFO => realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'ca-bundle.crt'
            );
            $CURL = curl_init($URL);
            curl_setopt_array($CURL, $opts);
            $return = curl_exec($CURL);
            $CURL_CODE = curl_getinfo($CURL, CURLINFO_HTTP_CODE);
            $CURL_ERROR = curl_error($CURL);
            curl_close($CURL);
            if($CURL_CODE != 200 || strpos(strtolower($return), "404 not") !== false)
                return false;
            switch($translate_from) {
                case self::$XML:
                    return self::prepareXML($return);
                    break;
                case self::$JSON:
                    return self::prepareJSON($return);
                    break;
                default: # none
                    return $return;
            }
        }
    }
?>