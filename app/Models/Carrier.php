<?php namespace App\Models;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends Base {

    protected $table = 'carriers';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name'
    ];
}
