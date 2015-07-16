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

    protected $presenter = 'App\Presenters\Carrier';

    protected $table = 'carriers';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'code',
        'prefix',
        'creator_user_id'
    ];

    /**
     * Retrieves a list of carriers for a jquery autocomplete field.
     *
     * @param  string $q  A search term
     * @return User[]
     */
    public static function autocompleteSearch($q)
    {
        $q = '%' . $q . '%';

        return Carrier::whereRaw('id LIKE ? OR name LIKE ?', [$q, $q])
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
     * Sanitizes a carrier name for database storage
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
