<?php namespace App\Models;

use Auth;

/**
 * Role
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Role extends Base {

    /**
     * The types of roles.
     *
     * @var int
     */
    const SUPER_ADMIN = 1;
    const SUPER_AGENT = 3;
    const CLIENT      = 9;

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
