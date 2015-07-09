<?php namespace App\Models;

use App\Presenters\PresentableTrait;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends Base {

    use PresentableTrait;

    protected $presenter = 'App\Presenters\Carrier';

    protected $table = 'carriers';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'company_id'
    ];

    /**
     * Gets the company.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Retrieves a list of carriers for a jquery autocomplete field.
     *
     * @param  string $keyword     A search query
     * @param  int    $companyId
     * @return User[]
     */
    public static function findForAutocomplete($keyword, $companyId)
    {
        $keyword = '%' . $keyword . '%';
        $where = '(id LIKE ? OR name LIKE ?)';
        $where .= ' AND company_id IN (NULL, ?)';
        return Carrier::whereRaw($where, [$keyword, $keyword, $companyId])->get();
    }
}
