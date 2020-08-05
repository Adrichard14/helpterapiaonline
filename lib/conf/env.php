<?php

date_default_timezone_set("America/Sao_Paulo");
define('PACKAGE', '_essential,basic,newsletter,ecommerce,ecommerce/pagseguro');
if (strpos($_SERVER['HTTP_HOST'], "help.localhost") !== false) {
    # CONFIGURAÇÃO HELP.LOCALHOST
    define('FOLDER', '/');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'freed054_help');
    define('DISABLE_NEWSLETTER', true);
    define('TEST_MODE', true);
} elseif (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    # CONFIGURAÇÃO LOCALHOST
    define('FOLDER', '/help/');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'freed054_help');
    define('DISABLE_NEWSLETTER', true);
    define('TEST_MODE', true);
} else {
    # CONFIGURAÇÃO SERVIDOR (produção)
    define('FOLDER', '/new/');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'freed054_help');
    define('DB_PASSWORD', 'help#$%29');
    define('DB_NAME', 'freed054_help');
    define('DISABLE_NEWSLETTER', false);
    define('TEST_MODE', false);
}

if (TEST_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
