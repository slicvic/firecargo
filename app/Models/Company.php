<?php namespace App\Models;

use DB;

use App\Presenters\PresentableTrait;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends Base {

    use PresentableTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:3|alpha_num_spaces',
        'shortname' => 'required:between:2,10|alpha_num_spaces'

    ];

    /**
     * The presenter path.
     *
     * @var string
     */
    protected $presenter = 'App\Presenters\CompanyPresenter';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'shortname',
        'email',
        'phone',
        'fax',
        'has_logo'
    ];

    /**
     * Gets the address.
     *
     * @return Address
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }
}
