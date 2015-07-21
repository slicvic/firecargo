<?php namespace App\Models;

/**
 * Site
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Site extends Base {

    use CompanyTrait;

    /**
     * @var string
     */
    protected $table = 'sites';

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
        'company_id',
        'name',
    ];
}
