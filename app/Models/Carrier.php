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
        'name' => ['required', 'min:3', 'regex:/(^[A-Za-z0-9() ]+$)+/']
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
     * Finds carriers matching the provided search term for an ajax
     * autocomplete field.
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

    /**
     * Normalizes a carrier name before saving to database.
     *
     * @param  string  $name
     * @return str
     */
    // public static function normalizeName($name)
    // {
    //     // 1. Strip all non alpha-numeric characters except spaces, (), /
    //     // 2. Strip consecutive spaces
    //     // 3. Trim and uppercase
    //     $name = preg_replace('/[^a-z0-9()\/ ]/i', '', $name);
    //     $name = preg_replace('/\s+/S', ' ', $name);
    //     $name = strtoupper(trim($name));

    //     return $name;
    // }
}
