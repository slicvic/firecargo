<?php namespace App\Models;

use Auth;

/**
 * Role
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Role extends Base {

    const LOGIN     = 1;
    const ADMIN     = 2;
    const AGENT     = 3;
    const CLIENT    = 4;

    protected $table = 'roles';

    public static $rules = [
        'name' => 'required',
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Retrives the friendly roles.
     *
     * @return Role[]
     */
    public static function allFriendly()
    {
        if (Auth::user()->isAdmin()) {
            $except = [self::LOGIN];
        }
        else {
            $except = [self::LOGIN, self::ADMIN];
        }

        return Role::whereNotIn('id', $except)->get();
    }
}
