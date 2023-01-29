<?php

namespace Lib\Application;

trait Singleton
{
    private static $instance;

    public static function instance()
    {
        if (self::$instance == null) {
            return new self;
        }

        return self::$instance;
    }
}