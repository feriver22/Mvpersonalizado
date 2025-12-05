<?php

namespace Utilities;

class Validators
{
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isValidUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public static function isValidInt($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public static function isValidFloat($value)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function isEmpty($value)
    {
        return empty($value);
    }

    public static function minLength($value, $min)
    {
        return strlen($value) >= $min;
    }

    public static function maxLength($value, $max)
    {
        return strlen($value) <= $max;
    }

    public static function containsNumber($value)
    {
        return preg_match('/[0-9]/', $value);
    }

    public static function containsUpperCase($value)
    {
        return preg_match('/[A-Z]/', $value);
    }

    public static function containsSpecialChar($value)
    {
        return preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]/', $value);
    }

    public static function sanitizeInput($value)
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
?>
