<?php
    include_once("lang/pt-br.php");
	date_default_timezone_set("America/Sao_Paulo");
    ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
    # CONFIGs
  
    define('PACKAGE', '_essential,basic,newsletter,ecommerce,ecommerce/pagseguro, ecommerce_appointment/pagseguro');
    if(strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        # CONFIGURAÇÃO LOCALHOST
        define('FOLDER', '/help/');
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'freed054_help');
        define('DISABLE_NEWSLETTER', true);
    } else {
        # CONFIGURAÇÃO SERVIDOR (produção)
        define('FOLDER', '/new/');
        define('DB_HOST', 'localhost');
        define('DB_USER', 'freed054_help');
        define('DB_PASSWORD', 'help#$%29');
        define('DB_NAME', 'freed054_help');
        define('DISABLE_NEWSLETTER', false);
    }
   	
    define('HTTP_SCHEME',               (isset($_SERVER['HTTPS']) ? 'https://' : 'http://'));
    # LINK DO PROJETO ATUAL:
    $atAccess2 = isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'acesso2') !== false;
    define('PUBLIC_URL',                HTTP_SCHEME.$_SERVER['HTTP_HOST'].FOLDER);

    define('PROJECT_NAME','HELP Terapia Online');
    # CONFIGURAÇÕES DE NEWSLETTER
    // define('NL_PHPMAILER', false);
    // define('NL_LIMIT_PH', 15); //limite de e-mails por hora
    // define('NL_FROM_MAIL', 'naoresponda@');
    // define('NL_FROM_NAME', PROJECT_NAME);
    // define('NL_HOST', 'ssl://email-ssl.com.br');
    // define('NL_PORT', 465);
    // define('NL_USER', 'naoresponda@');
    // define('NL_PASSWORD', '');
    // define('NOW', date("Y-m-d H:i:s"));
    // define('NOW_DATE', date("Y-m-d"));
	 define('NL_PHPMAILER', false);
    define('NL_LIMIT_PH', 200); //limite de e-mails por hora
    define('NL_FROM_MAIL', 'naoresponda@helpterapia.com.br');
    define('NL_FROM_NAME', PROJECT_NAME);
    define('NL_HOST', 'mail.helpterapia.com.br');
    define('NL_PORT', 465);
    define('NL_USER', 'atendimento@helpterapia.com.br');
    define('NL_PASSWORD', 'help2020');
    define('NOW', date("Y-m-d H:i:s"));
    define('NOW_DATE', date("Y-m-d"));
    
    # DEFINIÇÃO DE URL'S
    define('PAG_HOME', PUBLIC_URL);
    define('OUT', PUBLIC_URL.'out/');
    define('RESPONSES', OUT.'responses/');
    define('IMG', PUBLIC_URL.'tim.php?src=');
    define('FACEBOOK_URL',  'https://www.facebook.com/iocmjardinsaju/');
    define('INSTAGRAM_URL', 'http://instagram.com/iocmjardinsaju');

    function URLout($URL) {
        return str_replace(PUBLIC_URL, '@main@', $URL);
    }
    function URLin($URL) {
        return str_replace('@main@', PUBLIC_URL, $URL);
    }
    
	/**
	* VERSA PRO v1.0
	* All classes were made by Kaique Garcia Menezes.
	* All layouts were made by Fabrício Souza Barreto and Jean Carvalho.
	**/
	
	class Package {
		private $packs;
		private $import_mode; //0 = packages - 1 = classes
		private $base;
		
		public function __construct($packs = NULL, $isPack = true, $autoload = true, $troubleshooting = true) {
			$this->base = __DIR__.DIRECTORY_SEPARATOR;
            if($packs == NULL)
                $packs = explode(",", PACKAGE);
			if(!empty($packs)) {
				$this->packs = $packs;
				$this->import_mode = $isPack ? 0 : 1;
				if($autoload && !$this->import() && $troubleshooting) exit("<h2>ERRO - CLASSES INDEFINIDAS</h2><p>N&atilde;o foi poss&iacute;vel importar as classes de defini&ccedil;&atilde;o.</p>");
			}
		}
		
		/**
		 * THIS FUNCTION IS ONLY FOR DEBUG VARIABLES USING A VAR DUMP
		 */
		public static function debug($var){
			return exit(var_dump($var));
		}
		public function get($var) {
			return $this->{$var};
		}
		
		/**
		*	boolean import()
		*	returns true when included all packs on list or false when some error occurs
		*
		*	We work with includes (and not requires) to give a chance to control situations when the page can't import some class
		*	There's two ways to import packs: by constructor (recomended) or directly on this function.
		*	---BY CONSTRUCTOR:
		*		$package = new Package(array('sample', 'sample2'));
		*	---ON THIS FUNCTION
		*		$package = new Package(); $package->import(array('sample', 'sample2'));
		*
		*	Importing classes, not packages:
		*	---BY CONSTRUCTOR:
		*		$package = new Package(array('sample/class1', 'sample2/class2'), false);
		*	---ON THIS FUNCTION
		*		$package = new Package(); $package->import(array('sample/class1', 'sample2/class2'), false);
		*
		*	PS: you can call 'sample/class1' or 'sample/class1.php'.
		*	PS(2): if you want to get this return, you need to import on this function!
		*
		*	Recomended way:
		*		$package = new Package(array('sample', 'sample2'), true, false); //the last false refers to $autoload, so you will need to call this method
		*		$imported = $package->import(); //whatever, if you will import classes, just turn false the second arg on constructor.
		**/
		public function import($packs = NULL, $isPack = true) {
			$import_mode = $packs != NULL ? ($isPack ? 0 : 1) : $this->import_mode;
			$packs = $packs != NULL ? $packs : $this->packs;
			if($packs != NULL && !is_array($packs)) $packs = array($packs);
			if($packs != NULL && !empty($packs)) {
				$full_import = true;
				foreach($packs as $pack) {
					if($import_mode == 0) { //importing packs
						$classes = glob($this->base.$pack."/*.php");
						if($classes != NULL && !empty($classes))
							foreach($classes as $class) {
								$full_import = $full_import && include_once($class);
                            }
					} else {
						$name = file_exists($this->base.$pack) ? $pack : (file_exists($this->base.$pack.".php") ? $pack.".php" : NULL);
						if($name != NULL) {
							$full_import = $full_import && include_once($this->base.$name);
						} else $full_import = false;
					}
				}
			}
			return isset($full_import) && $full_import;
		}
		
		
		//VERSA PRO INFO's
		private static $version = "2.1.0";
		private static $authors = "<ul>
								<li>PHP (all scripts) - <strong>Victor Gabriel</strong></li>
								<li>Front-end layout codes & development - <strong>Fabrício Souza</strong></li>
							</ul>";
		private static $title = "Versa PRO";
		//Método secreto: este método não será incluído nas documentações pois terá como única finalidade resgatar informações sobre versão e etc.
		public static function getInfo() {
			return '<html lang="pt-br">
						<head>
							<meta charset="utf-8" />
							<meta name="author" content="Freedom Digital" />
							<meta name="version" content="'.Package::$version.'" />
							<title>'.Package::$title.'</title>
						</head>
						<body>
							<h1>'.Package::$title.'</h1>
							<h3 style="text-align: justify">Versão exclusiva de '.PROJECT_NAME.'</h3>
							<h2><strong>Versão</strong> '.Package::$version.'</h2>
							<h2><strong>PHP</strong> '.phpversion().'</h2>
							<hr>
							'.Package::$authors.'
							<hr>
							<span style="text-align: center">&copy; 2014-'.date("Y").' by Freedom Digital.</span>
						</body>
					</html>';
		}
	}
?>