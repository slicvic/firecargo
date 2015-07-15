<?php namespace App\Helpers;

/**
 * Html
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Html {

    /**
     * Generates an HTML link.
     *
     * @param  string $url
     * @param  string $title
     * @param  array  $attributes
     * @param  bool   $showIcon
     * @return string
     */
    public static function link($url, $title, array $attributes = array(), $showIcon = FALSE)
    {
        $html = sprintf('<a%s href="%s">%s</a>', self::attributes($attributes), $url, $title);

        if ($showIcon)
        {
            $html .= ' <i class="fa fa-link"></i>';
        }

        return $html;
    }

    /**
     * Builds an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    private static function attributes(array $attributes)
    {
        $html = [];

        foreach ((array) $attributes as $name => $value)
        {
            $html[] = sprintf('%s="%s"', $name, $value);
        }

        return ' ' . implode(' ', $html);
    }
}
