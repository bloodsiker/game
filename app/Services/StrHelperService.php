<?php

namespace App\Services;

class StrHelperService
{
    public static function numberFormat($number)
    {
        return number_format($number, 10, '.', '');
    }
}
