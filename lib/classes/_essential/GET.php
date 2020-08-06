<?php

/**
 * Class GET
 *
 * @method static string|null ID()
 * @method static string|null pID()
 * @method static string|null uID()
 */
class GET
{
    public static function __callStatic($name, $arguments)
    {
        $default = isset($arguments[0]) ? $arguments[0] : null;
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }
}
