<?php namespace App\Models;

use Auth;

/**
 * Role
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Role extends Base {

    /**
     * @var int
     */
    const SUPER_ADMIN = 1;
    const SUPER_AGENT = 3;
    const CLIENT      = 9;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * Rules for validation.
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];
}
