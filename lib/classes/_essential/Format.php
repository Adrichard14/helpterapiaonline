<?php
    /**
    * classe de formatações e validações: trata-se de uma classe composta por funções estáticas, meras funções de auxílio do sistema.
    */
	class Format {
        # Valores padrões do sistema
        public static $DEFAULT_DATE     = "0000-00-00";
        public static $DEFAULT_DATETIME = "0000-00-00 00:00:00";
        # Correções de calendário
        public static $week_days        = array('Sunday' => "Domingo",
			'Monday' => "Segunda",
			'Tuesday' => "Terça",
			'Wednesday' => "Quarta",
			'Thursday' => "Quinta",
			'Friday' => "Sexta",
			'Saturday' => "Sábado");
        public static $week_days_int     = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");
        public static $months           = array('January' => "Janeiro",
			'February' => "Fevereiro",
			'March' => "Março",
			'April' => "Abril",
			'May' => "Maio",
			'June' => "Junho",
			'July' => "Julho",
			'August' => "Agosto",
			'September' => "Setembro",
			'October' => "Outubro",
			'November' => "Novembro",
			'December' => "Dezembro");
        public static $months_int       = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', "Set", "Out", "Nov", "Dez");
        # Multiplicadores usados na função date_to_seconds
        public static $i_mul            = 60; # 1min = 60s
        public static $H_mul            = 3600; # 1h = 3600s
        public static $d_mul            = 86400; # 1 dia = 86400s
        public static $m_mul            = 2592000; # 1 mês = 2592000s
        public static $Y_mul            = 31104000; # 1 ano = 31104000s
        /**
        * toArray: transforma um objeto em array. O objeto deve possuir o array "PUBLIC_VARS" e a função "get" capaz de retornar as variáveis particulares.
        * @param Object $object objeto a converter
        * @return um array com as variáveis obtidas.
        */
		public static function toArray($object) { //object's methods requirements: public static function get(), public $PUBLIC_VARS
			$vars = $object->get("PUBLIC_VARS");
			$out_object = array();
			if($vars != NULL && !empty($vars)) foreach($vars as $var) $out_object[$var] = $object->get($var);
			return $out_object;
		}
        
        /**
        * tags: previne repetições e ordena lista de tags.
        * @param String $tags String com as tags a tratar
        * @return String tratada
        */
        public static function tags($tags) {
            $temp = explode(";", $tags);
            $tags = array();
            foreach($temp as $t)
                if($t != "" && !in_array($t, $tags))
                    $tags[] = $t;
            sort($tags);
            return implode(";", $tags);
        }
        /**
        * date_to_seconds: transforma uma String de data (e tempo) em segundos.
        * @param String $d a data a converter
        * @param String $datetime_delimiter caractere que separa a data da hora. Padrão: " " (espaço).
        * @param String $date_delimiter caractere que separa dia, mês e ano na data. Padrão: "-".
        * @param String $time_delimiter caractere que separa hora, minuto e segundo. Padrão: ":".
        * @return inteiro que representa os segundos obtidos.
        */
		public static function date_to_seconds($d, $datetime_delimiter = " ", $date_delimiter = "-", $time_delimiter = ":") {
			$datetime = explode($datetime_delimiter, $d);
			$dates = explode($date_delimiter, $datetime[0]);
			$secs = ($dates[0]*self::$Y_mul) + ($dates[1]*self::$m_mul) + ($dates[2]*self::$d_mul);
			if(sizeof($datetime) > 1) {
				$times = explode($time_delimiter, $datetime[1]);
				$secs += ($times[0]*self::$H_mul) + ($times[1]*self::$i_mul);
                if(sizeof($times) > 2)
                    $secs+=$times[2];
			}
			return $secs;
		}
        
        /**
        * toDateTime: converte uma data Y-m-d[ H:i:s] para d/m/Y[ à\s H:i:s]
        * @param String $data a data a converter
        * @return String com a data convertida ou "-" se não houver data.
        */
		public static function toDateTime($date) {
            if($date == NULL || $date == self::$DEFAULT_DATE || $date == self::$DEFAULT_DATETIME)
                return "-";
            $datetime = explode(" ", $date);
            $d = explode("-", $datetime[0]);
            return $d[2]."/".$d[1]."/".$d["0"].(sizeof($datetime) > 1?" às ".$datetime[1] : '');
		}
        /**
        * toDate: converte uma data Y-m-d para d/m/Y.
        * @param String $date data a converter
        * @return String com a data convertida ou "-" se não houver data.
        */
		public static function toDate($date) {
            if($date == NULL || $date == self::$DEFAULT_DATE)
                return "-";
            $d = explode("-", $date);
            return $d[2]."/".$d[1]."/".$d["0"];
		}
        /**
        * toFullDate: converte uma data Y-m-d para uma data por extenso.
        * exemplo:
         echo Format::toFullDate('1992-10-31');
         # imprime 'Sábado, 31 de Outubro de 1992'
        * @param String $date data a converter
        * @return String com a data convertida ou "-" se não houver data.
        */
		public static function toFullDate($date) {
			date_default_timezone_set("America/Sao_Paulo");
			if(!($date instanceof DateTime))
                $date = new DateTime($date);
            if($date == NULL)
                return "-";
            $day = self::$week_days[$date->format("l")];
            $month = self::$months[$date->format("F")];
            return $day.", ".$date->format("d")." de ".$month." de ".$date->format("Y");
		}
		/**
        * toAge: descobre quantos anos se passaram a partir de uma data Y-m-d.
        * @param String $date data passada
        * @return um inteiro representando a idade.
        */
		public static function toAge($date) {
			if(!$date instanceof DateTime)
                $date = new DateTime($date);
            if($date == NULL || $date == self::$DEFAULT_DATE)
                return 0;
            $month = intval($date->format("m"));
            $now_m = intval(date('m'));
            return (intval(date('Y'))-intval($date->format("Y"))) -
                    ($now_m-$month < 0 ? 1 :
                        ($month == $now_m && intval(date('d'))-intval($date->format("d")) < 0 ? 1 : 0)
                    );
		}
        /**
        * getDay: Retorna um array com o dia, mês, ano e horário
        * @param String $date data passada
        * @return um array represetando o dia, mês, ano e hora.
        */
// 		public static function getDay($date) {
//             $data[0] = (explode("/", $date))[0];
//             $data[1] = (explode("/", $date))[1];
//             $data[2] = (explode(" ", (explode("/", $date))[2])[0]);
//             $data[3] = (explode(" ", $date))[1];
//             return $data;
// 		}
        /**
        * toMoney: transforma um valor numérico em símbolo de moeda.
        * Exemplo:
            echo Format::toMoney(2.85);
            # imprime 'R$ 2,85'
        * @param mixed $value número a ser convertido
        * @param String $symbol símbolo que ficará na frente do valor
        * @return uma String com o resultado.
        */
		public static function toMoney($value, $symbol = "R$ ") {
			if(is_numeric($value)) return $value > 0 ? $symbol.Format::Digits($value) : ($value < 0 ? "-".$symbol.Format::Digits($value*(-1)) : $symbol."00,00");
			return NULL;
		}
		/**
        * Digits: formata o número de dígitos de um valor numérico.
        * Exemplo:
            echo Format::Digits(3.549);
            # imprime '3,55'
        * @param mixed $value número a ser formatado
        * @param int $count número de dígitos a aplicar
        * @param String $cents caractere que separa os centavos
        * @param String $chillad caractere que separa os milhares
        * @return String com o resultado da formatação.
        */
		public static function Digits($value, $count = 2, $cents = ",", $chillad = ".") {
			if(is_numeric($value)) return number_format($value, $count, $cents, $chillad);
			return NULL;
		}
        
        /**
        * string_to_float: converte uma String em um legítimo float.
        * Exemplo:
            $price = Format::string_to_float('R$450,60');
            # $price será 450.6
        * @param String $value String a ser convertida
        * @return float convertido
        */
        public static function string_to_float($value) {
            $dot = "."; $comma = ","; $n = "";
            $c = 1;
            $value = preg_replace('/[^0-9'.$dot.$comma.']/',$n, $value);
            $dot_position = strpos($value, $dot);
            $comma_position = strpos($value, $comma);
            $has_dot =  $dot_position !== FALSE;
            $has_comma = $comma_position !== FALSE;
            if(!$has_dot && !$has_comma)
                return floatval($value);
            if($has_dot && $has_comma) {
                if($dot_position < $comma_position) {
                    $value = str_replace($dot,$n,$value);
                    $has_dot = false;
                } else {
                    $value = str_replace($comma,$n,$value);
                    $has_comma = false;
                }
            }
            if($has_dot) {
                $r = str_replace($dot,$comma,$value,$c);
                $r = str_replace($dot,$n,$r);
                $r = str_replace($comma,$dot, $r);
            } else {
                $r = str_replace($comma,$dot, $value, $c);
                $r = str_replace($comma,$n,$r);
            }
            return floatval($r);
        }
        
        /**
        * removeAccent: remove todas as acentuações de uma String
        * @param String $str String a ser tratada
        * @return String sem acentuações
        */
		public static function removeAccent($str) {
			$keys = array();
			$values = array();
			preg_match_all('/./u', "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", $keys);
			preg_match_all('/./u', "aaaaeeiooouucAAAAEEIOOOUUC", $values);
			$mapping = array_combine($keys[0], $values[0]);
			return strtr($str, $mapping);
		}
        /**
        * toMinText: encurta uma String a partir de um limite de caracteres, se extrapolá-lo.
        * Nota: Isto não previne quebras de estruturas HTML. Por exemplo, um trecho <p>...</p> pode acabar como <p>..</, quebrando a estrutura por completo. Logo não é recomendável utilizar em campos com implementações em HTML (tinyMCE).
        * @param String $string String a ser delimitada
        * @param int $words quantidade de caracteres aceitos
        * @param String $charset a codificação do texto a ser delimitado
        * @return String delimitada
        */
		public static function toMinText($string, $words = 100, $charset = "utf-8"){
			$count = mb_strlen(strip_tags($string));
			if($count <= $words) return $string;
			return mb_substr($string,0,$words-3, $charset).'...';
		}
		
        /**
        * HTML: converte todas as quebras de linha inválidas (\r\n) em $alternative_breakline para previnir falhas de tratamento tanto em PHP quanto em Javascript.
        * @param String $string String a ser tratada
        * @param String $alternative_breakline String a substituir quebras de linha inválidas. Padrão: ''. Pode ser usada para substituir por '<br/>', por exemplo.
        * @return String tratada
        */
		public static function HTML($string, $alternative_breakline = '') {
			return self::parseHTML(str_replace(array("\r", "\n"), $alternative_breakline, $string));
		}
        public static function parseHTML($HTML) {
            $rule = "~data:image/[a-zA-Z]*;base64,[a-zA-Z0-9+/=]*~";
            $offset = $last_offset = 0;
            $converted = $matches = array();
            while(preg_match($rule, $HTML, $matches, PREG_OFFSET_CAPTURE, $offset)) {
                list($input, $current_offset) = $matches[0];
                $last_offset = $offset;
                $offset = $current_offset+1;
                $output = self::base64_to_file($input);
                if($output != "") {
                    $HTML = str_replace($input, PUBLIC_URL.$output, $HTML);
                    $offset = $last_offset;
                    $converted[$input] = $output;
                }
            }
            return $HTML;
        }
        public static function base64_to_file($input, $folder = "uploads/editor/", $folder_mode = 0755, $base64_separator = ",", $data_separator = ";", $mimetype_separator = "/", $pre_folder = "../", $top_reference = "lab/lib") {
            $output = '';
            if(strpos($input, $base64_separator) === false || strpos($input, $data_separator) === false || strpos($input, $mimetype_separator) === false)
                return $output;
            try {
                list($data, $base64) = explode($base64_separator, $input);
                list($data, $code) = explode($data_separator, $data);
                if($code !== "base64")
                    return $output;
                list(,$format) = explode($mimetype_separator, $data);
                $base = "";
                while(!file_exists($base.$top_reference))
                    $base.=$pre_folder;
                $base.="lab/";
                if(!is_dir($base.$folder))
                    mkdir($base.$folder, $folder_mode, $recursive = true);
                $filename = uniqid().md5(date("YmdHis")).".".strtolower($format);
                $output = $folder.$filename;
                $output_file = $base.$output;
                $file = fopen($output_file, 'wb');
                fwrite($file, base64_decode($base64));
                fclose($file);
            } catch(Exception $e) {
            }
            return $output;
        }
		/**
        * toURL: transforma uma String em uma URL, desfazendo acentuações, removendo caracteres inválidos e convertendo espaçamentos em "-".
        * @param String $string String a ser transformada
        * @return String transformada
        */
		public static function toURL($string){
            $string = strip_tags(html_entity_decode($string));
			$pattern_a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
			$pattern_b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
			return strtolower(utf8_encode(str_replace(array("-----","----","---","--"),"-",str_replace(" ","-",strip_tags(trim(strtr(utf8_decode($string), utf8_decode($pattern_a), $pattern_b)))))));
		}
        /**
        * fullphone: formato uma String em telefone internacional (BR)
        * Exemplo:
            echo Format::fullphone('(79) 99161-9154');
            # imprime '+5579991619154'
        * @param String $phone String com o formato de telefone (de acordo com a função isPhone)
        * @return String formatada.
        */
        public static function fullphone($phone) {
            if(!self::isPhone($phone))
                return '';
            return "+55".(preg_replace('/[^0-9]/','',$phone));
        }
		
        /**
        * getMenu: transforma um array em um menu padrão do Versa
        * Exemplo:
            $menu = array(
                "javascript:umafuncao()" => "Item 1",
                "umlink.php" => "Item 2"
            );
            echo Format::getMenu($menu);
            # imprime '<div class="btn-group"><a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <span class="caret"></span></a><ul role="menu" class="dropdown-menu pull-right"><li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="umafuncao()">Item 1</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="umlink.php">Item 2</a></li></ul></div>'
        * @param array $menu array de strings indexado por strings, onde os índices representam os links/as funções e os valores representam os botões do menu
        * @return String do menu inteiro
        */
		public static function getMenu(array $menu) { //must be array("link" => "text"
			if(empty($menu)) return '';
			$str = '<div class="btn-group"><a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <span class="caret"></span></a><ul role="menu" class="dropdown-menu pull-right">';
			foreach($menu as $link => $text) {
				if(strpos($link, "script:") > 0) {
					$click = ' onClick="'.substr($link,11).'"';
					$link = "#";
				} else $click = '';
				$str.='<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$link.'"'.$click.'>'.$text.'</a></li>';
			}
			$str .= '</ul></div>';
			return $str;
		}
		
        /**
        * getSimpleMenu: getMenu alterado, transforma um array em um menu simplificado
        * Exemplo:
            $menu = array(
                "javascript:umafuncao()" => "Item 1",
                "umlink.php" => "Item 2"
            );
            echo Format::getSimpleMenu($menu);
            # imprime '<div class="btn-group"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i></a><ul role="menu" class="dropdown-menu pull-right"><li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="umafuncao()">Item 1</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="umlink.php">Item 2</a></li></ul></div>'
        * @param array $menu array de strings indexado por strings, onde os índices representam os links/as funções e os valores representam os botões do menu
        * @return String do menu inteiro
        */
		public static function getSimpleMenu(array $menu) { //must be array("link" => "text"
			if(empty($menu)) return '';
			$str = '<div class="btn-group"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i></a><ul role="menu" class="dropdown-menu pull-right">';
			foreach($menu as $link => $text) {
				if(strpos($link, "script:") > 0) {
					$click = ' onClick="'.substr($link,11).'"';
					$link = "#";
				} else $click = '';
				$str.='<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$link.'"'.$click.'>'.$text.'</a></li>';
			}
			$str .= '</ul></div>';
			return $str;
		}
		
        /**
        * getPanelMenu: getMenu alterado, transforma um array em um menu simplificado para bootstrap .panel baseado no Versa
        * Exemplo:
            $menu = array(
                "javascript:umafuncao()" => "Item 1",
                "umlink.php" => "Item 2"
            );
            echo Format::getPanelMenu($menu);
            # imprime '<div class="panel-tools"><a class="btn btn-xs btn-link" href="#" onclick="umafuncao()">Item 1</a><a class="btn btn-xs btn-link" href="umlink.php">Item 2</a></div>'
        * @param array $menu array de strings indexado por strings, onde os índices representam os links/as funções e os valores representam os botões do menu
        * @return String do menu inteiro
        */
		public static function getPanelMenu(array $menu) { //must be array("link" => "text"
			if(empty($menu)) return '';
			$str = '<div class="panel-tools">';
			foreach($menu as $link => $text) {
				if(strpos($link, "script:") > 0) {
					$click = ' onClick="'.substr($link,11).'"';
					$link = "javascript:void(0)";
				} else $click = '';
				$str.='<a class="btn btn-xs btn-link" href="'.$link.'"'.$click.'>'.$text.'</a>';
			}
			$str .= '</div>';
			return $str;
		}
		
		/**
        * getBreadcrumb: transforma um array em um breadcrumb padrão do Versa.
        * Exemplo:
			$bread = array(
				array("link" => "http://www.google.com.br/", "text" => "Google"),
				array("link" => "http://docs.google.com.br/", "text" => "Docs")
			);
			$breadcrumb = Format::getBreadcrumb($bread, "ASC");
			
        * É o mesmo que:
			
			$bread = array(
				array("link" => "http://docs.google.com.br/", "text" => "Docs"),
				array("link" => "http://www.google.com.br/", "text" => "Google")
			);
			$breadcrumb = Format::getBreadcrumb($bread);
            
            # ambos imprimem '<ol class="breadcrumb"><li><a href="http://www.google.com.br/">Google</a></li><li class="active">Docs</li></ol>'
        * @param array $breadcrumb array de array de strings indexado por strings, seguindo o modelo dos exemplos listados.
        * @param String $order pode ser "DESC" ou qualquer outro valor que o sistema considerará como "ASC", representando a ordem (DESC descendente, ASC ascendente).
        * @param boolean $has_form true/false indicando se há formulário de busca junto ao breadcrumb.
        * @return String do breadcrumb inteiro
		*/
		public static function getBreadcrumb(array $breadcrumb, $order = 'DESC', $has_form = false) { //must be array("link" => "text") for each element
			$str   = '<ol class="breadcrumb">';
			$DESC = $order === "DESC";
            $p = $has_form ? 1 : 0;
			$first = $DESC ? sizeof($breadcrumb)-1 : 0;
			$last  = $DESC ? 1+$p : sizeof($breadcrumb)-2-$p;
			$inc = $DESC ? -1 : 1;
			$active = $last+$inc;
			for($i=$first;$DESC ? $i>=$last : $i<=$last; $i+=$inc) {
				$elem = $breadcrumb[$i];
                $link = isset($elem["link"]) ? $elem["link"] : "javascript::void(0)";
                $target = isset($elem["target"]) ? ' target="'.$elem["target"].'"' : '';
                $onclick = isset($elem['onclick']) ? ' onClick="'.$elem["onclick"].'"' : '';
                $str.='<li><a href="'.$link.'"'.$target.$onclick.'>'.$elem["text"].'</a></li>';
			}
			$elem = $breadcrumb[$active];
			$str  .= '<li class="active">'.$elem["text"].'</li>';
            if($has_form) {
                $elem = $breadcrumb[$active+$inc];
                $str.='<li class="search-box">
                <form class="sidebar-search">
                <div class="form-group">
                <input type="text" placeholder="Pesquisar..." value="'.$elem['text'].'" name="k" data-default="130" style="width: 130px" />
                <button class="submit" type="submit">
                <i class="clip-search-3"></i>
                </button>
                </div>
                </form>
                </li>';
            }
            $str.='</ol>';
			return $str;
		}
        
        public static function getPopover($text, $title, $data) {
            if(is_array($data)) {
                $content = $br = "";
                foreach($data as $in => $out) {
                    $content.=$br."<strong>".str_replace('"', "\\'", $in)."</strong>: ".str_replace('"', "\\'", $out);
                    $br = "<br/>";
                }
            } else
                $content = $data."";
            return '<a class="html-popover" data-placement="top" data-original-title="'.str_replace('"', "\\'", $title).'" data-content="'.$content.'" href="javascript:;">'.$text.'</a>';
        }
        
        /**
        * userLog: converte um array $log em um link
        * @param array $log a linha a ser convertida
        * @return String convertido ou "indefinido" se a linha estiver vazia
        */
        public static function userLog($log) {
            return empty($log) ? "indefinido" : '<a href="logs.php?uID='.$log[0]['userID'].'">'.$log[0]['user_name'].'</a>';
        }
		
        /**
        * fromDate: converte uma data d/m/Y para Y-m-d
        * @param String $date data a ser convertida
        * @param String $delimiter caractere que separa dia, mês e ano.
        * @return String convertida.
        */
		public static function fromDate($date, $delimiter = "/") {
			$date = explode(" ", $date);
			$hasTime = sizeof($date) == 2;
			$time = $hasTime ? " ".$date[1] : "";
			$date = explode($delimiter, $date[0]);
			return $date[2]."-".$date[1]."-".$date[0].$time;
		}
		
        /**
        * toSize: converte uma URL de imagem para uma URL formatada de uma resolução.
        * Exemplo:
            echo Format::toSize('imagens/arquivo-da-imagem.png', 'versaoreduzida');
            #imprime 'imagens/arquivo-da-imagem_versaoreduzida.png'
        * Amplamente utilizada por imagens recortadas do Versa
        * @param String $URL URL a ser convertida
        * @param String $resolution_name nome da dimensão da imagem
        * @return String convertida
        */
		public static function toSize($URL, $resolution_name) {
            if(strpos($URL, ".gif") !== false) {
                $base = "";
                while(!file_exists($base."lab/lib"))
                    $base.="../";
                $base.="lab/";
                if(File::animated_gif($base.$URL))
                    return $URL;
            }
            return str_replace(".", "_".$resolution_name.".", $URL);
		}
		
        /**
        * isCPF: verifica se uma String é um CPF legítimo
        * @param String $CPF String a ser verificada
        * @return true se é um CPF, false se não.
        */
		public static function isCPF($CPF){
			$CPF = preg_replace('/[^0-9]/','',$CPF);
            if(strlen($CPF) != 11)
                return false;
			$A = $B = 0;
			for($i = 0, $x = 10; $i <= 8; $i++, $x--) $A += $CPF[$i] * $x;
			for($i = 0, $x = 11; $i <= 9; $i++, $x--){
				if(str_repeat($i, 11) == $CPF) return false;
				$B += $CPF[$i] * $x;
			}
			return ((($A%11) < 2 ) ? 0 : 11-($A%11)) == $CPF[9] && ((($B%11) < 2 ) ? 0 : 11-($B%11)) == $CPF[10];
		}	
        
        public static function prepare_CNPJ($CNPJ) { //99999999999999 to 99.999.999/9999-99
            $CNPJ = preg_replace('/[^0-9]/','',$CNPJ);
            if(strlen($CNPJ) != 14)
                return '';
            return $CNPJ[0].$CNPJ[1].'.'.$CNPJ[2].$CNPJ[3].$CNPJ[4].'.'.$CNPJ[5].$CNPJ[6].$CNPJ[7].'/'.$CNPJ[8].$CNPJ[9].$CNPJ[10].$CNPJ[11].'-'.$CNPJ[12].$CNPJ[13];
        }
        public static function generateCNPJ() {
            $CNPJ = array("value" => array(), "query" => 0);
            for($i=0, $x = 5;$i<12;$i++, $x--) {
                if($x == 1)
                    $x = 9;
                $CNPJ['value'][$i] = intval(rand(0,9));
                $CNPJ['query'] += $CNPJ['value'][$i]*$x;
            }
            $query = intval($CNPJ['query']%11);
            $CNPJ['value'][12] = $query < 2 ? 0 : 11-$query;
            $CNPJ['query'] = 0;
            for($i=0, $x = 6; $i < 13; $i++, $x--) {
                if($x == 1)
                    $x = 9;
                $CNPJ['query'] += $CNPJ['value'][$i]*$x;
            }
            $query = intval($CNPJ['query']%11);
            $CNPJ['value'][13] = $query < 2 ? 0 : 11-$query;
            $value = "";
            for($i = 0; $i < 14; $i++)
                $value.=$CNPJ['value'][$i]."";
            return self::prepare_CNPJ($value);
        }
        public static function isCNPJ($CNPJ) { // '99.999.999/9999-99'
            $CNPJ = preg_replace('/[^0-9]/','',$CNPJ);
            if(strlen($CNPJ) != 14)
                return false;
            $A = $B = 0;
            for($i=0;$i<4;$i++) {
                $A += (5-$i)*($CNPJ[$i] + $CNPJ[8+$i]) + ((9-$i)*$CNPJ[4+$i]);
                $B += (6-$i)*($CNPJ[$i] + $CNPJ[8+$i]);
            }
            $A = 11-($A%11);
            if($A>=10)
                $A = 0;
            $B += 2*($CNPJ[4] + $CNPJ[12]);
            for($i=5;$i<8;$i++)
                $B += (14-$i)*$CNPJ[$i];
            $B = 11-($B%11);
            if($B >= 10)
                $B = 0;
            return $A == $CNPJ[12] && $B == $CNPJ[13];
        }
        
        /**
        * isMail: verifica se uma String é um e-mail legítimo
        * Nota I: isto não verifica se o e-mail existe
        * Nota II: não considera letras maiúsculas, por tanto, requer uma prévia transformação para LOWERCASE
        * @param String $mail String a ser verificada
        * @return true se segue o formato padrão de e-mails, false se não.
        */
		public static function isMail($mail){
			return preg_match('/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/', $mail);
		}
		
        /**
        * isPhone: verifica se uma String é um telefone legítimo segundo um dos formatos abaixo:
         -(99) 999-9999
         -(99) 9999-9999
         -(99) 99999-9999
        * Nota: isto não verifica se o telefone existe
        * @param String $phone String a ser verificada
        * @return true se segue um dos formatos, false se não
        */
		public static function isPhone($phone) {
			return preg_match('/^\([0-9]{2}\) [0-9]{3,5}-[0-9]{4}$/', $phone);
		}
		public static function isCelphone($phone) {
			return preg_match('/^\([0-9]{2}\) [0-9]{5}-[0-9]{4}$/', $phone);
		}
		public static function isTelephone($phone) {
			return preg_match('/^\([0-9]{2}\) [0-9]{3,4}-[0-9]{4}$/', $phone);
		}
		
        /**
        * isGlobalPhone: verifica se uma String é um telefone internacional legítimo, incluso DDI
        * Nota: isto não verifica se o telefone existe
        * @param String $phone String a ser verificada
        * @return true se segue um dos possíveis formatos, false se não
        */
		public static function isGlobalPhone($phone) { //com DDI embutido
			return preg_match('/^[+]{1}[0-9]{5,24}$/', $phone);
		}
		
        /**
        * isCEP: verifica se uma String é um CEP legítimo
        * Nota: isto não verifica se o CEP existe
        * @param String $CEP String a ser verificada
        * @return true se segue um dos formatos possívels, false se não
        */
		public static function isCEP($CEP) {
			return preg_match('/^[0-9]{5}-[0-9]{3}$/', $CEP);
		}
		
        /**
        * isLogin: verifica se uma String é um login legítimo
        * Nota: isto não verifica se o login existe
        * @param String $login String a ser verificada
        * @param int $minsize o menor número de caracteres que o login pode ter
        * @param int $maxsize o maior número de caracteres que o login pode ter
        * @return true se respeita os limites e é composto somente por letras sem acentos e números, false se não
        */
		public static function isLogin($login, $minsize = 5, $maxsize = 30) {
			return preg_match("/^[A-Za-z0-9]{".($minsize-1).",".($maxsize-1)."}$/", $login);
		}
		
        /**
        * isPassaport: supostamente verificaria se uma String é um passaporte legítimo, porém a função foi abandonada ainda durante o projeto "Padrão Tur", pois não foi estabelecido um padrão e a função foi deixada apenas para futuras alterações
        */
		public static function isPassaport($passaport) {
			//return preg_match('/^[0-9]{11}$/', $passaport);
			return true;
		}
		
        /**
        * isLogin: verifica se uma String é uma senha legítima
        * @param String $pass String a ser verificada
        * @return true se respeita os limites de 7 à 30 caracteres e é composto somente por letras sem acentos e números, false se não
        */
		public static function isPassword($pass) {
			return preg_match("/^[A-Za-z0-9]{6,29}$/", $pass);
		}
        
        public static function isURL($link) {
            return preg_match('/^(http:\/\/|https:\/\/)(([a-z0-9]([-a-z0-9]*[a-z0-9]+)?){1,63}\.)+[a-z]{2,6}/i', $link);
        }
        
        /**
        * isLink: verifica se uma String é um link legítimo
        * @param String $link String a ser verificada
        * @return true se é um link iniciado por http ou https (e o restante do link), false se não.
        */
        public static function isLink(&$link) {
            if(self::isURL($link))
                return true;
            elseif(self::isURL("http://".$link)) {
                $link = "http://".$link;
                return true;
            }
            return false;
        }

        public static function isDate($date, $allowBlank = false) {
            $regex = "/^(\d{2})\/(\d{2})\/(\d{4})$/";
            return ($date == "" && $allowBlank) || preg_match($regex, $date);
        }

        
        public static function isDateTime($datetime, $allowBlank = false) {
            $regex = "/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/";
            return ($datetime == "" && $allowBlank) || preg_match($regex, $datetime);
        }


        public static function prepareDate($date, $regex = "/^(\d{2})\/(\d{2})\/(\d{4})$/", $output = "$3-$2-$1") {
            if($date == "" && $output == "$3-$2-$1")
                return self::$DEFAULT_DATE;
            return preg_match($regex, $date) ? preg_replace($regex, $output, $date) : false;
        }
        public static function prepareDatetime($datetime, $regex = "/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/", $output = "$3-$2-$1 $4:$5:00") {
            if($datetime == "" && $output == "$3-$2-$1 $4:$5:00")
                return self::$DEFAULT_DATETIME;
            return preg_match($regex, $datetime) ? preg_replace($regex, $output, $datetime) : false;
        }
        public static function searchURI($x = NULL) {
            $output = array();
            $input = func_get_args();
            if(!empty($input))
                foreach($input as $data) {
                    $txt = self::removeAccent(trim($data));
                    $txt = strtolower(str_replace(array(",","=","-","+","[","]","{","}", " "), ";", $txt));
                    $txt_= explode(";", $txt);
                    foreach($txt_ as $t) {
                        $tt = Format::toURL($t);
                        if(!in_array($tt, $output) && strlen($tt) > 2)
                            $output[] = $tt;
                    }
                }
            return implode(";", $output);
        }
        public static function media($x = NULL) {
            $args = func_get_args();
            if($x === NULL || sizeof($args) == 0)
                return 0;
            $count = sizeof($args);
            $total = 0;
            foreach($args as $arg)
                if(is_numeric($arg))
                    $total+=$args;
            return $total/$count;
        }
        /**
        * function gcd: retorna o maior múltiplo comum (MDC, Greatest Common Divisor, em inglês)
        **/
        public static function gcd($a, $b) {
            return ($a % $b) ? self::gcd($b, $a % $b) : $b;
        }
        public static function ratio($width, $height) {
            $mdc = self::gcd($width, $height);
            return floor($width/$mdc).":".floor($height/$mdc);
        }
	}
?>