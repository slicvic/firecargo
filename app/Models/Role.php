<?php namespace App\Models;

use Auth;

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
        'name',
        'description'
    ];

    public static function all($columns = ['*'])
    {
        if ( ! Auth::user()->isMaster())
        {
            return Role::where('id', '<>', self::MASTER)
                ->where('id', '<>', self::ADMIN)
                ->get($columns);
        }
        else
        {
            return parent::all($columns);
        }
    }
}
