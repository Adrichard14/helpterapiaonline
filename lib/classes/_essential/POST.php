<?php

/**
 * Class POST
 *
 * @method static string|null notificationCode()
 * @method static string|null notificationType()
 */
class POST
{
    public static function __callStatic($name, $arguments)
    {
        $default = isset($arguments[0]) ? $arguments[0] : null;
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }
}
