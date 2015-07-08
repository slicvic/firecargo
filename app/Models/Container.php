<?php namespace App\Models;

use DB;
use App\Models\CompanySpecificTrait;
use App\Presenters\PresentableTrait;

/**
 * Container
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Container extends Base {

    use CompanySpecificTrait, PresentableTrait;

    protected $table = 'containers';

    protected $presenter = 'App\Presenters\Container';

    public static $rules = [
        'company_id' => 'required',
        'receipt_number' => 'required|unique:containers,receipt_number'
    ];

    protected $fillable = [
        'company_id',
        'type_id',
        'receipt_number',
        'departed_at'
    ];

    /**
     * Gets the warehouses.
     */
    public function warehouses()
    {
        return $this->hasMany('App\Models\Warehouse');
    }

    /**
     * Gets the warehouses.
     */
    public function type()
    {
        return $this->belongsTo('App\Models\ContainerType');
    }

    /**
     * Obtains the warehouse ids.
     *
     * @return array
     */
    public function warehouseIds()
    {
        return $this->warehouses()->lists('id');
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
     * Finds all containers with the given criteria.
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

        $containers = Container::whereRaw('1')
            ->orderBy('containers.' . $orderBy, $order);

        if ( ! empty($criteria['company_id'])) {
            $containers = $containers->where('containers.company_id', '=', $criteria['company_id']);
        }

        if ( ! empty($criteria['q'])) {
            $q = '%' . $criteria['q'] . '%';

            $containers = $containers
                ->select('containers.*')
                ->leftJoin('warehouses AS warehouse', 'containers.id', '=', 'warehouse.container_id')
                ->whereRaw('(
                    warehouse.id LIKE ?
                    OR containers.id LIKE ?
                    OR containers.receipt_number LIKE ?
                    )', [$q, $q, $q]
                );
        }

        $containers = $containers->paginate($perPage);
        return $containers;
    }
}
