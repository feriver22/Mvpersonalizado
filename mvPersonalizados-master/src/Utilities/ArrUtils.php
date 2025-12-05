<?php

namespace Utilities;

class ArrUtils
{
    public static function findFirst($array, $key, $value)
    {
        foreach ($array as $item) {
            if (is_object($item)) {
                if (isset($item->$key) && $item->$key == $value) {
                    return $item;
                }
            } else {
                if (isset($item[$key]) && $item[$key] == $value) {
                    return $item;
                }
            }
        }
        return null;
    }

    public static function findAll($array, $key, $value)
    {
        $result = array();
        foreach ($array as $item) {
            if (is_object($item)) {
                if (isset($item->$key) && $item->$key == $value) {
                    $result[] = $item;
                }
            } else {
                if (isset($item[$key]) && $item[$key] == $value) {
                    $result[] = $item;
                }
            }
        }
        return $result;
    }
}
?>
