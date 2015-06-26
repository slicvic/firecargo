<?php namespace App\Helpers;

/**
 * Html
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Html {

    /**
     * Gets HTML for the main sidenav pointer arrow.
     *
     * @return string
     */
    public static function sideNavPointer()
    {
        return '<div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>';
    }

    /**
     * Converts an array into bootstrap labels.
     *
     * @return string
     */
    public static function arrayToBadges(array $values)
    {
        if (empty($values))
            return '';

        $str = '';

        foreach($values as $value) {
            $str .= ' <span class="badge badge-info">' . ucfirst($value) . '</span>';
        }

        return $str;
    }
}
