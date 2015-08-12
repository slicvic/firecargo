<?php namespace App\Models;

use DB;

/**
 * Address
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Address extends Base {

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country_id'
    ];

    /**
     * Override parent method to sanitize attributes.
     *
     * {@inheritdoc}
     */
    public function setAttribute($key, $value)
    {
        switch ($key) {
            case 'address1':
            case 'address2':
            case 'city':
            case 'state':
            case 'zip':
                $value = strtoupper(trim($value));
                break;
            case 'country_id':
                $value = empty($value) ? NULL : $value;
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get the country.
     *
     * @return Country
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * Convert the address into a friendly string.
     *
     * @param  string  $lineSeparator
     * @return string
     */
    public function toString($lineSeparator = '<br>')
    {
        $address = [];

        if ($this->address1)
        {
            $address[] = $this->address1;
        }

        if ($this->address2)
        {
            $address[] = $this->address2;
        }

        if ($this->city && $this->state)
        {
            $cityStateZip = $this->city . ', ' . $this->state;
        }
        else
        {
            $cityStateZip = $this->city . $this->state;
        }

        if ($this->postal_code)
        {
            $cityStateZip .= ' ' . $this->postal_code;
        }

        $cityStateZip = trim($cityStateZip);

        if ($cityStateZip)
        {
            $address[] = $cityStateZip;
        }

        if ($this->country_id)
        {
            $address[] = $this->country->name;
        }

        return strtoupper(implode($lineSeparator, $address));
    }
}
