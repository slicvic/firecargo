<?php namespace App\Models;

use App\Models\CompanySpecificTrait;

/**
 * Site
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Site extends Base {

    use CompanySpecificTrait;

    protected $table = 'sites';

    public static $rules = [
        'company_id' => 'required',
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
