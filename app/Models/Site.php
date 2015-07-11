<?php namespace App\Models;

use App\Models\CompanyTrait;

/**
 * Site
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Site extends Base {

    use CompanyTrait;

    protected $table = 'sites';

    public static $rules = [
        'name' => 'required',
    ];

    protected $fillable = [
        'company_id',
        'name',
    ];

    /**
     * Gets the company.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
