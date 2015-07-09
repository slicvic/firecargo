<?php namespace App\Helpers;

/**
 * Html
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Html {

    /**
     * Converts an array into bootstrap labels.
     *
     * @param  array $values
     * @return string
     */
    public static function arrayToBadges(array $values)
    {
        if (empty($values))
            return '';

        $html = '';

        foreach($values as $value) {
            $html .= '<div class="badge badge-warning btns-xs">' . ucfirst($value) . '</div><br>';
        }

        return $html;
    }
}
