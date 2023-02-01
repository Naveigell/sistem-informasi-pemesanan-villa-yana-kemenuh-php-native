<?php

namespace Lib\Session;

class Session
{
    public static function get($key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function forget($key)
    {
        if (self::get($key)) {
            unset($_SESSION[$key]);
        }
    }

}