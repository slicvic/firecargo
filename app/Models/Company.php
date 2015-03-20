<?php namespace App\Models;

class Company extends BaseModel {
    protected $table = 'companies';

    public static $rules = [
        'name' => 'required',
        'code' => 'required'
    ];

    protected $fillable = [
        'name',
        'code'
    ];
}
