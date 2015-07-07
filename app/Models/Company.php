<?php namespace App\Models;

use App\Presenters\PresentableTrait;
use DB;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends Base {

    use PresentableTrait;

    protected $presenter = 'App\Presenters\Company';

    protected $table = 'companies';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'address_id',
    ];

    /**
     * Gets the address.
     */
    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    /**
     * Checks if a logo image file exists.
     *
     * @param  string $size sm|md|lg
     * @return bool
     */
    public function hasLogo($size)
    {
        $path = 'uploads/companies/' . $this->id . '/images/logo/' . $size . '.png';
        return file_exists(public_path() . '/' . $path);
    }
}
