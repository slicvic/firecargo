<?php

namespace App\Helpers;

/**
 * Math
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Math {

    /**
     * Convert pounds to kilos.
     *
     * @param  int|float  $pounds
     * @param  int        $precision
     * @return int
     */
    public static function lbToKg($pounds, $precision = 2)
    {
        return round($pounds * 0.453592, $precision);
    }

    /**
     * Calculate the volume weight of a package in pounds.
     *
     * @param  float  $length
     * @param  float  $width
     * @param  float  $height
     * @return float
     */
    public static function calculateVolumeWeight($length, $width, $height)
    {
        $result = ($length * $width * $height) / 166;

        return $result;
    }

    /**
     * Calculate the cubic feet of a package.
     *
     * @param  float  $length
     * @param  float  $width
     * @param  float  $height
     * @return float
     */
    public static function calculateCubicFeet($length, $width, $height)
    {
        $result = ($length * $width * $height) * 0.00057870;

        return $result;
    }

    /**
     * Calculate the cubic feet of a package.
     *
     * @param  float  $length
     * @param  float  $width
     * @param  float  $height
     * @return float
     */
    public static function calculateCubicMeter($length, $width, $height)
    {
        $result = self::calculateCubicFeet($length, $width, $height) / 35.315;

        return $result;
    }
}
