<?php namespace App\Models;

class PackageStatus extends BaseRestrictedAccess {

    protected $table = 'package_statuses';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name'
    ];
}
