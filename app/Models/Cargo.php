<?php namespace App\Models;

use DB;
use App\Models\CompanySpecificTrait;
use App\Presenters\PresentableTrait;

/**
 * Cargo
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Cargo extends Base {

    use CompanySpecificTrait, PresentableTrait;

    protected $table = 'cargos';

    protected $presenter = 'App\Presenters\Cargo';

    public static $rules = [
        'company_id' => 'required',
        'carrier_id' => 'required',
        'receipt_number' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'carrier_id',
        'receipt_number',
        'departed_at'
    ];

    /**
     * Gets the packages.
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Overrides parent method to sanitize certain attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key) {
            case 'departed_at':
                $value = date('Y-m-d H:i:s', strtotime($value));
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Finds all cargos with the given criteria.
     *
     * @param  array|null $criteria
     * @param  string     $orderBy
     * @param  string     $order
     * @param  int        $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        $sortColumns = [
            'id' => 'id',
        ];
        $orderBy = array_key_exists($orderBy, $sortColumns) ? $sortColumns[$orderBy] : 'id';
        $order = ($order == 'asc') ? 'asc' : 'desc';

        $cargos = Cargo::whereRaw('1')
            ->orderBy('cargos.' . $orderBy, $order);

        if ( ! empty($criteria['company_id'])) {
            $cargos = $cargos->where('cargos.company_id', '=', $criteria['company_id']);
        }

        if ( ! empty($criteria['q'])) {
            $q = '%' . $criteria['q'] . '%';

            $cargos = $cargos
                ->select('cargos.*')
                ->leftJoin('packages AS package', 'cargos.id', '=', 'package.cargo_id')
                ->whereRaw('(
                    package.id LIKE ?
                    OR cargos.id LIKE ?
                    OR cargos.receipt_number LIKE ?
                    )', [$q, $q, $q]
                );
        }

        $cargos = $cargos->paginate($perPage);
        return $cargos;
    }
}
