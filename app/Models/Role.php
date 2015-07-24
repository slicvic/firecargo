<?php namespace App\Models;

use Auth;

/**
 * Role
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Role extends Base {

    /**
     * The roles enums.
     *
     * @var int
     */
    const SUPER_ADMIN = 1;
    const SUPER_AGENT = 3;
    const CLIENT      = 9;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

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
