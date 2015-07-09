<?php namespace App\Models;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends Base {

    protected $table = 'carriers';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
        'company_id'
    ];

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
        $where .= ' AND company_id IN (0, ?)';
        return Carrier::whereRaw($where, [$keyword, $keyword, $companyId])->get();
    }
}
