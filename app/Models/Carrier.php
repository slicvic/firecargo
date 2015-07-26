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
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'carriers';

    /**
     * The presenter path.
     *
     * @var string
     */
    protected $presenter = 'App\Presenters\CarrierPresenter';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'prefix',
    ];

    /**
     * Overrides parent method to sanitize attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key)
        {
            case 'name':
                // Strip all non alpha-numeric characters except spaces, (), /
                $value = preg_replace('/[^a-z0-9()\/ ]/i', '', $value);
                // Strip consecutive spaces
                $value = preg_replace('/\s+/S', ' ', $value);
                // Trim and uppercase
                $value = strtoupper(trim($value));
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Finds carriers matching the given search term.
     *
     * @param  string  $searchTerm
     * @return User[]
     */
    public static function autocompleteSearch($searchTerm)
    {
        $searchTerm = '%' . $searchTerm . '%';

        return Carrier::whereRaw('
                id LIKE ?
                OR name LIKE ?
                OR code LIKE ?
                OR prefix LIKE ?', [
                $searchTerm,
                $searchTerm,
                $searchTerm,
                $searchTerm
            ])
            ->limit(25)
            ->get();
    }
}
