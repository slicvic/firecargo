<?php namespace App\Models;

class Package extends BaseModel {

    protected $table = 'packages';

    public static $rules = [
        'site_id' => 'required',
    ];

    protected $fillable = [
        'site_id',
    ];
}
