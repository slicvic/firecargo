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

    /**
     * Overrides parent method to filter records base on the current
     * user level.
     *
     * @param  array $columns
     * @return [][]
     */
    public static function all($columns = ['*'])
    {
        if (Auth::user()->isAdmin())
        {
            // Return all roles
            return parent::all($columns);
        }
        else
        {
            // Return all roles except 'ADMIN'
            return Role::where('id', '<>', self::ADMIN)
                ->get($columns);
        }
    }
}
