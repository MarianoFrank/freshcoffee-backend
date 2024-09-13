<?php

namespace App\Helpers;


class NumberHelper
{

    public static function toBoolean($value)
    {
        if (is_string($value)) {
            $value = strtolower($value);
            if ($value === 'true' || $value === '1') {
                return true;
            } elseif ($value === 'false' || $value === '0') {
                return false;
            }
        }
        return '';
    }
}
