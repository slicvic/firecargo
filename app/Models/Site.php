<?php namespace App\Models;

/**
 * Site
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Site extends Base {

    use CompanyTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'sites';

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
        'company_id',
        'name',
    ];
}
