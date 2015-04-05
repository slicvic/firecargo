<?php namespace App\Models;

use Auth;

class Role extends Base {

    const LOGIN     = 1;
    const ADMIN     = 2;
    const AGENT     = 3;
    const CLIENT    = 4;

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
        if (Auth::user()->isAdmin())
        {
            return parent::all($columns);
        }
        else
        {
            return Role::where('id', '<>', self::ADMIN)
                ->get($columns);
        }
    }
}
