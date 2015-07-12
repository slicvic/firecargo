<?php namespace App\Models;

use App\Models\CompanyTrait;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends Base {

    use CompanyTrait;

    protected $table = 'package_statuses';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'is_default'
    ];

    /**
     * Overrides parent method to add setting default status.
     *
     * @see parent::save()
     */
    public function save(array $options = array())
    {
        $result = parent::save($options);

        if ($result && $this->is_default)
        {
            // Unset the previous default status
            PackageStatus::where('company_id', $this->company_id)
                ->where('id', '<>', $this->id)
                ->update(['is_default' => 0]);
        }

        return $result;
    }
}
