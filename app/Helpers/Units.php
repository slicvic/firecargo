<?php namespace App\Helpers;

/**
 * Units
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Units {

    /**
     * Converts pounds to kilos.
     *
     * @param  int|float $pounds
     * @param  int $precision
     * @return int
     */
    public static function poundsToKilos($pounds, $precision = 2)
    {
        return round($pounds * 0.453592, $precision);
    }
}
