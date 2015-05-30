<?php namespace App\Models;

class PackageType extends BaseSiteSpecific {

    protected $table = 'package_types';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name',
        'deleted'
    ];
}
