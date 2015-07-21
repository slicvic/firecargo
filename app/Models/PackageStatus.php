<?php namespace App\Models;

use App\Models\CompanyTrait;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends Base {

    use CompanyTrait;

    /**
     * @var string
     */
    protected $table = 'package_statuses';

    /**
     * Rules for validation.
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'default'
    ];

    /**
     * Overrides parent method to set default status.
     *
     * @see parent::save()
     */
    public function save(array $options = array())
    {
        $result = parent::save($options);

        if ($result && $this->default)
        {
            // Unset the previous default status
            PackageStatus::where('company_id', $this->company_id)
                ->where('id', '<>', $this->id)
                ->update(['default' => FALSE]);
        }

        return $result;
    }
}
