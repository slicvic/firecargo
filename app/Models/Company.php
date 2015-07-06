<?php namespace App\Models;

use App\Presenters\PresentableTrait;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends Base {

    use PresentableTrait;

    protected $presenter = 'App\Presenters\Company';

    protected $table = 'companies';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country_id'
    ];

    /**
     * Gets the country.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * Overrides parent method to sanitize certain attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key) {
            case 'city':
            case 'state':
                $value = ucwords(strtolower(trim($value)));
                break;

            case 'address1':
            case 'address2':
                $value = strtoupper(trim($value));
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Checks if a logo image file exists.
     *
     * @param  string $size sm|md|lg
     * @return bool
     */
    public function hasLogo($size)
    {
        $path = 'uploads/companies/' . $this->id . '/images/logo/' . $size . '.png';
        return file_exists(public_path() . '/' . $path);
    }
}
