<?php namespace App\Models;

class Role extends BaseModel {
    const LOGIN     = 1;
    const MASTER    = 2;
    const ADMIN     = 3;
    const MEMBER    = 4;

    protected $table = 'roles';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name'
    ];

    public static function all($columns = ['*'])
    {
        return Role::where('id', '<>', self::MASTER)->get($columns);
    }
}
