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
        'name' => 'required|min:3|alpha_spaces'
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
     * Override parent method to sanitize attributes.
     *
     * {@inheritdoc}
     */
    public function setAttribute($key, $value)
    {
        switch ($key)
        {
            case 'name':
                $value = strtoupper($value);
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Find carriers matching the provided search term for an ajax
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
}
