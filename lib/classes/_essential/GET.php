<?php

/**
 * Class GET
 *
 * @method static string|null ID()
 * @method static string|null pID()
 * @method static string|null uID()
 * @method static string|null transactionId()
 * @method static string|null planId()
 * @method static string|null customerId()
 * @method static string|null eventId()
 * @method static string|null clientId()
 */
class GET
{
    public static function __callStatic($name, $arguments)
    {
        $default = isset($arguments[0]) ? $arguments[0] : null;
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }
}
