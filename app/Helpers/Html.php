<?php namespace App\Helpers;

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
    public static function arrayToLabels(array $values)
    {
        if (empty($values))
        {
            return '';
        }
        else
        {
            $ret = '';

            foreach($values as $value)
            {
                $ret .= ' <span class="badge badge-info">' . ucfirst($value) . '</span>';
            }

            return $ret;
        }
    }
}
