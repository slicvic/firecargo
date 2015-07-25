<?php namespace App\Helpers;

/**
 * Html
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Html {

    /**
     * Generates an HTML link with an icon.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @return string
     */
    public function linkWithIcon($url, $title, array $attributes = [])
    {
        return sprintf('<a href="%s"%s>%s</a> <i class="fa fa-link"></i>', $url, $this->attributes($attributes), $title);
    }

    /**
     * Generates a link for sorting a table column.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  string  $column
     * @param  string  $sort
     * @param  string  $order
     * @return string
     */
    public function linkToSorting($url, $title, $column, $sortColumn, $order)
    {
        $query = sprintf('?sort=%s&order=%s', $column, ($order === 'asc' ? 'desc' : 'asc'));
        $indicator = ($column === $sortColumn) ? ' <i class="fa fa-angle-' . ($order === 'asc' ? 'up' : 'down') . '"></i>' : '';

        return "<a href=\"{$url}{$query}\">{$title}{$indicator}</a>";
    }

    /**
     * Builds an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    private function attributes(array $attributes)
    {
        if ( ! count($attributes))
        {
            return '';
        }

        $html = [];

        foreach ($attributes as $name => $value)
        {
            $html[] = sprintf('%s="%s"', $name, $value);
        }

        return ' ' . implode(' ', $html);
    }
}
