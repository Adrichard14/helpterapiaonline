<?php

define('HTTP_SCHEME', (isset($_SERVER['HTTPS']) ? 'https://' : 'http://'));
define('PUBLIC_URL', HTTP_SCHEME . $_SERVER['HTTP_HOST'] . FOLDER);
define('PAG_HOME', PUBLIC_URL);
define('OUT', PUBLIC_URL . 'out/');
define('RESPONSES', OUT . 'responses/');
define('IMG', PUBLIC_URL . 'tim.php?src=');
define('FACEBOOK_URL', 'https://www.facebook.com/iocmjardinsaju/');
define('INSTAGRAM_URL', 'http://instagram.com/iocmjardinsaju');
