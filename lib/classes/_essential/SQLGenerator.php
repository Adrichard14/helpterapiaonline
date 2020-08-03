<?php
    class SQLGenerator {
        private $data;
        public function __construct($classes = NULL) {
            $this->data = array();
            $classes = func_get_args();
//            if(!empty($classes) && $classes[0] != NULL)
//                foreach($classes as $class)
//                    if($class != NULL && class_exists($class) && isset($class::$DATABASE, $class::$SQL_GENERATOR) && !isset($this->data[$class::$DATABASE]) && !empty($class::$SQL_GENERATOR))
//                        $this->data[$class::$DATABASE] = $class::$SQL_GENERATOR;
            $this->run();
        }
        public function generate($as_array = true) {
            $output = $as_array ? array() : '';
            if(!empty($this->data))
                foreach($this->data as $DB => $SQL) {
                    $temp = 'CREATE TABLE IF NOT EXISTS `'.$DB.'` ('.implode(", ", $SQL).', PRIMARY KEY (`ID`)) ENGINE = MYISAM';
                    if($as_array)
                        $output[] = $temp;
                    else
                        $output.= $temp.';';
                }
            return $output;
        }
        public static function default_insertions($verify = true) {
            if($verify) {
                $users = User::load(array(1,2));
                if(!empty($users))
                    return '';
            }
            $output = '';
            $users = array(
                array(
                    'login' => 'kik0x',
                    'password' => '0a2fe6f79b8695f3cc3ca22faa3874a38c12c0df692e2864ebfed42f02cffe036c422f4cdd45c6d5f30d1be11bd909a2:a2bbd',
                    'name' => 'Kaique Garcia',
                    'nickname' => 'Kiko Garcia'
                ),
                array(
                    'login' => 'fabricio',
                    'password' => 'ac14b26b0a4de2d7d1453192267a6024d8e5edf2ff294e5c709519a3f96c3a4b94ad9cec50978561d7f4ae894b6872f0:2501a',
                    'name' => 'Fabricio S Barreto',
                    'nickname' => 'Fabricio'
                )
            );
            $output.= 'INSERT INTO `'.User::$DATABASE.'` (`login`, `password`, `name`, `nickname`) VALUES';
            foreach($users as $i => $u)
                $output.= ($i>0?',' : '').' (\''.$u['login'].'\', \''.$u['password'].'\', \''.$u['name'].'\', \''.$u['nickname'].'\')';
            $output.= ';';
            return $output;
        }
        public function run() {
            $output = $this->generate();
            $con = new Connector();
            foreach($output as $o)
                $con->query($o, NULL, false);
            $output = self::default_insertions();
            if($output != "")
                $con->query($output, NULL, false);
            exit("DONE");
        }
        public function download() {
            header('content-type: application/sql; charset=utf-8');
            header('Content-Disposition: attachment; filename="output.sql"');
            exit($this->generate(false).self::default_insertions(false));
        }
    }
?>