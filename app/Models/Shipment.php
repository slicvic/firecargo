<?php namespace App\Models;

use DB;

use App\Presenters\PresentableTrait;

/**
 * Shipment
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Shipment extends Base {

    use CompanyTrait, PresentableTrait;

    /**
     * @var string
     */
    protected $table = 'shipments';

    /**
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\Shipment';

    /**
     * @var array
     */
    protected $fillable = [
        'carrier_id',
        'reference_number',
        'departed_at'
    ];

    /**
     * Gets the shipment packages.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Gets the shipment carrier.
     *
     * @return Carrier
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier');
    }

    /**
     * Overrides parent method to sanitize attributes.
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
     * Attaches the given packages to the shipment.
     *
     * WARNING: After this operation is complete only the packages in the array
     * will remain in the shipment.
     *
     * @param  array  $packageIds
     * @param  bool   $detaching
     * @return void
     * */
    public function syncPackages(array $packageIds, $detaching = TRUE)
    {
        // First lets detach the packages not in $packageIds
        if ($detaching)
        {
            Package::whereNotIn('id', $packageIds)
                ->where('shipment_id', '=', $this->id)
                ->update(['shipment_id' => NULL]);
        }

        // Next, we'll attach the given packages
        if (count($packageIds))
        {
            Package::whereIn('id', $packageIds)->update(['shipment_id' => $this->id]);
        }
    }

    /**
     * Calculates the total cost of the shipment.
     *
     * @return float
     */
    public function calculateTotalValue()
    {
        return DB::table('packages')->where('shipment_id', '=', $this->id)
            ->sum('invoice_amount');
    }

    /**
     * Finds all shipments with the given criteria.
     *
     * @param  array|null  $criteria
     * @param  string      $sort
     * @param  string      $order
     * @param  int         $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $sort = 'id', $order = 'desc', $perPage = 15)
    {
        $sortColumns = [
            'id',
            'departed_at',
            'created_at',
            'updated_at'
        ];

        // Build query
        $sort = in_array($sort, $sortColumns) ? $sort : 'id';
        $order = ($order === 'asc') ? 'asc' : 'desc';

        $shipments = Shipment::query()->orderBy('shipments.' . $sort, $order);

        if (isset($criteria['company_id']))
        {
            $shipments = $shipments->where('shipments.company_id', '=', $criteria['company_id']);
        }

        if (isset($criteria['search']) && strlen($criteria['search']) > 2)
        {
            $search = '%' . $criteria['search'] . '%';

            $shipments = $shipments
                ->select('shipments.*')
                ->leftJoin('packages', 'shipments.id', '=', 'packages.shipment_id')
                ->leftJoin('carriers', 'shipments.carrier_id', '=', 'carriers.id')
                ->groupBy('shipments.id')
                ->whereRaw('(
                    packages.id LIKE ?
                    OR packages.tracking_number LIKE ?
                    OR carriers.name LIKE ?
                    OR shipments.id LIKE ?
                    OR shipments.reference_number LIKE ?
                    )', [
                    $search,
                    $search,
                    $search,
                    $search,
                    $search
                ]);
        }

        $shipments = $shipments->paginate($perPage);

        return $shipments;
    }
}
