<?php namespace App\Models;

use Auth;

/**
 * Role
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Role extends Base {

    const ADMIN     = 1;
    const AGENT     = 3;
    const CLIENT    = 4;
    const SHIPPER   = 5;

    protected $table = 'roles';

    public static $rules = [
        'name' => 'required',
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Retrieves roles based on the current user's role.
     *
     * @return Role[]
     */
    public static function allFiltered()
    {
        $except = Auth::user()->isAdmin() ? [] : [self::ADMIN];

        return Role::whereNotIn('id', $except)->get();
    }
}
