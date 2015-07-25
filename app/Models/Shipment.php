<?php namespace App\Models;

use DB;

use App\Presenters\PresentableTrait;
use App\Observers\ShipmentObserver;

/**
 * Shipment
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Shipment extends Base {

    use CompanyTrait, PresentableTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'shipments';

    /**
     * The presenter path.
     *
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\Shipment';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'carrier_id',
        'reference_number',
        'departed_at'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        Shipment::observe(new ShipmentObserver);
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
     * Gets the packages.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Gets the carrier.
     *
     * @return Carrier
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier');
    }

    /**
     * Gets the creator.
     *
     * @return Carrier
     */
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_user_id');
    }

    /**
     * Gets the last updater.
     *
     * @return Carrier
     */
    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updater_user_id');
    }

    /**
     * Attaches the given packages to the shipment.
     *
     * NOTICE: AFTER THIS OPERATION IS COMPLETE ONLY THE GIVEN PACKAGES
     * WILL REMAIN IN THE SHIPMENT.
     *
     * @param  array  $packageIds
     * @return void
     */
    public function syncPackages(array $packageIds)
    {
        // First lets detach the packages not in $packageIds
        Package::whereNotIn('id', $packageIds)
            ->where('shipment_id', '=', $this->id)
            ->update(['shipment_id' => NULL]);

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
        // Verify sort and order
        $validSortColumns = [
            'id',
            'departed_at',
            'created_at',
            'updated_at'
        ];

        $sort = in_array($sort, $validSortColumns) ? $sort : 'id';

        $order = ($order === 'asc') ? 'asc' : 'desc';

        // Build query
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

        $shipments = $shipments
            ->with('carrier', 'creator', 'updater', 'company')
            ->paginate($perPage);

        return $shipments;
    }
}
