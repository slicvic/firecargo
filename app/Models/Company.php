<?php namespace App\Models;

use DB;

use App\Presenters\PresentableTrait;
use App\Helpers\Upload;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends Base {

    use PresentableTrait;

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\Company';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'corp_code',
        'email',
        'phone',
        'fax',
        'has_logo'
    ];

    /**
     * Gets the company address.
     *
     * @return Address
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * Gets the company logo URL.
     *
     * @param  string  $size  sm|md|lg
     * @return string
     */
    public function logoUrl($size = 'sm')
    {
        if ($this->has_logo)
        {
            return Upload::resourceUrl('company_logo', $this->id, "{$size}.png?cb=" . time());
        }

        return asset('assets/admin/img/avatar.png');
    }
}
