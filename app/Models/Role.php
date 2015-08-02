<?php namespace App\Models;

use Auth;

/**
 * Role
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Role extends Base {

    /**
     * The different types of roles.
     *
     * @var int
     */
    const SUPER_ADMIN = 1;
    const SUPER_AGENT = 2;
    const CUSTOMER    = 3;
    const AGENT       = 4;
    const ADMIN       = 5;

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];
}
