<?php namespace App\Models;

use DB;
use App\Models\CompanySpecificTrait;

/**
 * Container
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Container extends Base {

    use CompanySpecificTrait;

    protected $table = 'containers';

    public static $rules = [
        'company_id' => 'required',
        'tracking_number' => 'required|unique:containers,tracking_number'
    ];

    protected $fillable = [
        'company_id',
        'tracking_number',
    ];
}
