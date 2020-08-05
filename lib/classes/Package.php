<?php

include_once __DIR__ . "/lang/pt-br.php";
include_once __DIR__ . "/../conf/env.php";
include_once __DIR__ . "/../conf/constants.php";
include_once __DIR__ . "/../conf/urls.php";
include_once __DIR__ . "/../conf/newsletter.php";
include_once __DIR__ . "/../conf/functions.php";

/**
 * VERSA PRO v1.0
 * All classes were made by Kaique Garcia Menezes.
 * All layouts were made by Fabrício Souza Barreto and Jean Carvalho.
 **/
class Package
{
    private $packs;
    private $import_mode; //0 = packages - 1 = classes
    private $base;

    /**
     * Package constructor.
     * @param array|null $packs
     * @param bool $isPack
     * @param bool $autoload
     * @param bool $troubleshooting
     */
    public function __construct($packs = null, $isPack = true, $autoload = true, $troubleshooting = true)
    {
        $this->base = __DIR__ . DIRECTORY_SEPARATOR;
        if ($packs == null) {
            $packs = explode(",", PACKAGE);
        }
        if (!empty($packs)) {
            $this->packs = $packs;
            $this->import_mode = $isPack ? 0 : 1;
            if ($autoload && !$this->import() && $troubleshooting) {
                exit("<h2>ERRO - CLASSES INDEFINIDAS</h2><p>N&atilde;o foi poss&iacute;vel importar as classes de defini&ccedil;&atilde;o.</p>");
            }
        }
    }

    /**
     * THIS FUNCTION IS ONLY FOR DEBUG VARIABLES USING A VAR DUMP
     *
     * @param $var
     */
    public static function debug($var)
    {
        var_dump($var);
        return exit();
    }

    /**
     * @param $var
     * @return mixed
     */
    public function get($var)
    {
        return $this->{$var};
    }

    /**
     * @param array|null $packs
     * @param bool $isPack
     * @return bool
     */
    public function import($packs = null, $isPack = true)
    {
        $import_mode = $packs != null ? ($isPack ? 0 : 1) : $this->import_mode;
        $packs = $packs != null ? $packs : $this->packs;
        if ($packs != null && !is_array($packs)) {
            $packs = [$packs];
        }
        if ($packs != null && !empty($packs)) {
            $full_import = true;
            foreach ($packs as $pack) {
                if ($import_mode == 0) { //importing packs
                    $classes = glob($this->base . $pack . "/*.php");
                    if ($classes != null && !empty($classes)) {
                        foreach ($classes as $class) {
                            $full_import = $full_import && include_once($class);
                        }
                    }
                } else {
                    $name = file_exists($this->base . $pack) ? $pack : (file_exists($this->base . $pack . ".php") ? $pack . ".php" : null);
                    if ($name != null) {
                        $full_import = $full_import && include_once($this->base . $name);
                    } else {
                        $full_import = false;
                    }
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
    public static function getInfo()
    {
        return '<html lang="pt-br">
						<head>
							<meta charset="utf-8" />
							<meta name="author" content="Freedom Digital" />
							<meta name="version" content="' . Package::$version . '" />
							<title>' . Package::$title . '</title>
						</head>
						<body>
							<h1>' . Package::$title . '</h1>
							<h3 style="text-align: justify">Versão exclusiva de ' . PROJECT_NAME . '</h3>
							<h2><strong>Versão</strong> ' . Package::$version . '</h2>
							<h2><strong>PHP</strong> ' . phpversion() . '</h2>
							<hr>
							' . Package::$authors . '
							<hr>
							<span style="text-align: center">&copy; 2014-' . date("Y") . ' by Freedom Digital.</span>
						</body>
					</html>';
    }
}
