<?php namespace App\Models;

class Company extends Base {

    protected $table = 'companies';

    public static $rules = [
        'name' => 'required',
        'code' => 'required'
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
}
