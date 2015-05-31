<?php namespace App\Models;

class Warehouse extends BaseSiteSpecific {

    protected $table = 'warehouses';

    public static $rules = [
        'site_id' => 'required',
        'shipper_user_id' => 'required',
        'consignee_user_id' => 'required',
        'delivered_by_courier_id' => 'required',
        'arrived_at' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'shipper_user_id',
        'consignee_user_id',
        'delivered_by_courier_id',
        'arrived_at'
    ];

    public function shipper()
    {
        return $this->belongsTo('App\Models\User', 'shipper_user_id');
    }

    public function consignee()
    {
        return $this->belongsTo('App\Models\User', 'consignee_user_id');
    }

    public function deliveredBy()
    {
        return $this->belongsTo('App\Models\Courier', 'delivered_by_courier_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Gets a friendly arrival datetime.
     *
     * @return string
     */
    public function prettyArrivedAt()
    {
        return date('D, M j, Y h:i A', strtotime($this->arrived_at));
    }

    /**
     * Gets a friendly tracking ID.
     *
     * @return string
     */
    public function prettyId()
    {
        return 'WR-' . $this->id;
    }

    /**
     * Retrieves a list of un-deleted packages.
     *
     * @return Package[]
     */
    public function packages()
    {
        return Package::where('warehouse_id', $this->id)
            ->where('deleted', '<>', 1)
            ->get();
    }

    /**
     * Counts un-deleted packages.
     *
     * @return int
     */
    public function countPackages()
    {
        return Package::where('warehouse_id', $this->id)
            ->where('deleted', '<>', 1)
            ->count();
    }

    /**
     * Calculates the weight of the warehouse.
     *
     * @return float
     */
    public function calculateGrossWeight()
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->weight;
        }

        return round($total, 2);
    }

    /**
     * Calculates the volume of the warehouse.
     *
     * @return float
     */
    public function calculateVolumeWeight()
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->calculateVolumeWeight();
        }

        return round($total, 2);
    }


    /**
     * Calculates the charge weight of the warehouse.
     *
     * @return float
     */
    public function calculateChargeWeight()
    {
        $grossWeight = $this->calculateGrossWeight();
        $volumeWeight = $this->calculateVolumeWeight();
        return ($grossWeight > $volumeWeight) ? $grossWeight : $volumeWeight;
    }
}
