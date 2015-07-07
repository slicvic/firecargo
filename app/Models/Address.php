<?php namespace App\Models;

use DB;

/**
 * Address
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Address extends Base {

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'company_id',
        'account_id',
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
     * Gets the user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Gets the company.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\User', 'company_id');
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
     * Converts the address into an array.
     *
     * @return array
     */
    public function asArray()
    {
        $address = [];

        if ($this->address1) {
            $address[] = $this->address1;
        }

        if ($this->address2) {
            $address[] = $this->address2;
        }

        if ($this->city && $this->state) {
            $line3 = $this->city . ', ' . $this->state;
        }
        else {
            $line3 = $this->city . $this->state;
        }

        if ($this->postal_code) {
            $line3 .= ' ' . $this->postal_code;
        }

        $address[] = trim($line3);

        if ($this->country_id) {
            $address[] = $this->country->name;
        }

        return $address;
    }

    /**
     * Converts the address into a string.
     *
     * @param  string $lineSeparator
     * @return string
     */
    public function asString($lineSeparator = '<br>')
    {
        return implode($lineSeparator, $this->asArray());
    }
}
