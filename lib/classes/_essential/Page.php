<?php
	class Page {
        public static $INTERNFOLDER = "out/";
		public static function pushBase() {
			define('BASE', '//'.$_SERVER['HTTP_HOST'].FOLDER);
		}
		
		public static function Load($language){
            define("INTERN_FOLDER", self::$INTERNFOLDER);
            $root = $_SERVER['DOCUMENT_ROOT'].FOLDER;
            define("ROOT", strpos($root, "wamp") !== false ? "" : $root);
			$URL = isset($_GET, $_GET['URL']) ? explode('/', $_GET['URL']) : array();
			$URL[0] = !isset($URL[0]) || $URL[0] == NULL || $URL[0] == "uploads" ? 'index' : $URL[0];
			$URLs = sizeof($URL);
            $links = array();
            foreach($URL as $i => $l) {
                $pre = '';
                $vars = array();
                for($x=0;$x<$i;$x++)
                    $pre.=$URL[$x]."/";
                for($x=$i+1;$x<$URLs;$x++)
                    $vars[] = $URL[$x];
                $links[] = array(
                    "out_value" => ROOT."out/".$pre.$l.".php",
                    "main_value" => $l == "index" ? "" : ROOT.$pre.$l.".php",
                    "vars" => $vars
                );
            }
			if($URL[0] == 'version')
                exit(Package::getInfo());
			elseif(!empty($links)) foreach($links as $l) {
                $out = file_exists($l['out_value']);
                $main= $l['main_value'] != "" && file_exists($l['main_value']);
                if($out || $main) {
                    $_VARS = $l['vars'];
                    include_once($l[($out ? 'out':'main').'_value']);
                    exit();
                }
            }
            exit("<h2>ERRO 404 - P&Aacute;GINA N&Atilde;O ENCONTRADA</h2><p>O endere&ccedil;o que voc&ecirc; digitou n&atilde;o foi encontrado. Verifique se o digitou corretamente ou tente novamente mais tarde.");
		}
		
		public static function link($link_tags, $string) {
			return '<a '.$link_tags.'>'.$string.'</a>';
		}
		
		public static function getThumb($img, $title, $alt, $w, $h, $group = NULL, $dir = NULL, $link = NULL, $a = NULL){
			if(!defined('BASE')) Page::pushBase();
			//Tipos de Corte
			$a = ($a =!NULL ? '&a='.$a : '');
			//c : position in the center(this is the default)
			//t : align top
			//tr : align top right
			//tl : align top left
			//b : align bottom
			//br : align bottom right
			//bl : align bottom left
			//l  : align left
			//r : align right
			$group 	= ($group != NULL ? "[$group]" : "");
			$dir 	= ($dir != NULL ? "$dir" : "uploads");
			$verDir = explode('/',$_SERVER['PHP_SELF']);
			$urlDir = (in_array('admin',$verDir) ? '../' : '');
			
			if(file_exists($urlDir.$dir.'/'.$img)){
				$img = '<img src="'.BASE.'/tim.php?src='.BASE.'/'.$dir.'/'.$img.'&w='.$w.'&h='.$h.'&zc=1&q=100'.$a.'" title="'.$title.'" alt="'.$alt.'">';
				echo $link == '' ? 
					Page::link('href="'.BASE.'/'.$dir.'/'.$img.'" rel="shadowbox'.$group.'" title="'.$title.'"', $img) : 
					(	$link == '#' ? $img : 
						Page::link('href="'.$link.'" title="'.$title.'"', $img));
			} else {
				echo '
					<img src="'.BASE.'/tim.php?src='.BASE.'/images/default.jpg&w='.$w.'&h='.$h.'&zc=1&q=100'.$a.'"  
					title="'.$title.'" alt="'.$alt.'">
					';
			}
		}
		
		public static function script($URL, $mask = "script") {
			$URLs = is_array($URL) ? $URL : array($URL);
			$masks = array(
				"script" => array(
					'<script type="text/javascript" src="',
					'"></script>'
				),
				"css" => array(
					'<link rel="stylesheet" href="',
					'" />'
				),
				"shortcut icon" => array(
					'<link rel="shortcut icon" href="',
					'" />'
				),
                "apple" => array(
                    '<link rel="apple-touch-icon" href="',
                    '" />'
                ),
                "icon" => array(
                    '<link rel="icon" type="image/png" href="',
                    '" />'
                ),
                "msicon" => array(
                    '<meta name="msapplication-TileImage" content="',
                    '" />'
                )
			);
			foreach($URLs as $URL) {
				echo $masks[$mask][0].PUBLIC_URL.$URL.$masks[$mask][1];
			}
		}
	}
?>