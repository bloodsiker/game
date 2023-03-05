<?php

namespace App\Services;

class StrHelperService
{
    public static function numberFormat($number)
    {
        return number_format($number, 10, '.', '');
    }

    /**
     * $a + $b
     *
     * @param $a
     * @param $b
     * @param $accuracy
     *
     * @return string
     */
    public static function sum($a, $b, $accuracy)
    {
        return bcadd(self::numberFormat($a), self::numberFormat($b), $accuracy);
    }

    /**
     * $a - $b
     *
     * @param $a
     * @param $b
     * @param $accuracy
     *
     * @return string
     */
    public static function minus($a, $b, $accuracy)
    {
        return bcsub(self::numberFormat($a), self::numberFormat($b), $accuracy);
    }

    /**
     * $a / $b
     * @param $a
     * @param $b
     * @param $accuracy
     *
     * @return string|null
     */
    public static function div($a, $b, $accuracy)
    {
        return bcdiv(self::numberFormat($a), self::numberFormat($b), $accuracy);
    }

    /**
     * $a * $b
     *
     * @param $a
     * @param $b
     * @param $accuracy
     *
     * @return string
     */
    public static function mul($a, $b, $accuracy)
    {
        return bcmul(self::numberFormat($a), self::numberFormat($b), $accuracy);
    }
}
