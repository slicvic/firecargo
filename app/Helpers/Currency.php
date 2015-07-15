<?php namespace App\Helpers;

/**
 * Currency
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Currency {

    /**
     * Converts a number to a decimal dollar amount.
     *
     * @param  float $number
     * @param  bool  $showSign
     * @return string
     */
    public static function formatDollar($number, $showSign = TRUE)
    {
        $dollar = number_format($number, 2, '.', ',');

        return ($showSign) ? '$' . $dollar : $dollar;
    }
}
