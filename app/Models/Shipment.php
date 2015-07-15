<?php namespace App\Models;

use DB;

use App\Models\CompanyTrait;
use App\Presenters\PresentableTrait;

/**
 * Shipment
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Shipment extends Base {

    use CompanyTrait, PresentableTrait;

    protected $table = 'shipments';

    protected $presenter = 'App\Presenters\Shipment';

    protected $fillable = [
        'carrier_id',
        'reference_number',
        'departed_at'
    ];

    /**
     * Gets the packages relation.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Gets the carrier relation.
     *
     * @return Carrier
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

        // Next, we will attach the given packages
        if (count($packageIds))
        {
            Package::whereIn('id', $packageIds)->update(['shipment_id' => $this->id]);
        }
    }

    /**
     * Calculates the total cost of the warehouse.
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
     * @param  string      $orderBy
     * @param  string      $order
     * @param  int         $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        // Define valid sort columns
        $sortColumns = [
            'id' => 'id',
            'departed' => 'departed_at',
            'created' => 'created_at',
            'updated' => 'updated_at'
        ];

        // Determine sort order
        $orderBy = array_key_exists($orderBy, $sortColumns) ? $sortColumns[$orderBy] : 'id';
        $order = ($order == 'asc') ? 'asc' : 'desc';

        $shipments = Shipment::whereRaw('1')
            ->orderBy('shipments.' . $orderBy, $order);

        // Filter by company id
        if ( ! empty($criteria['company_id']))
        {
            $shipments = $shipments->where('shipments.company_id', '=', $criteria['company_id']);
        }

        // Full text search
        if ( ! empty($criteria['q']))
        {
            $q = '%' . $criteria['q'] . '%';

            $shipments = $shipments
                ->select('shipments.*')
                ->leftJoin('packages', 'shipments.id', '=', 'packages.shipment_id')
                ->leftJoin('carriers', 'shipments.carrier_id', '=', 'carriers.id')
                ->whereRaw('(
                    packages.id LIKE ?
                    OR packages.tracking_number LIKE ?
                    OR carriers.name LIKE ?
                    OR shipments.id LIKE ?
                    OR shipments.reference_number LIKE ?
                    )', [$q, $q, $q, $q, $q]
                );
        }

        $shipments = $shipments->paginate($perPage);

        return $shipments;
    }
}
