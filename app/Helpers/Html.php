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
    public static function arrayToTags(array $values)
    {
        if (empty($values))
            return '';

        $str = '<div class="tag-list">';

        foreach($values as $value) {
            $str .= '<div class="tag-item">' . ucfirst($value) . '</div>';
        }

        $str .= '</div>';

        return $str;
    }
}
