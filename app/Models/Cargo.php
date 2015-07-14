<?php namespace App\Models;

use DB;

use App\Models\CompanyTrait;
use App\Presenters\PresentableTrait;

/**
 * Cargo
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Cargo extends Base {

    use CompanyTrait, PresentableTrait;

    protected $table = 'cargos';

    protected $presenter = 'App\Presenters\Cargo';

    protected $fillable = [
        'carrier_id',
        'reference_number',
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
     * Gets the carrier.
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier');
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
            case 'reference_number':
                $value = strtoupper($value);
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Attaches the given packages to the cargo.
     *
     * WARNING: After this operation is complete only the packages in the array
     * will remain in the cargo.
     *
     * @param  array  $packageIds
     * @param  bool   $detaching
     * @return void
     * */
    public function syncPackages(array $packageIds, $detaching = TRUE)
    {
        // First lets detach those packages not in $packageIds
        if ($detaching)
        {
            Package::whereNotIn('id', $packageIds)
                ->where('cargo_id', '=', $this->id)
                ->update(['cargo_id' => NULL]);
        }

        // Next, we will attach the given packages
        if (count($packageIds))
        {
            Package::whereIn('id', $packageIds)->update(['cargo_id' => $this->id]);
        }
    }

    /**
     * Finds all cargos with the given criteria.
     *
     * @param  array|null  $criteria
     * @param  string      $orderBy
     * @param  string      $order
     * @param  int         $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        $sortColumns = [
            'id' => 'id',
            'departed' => 'departed_at',
            'created' => 'created_at',
            'updated' => 'updated_at'
        ];

        $orderBy = array_key_exists($orderBy, $sortColumns) ? $sortColumns[$orderBy] : 'id';
        $order = ($order == 'asc') ? 'asc' : 'desc';

        $cargos = Cargo::whereRaw('1')
            ->orderBy('cargos.' . $orderBy, $order);

        if ( ! empty($criteria['company_id']))
        {
            $cargos = $cargos->where('cargos.company_id', '=', $criteria['company_id']);
        }

        if ( ! empty($criteria['q']))
        {
            $q = '%' . $criteria['q'] . '%';

            $cargos = $cargos
                ->select('cargos.*')
                ->leftJoin('packages', 'cargos.id', '=', 'packages.cargo_id')
                ->leftJoin('carriers', 'cargos.carrier_id', '=', 'carriers.id')
                ->whereRaw('(
                    packages.id LIKE ?
                    OR packages.tracking_number LIKE ?
                    OR carriers.name LIKE ?
                    OR cargos.id LIKE ?
                    OR cargos.reference_number LIKE ?
                    )', [$q, $q, $q, $q, $q]
                );
        }

        $cargos = $cargos->paginate($perPage);

        return $cargos;
    }
}
