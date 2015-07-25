<?php namespace App\Models;

use App\Observers\PackageStatusObserver;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends Base {

    use CompanyTrait;

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];
    
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'package_statuses';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'default'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        PackageStatus::observe(new PackageStatusObserver);
    }
}
