<?php namespace App\Models;

use Auth;
use App\Presenters\PresentableTrait;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends Base {

    use PresentableTrait;

    /**
     * @var string
     */
    protected $table = 'carriers';

    /**
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\Carrier';

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'prefix',
    ];

    /**
     * Finds carriers matching the given search term.
     *
     * @param  string  $searchTerm
     * @return User[]
     */
    public static function autocompleteSearch($searchTerm)
    {
        $searchTerm = '%' . $searchTerm . '%';

        return Carrier::whereRaw('id LIKE ? OR name LIKE ?', [$searchTerm, $searchTerm])
            ->limit(25)
            ->get();
    }

    /**
     * Overrides parent method to sanitize certain attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key)
        {
            case 'name':
                $value = self::sanitizeName($value);
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Sanitizes a carrier name.
     *
     * @param  string  $name
     * @return string
     */
    public static function sanitizeName($name)
    {
        // Strip all non-alpha-numeric characters except spaces, (), /
        $name = preg_replace('/[^a-z0-9()\/ ]/i', '', $name);
        // Strip consecutive spaces
        $name = preg_replace('/\s+/S', ' ', $name);
        // Trim and uppercase
        $name = strtoupper(trim($name));

        return $name;
    }
}
