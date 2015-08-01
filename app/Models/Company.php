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
     * Gets the company's address.
     *
     * @return Address
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }
}
