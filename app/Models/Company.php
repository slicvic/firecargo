<?php namespace App\Models;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends Base {

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
}
