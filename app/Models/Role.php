<?php namespace App\Models;

use Auth;

class Role extends BaseModel {

    const LOGIN     = 1;
    const ADMIN     = 2;
    const MERCHANT  = 3;
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
        if ( ! Auth::user()->isAdmin())
        {
            return Role::where('id', '<>', self::ADMIN)
                ->where('id', '<>', self::MERCHANT)
                ->get($columns);
        }
        else
        {
            return parent::all($columns);
        }
    }
}
