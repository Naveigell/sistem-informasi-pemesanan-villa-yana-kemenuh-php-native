<?php

namespace Lib\Arr;

class Arr
{
    public static function only(array $array, $keys)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        return array_filter($array, function ($value, $key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_BOTH);
    }
}