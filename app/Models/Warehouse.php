<?php namespace App\Models;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends BaseSiteSpecific {

    protected $table = 'warehouses';

    public static $rules = [
        'site_id' => 'required',
        'shipper_user_id' => 'required',
        'consignee_user_id' => 'required',
        'courier_id' => 'required',
        'arrived_at' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'shipper_user_id',
        'consignee_user_id',
        'courier_id',
        'arrived_at',
        'description'
    ];

    public static $sortColumns = [
        'id' => 'id',
        'date' => 'arrived_at'
    ];

    /**
     * Gets the shipper.
     */
    public function shipper()
    {
        return $this->belongsTo('App\Models\User', 'shipper_user_id');
    }

    /**
     * Gets the consignee.
     */
    public function consignee()
    {
        return $this->belongsTo('App\Models\User', 'consignee_user_id');
    }

    /**
     * Gets the courier.
     */
    public function courier()
    {
        return $this->belongsTo('App\Models\Courier', 'courier_id');
    }

    /**
     * Gets the company.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Gets the site.
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Gets the friendly arrival datetime.
     *
     * @param  $withTime
     * @return string
     */
    public function prettyArrivedAt($withTime = TRUE)
    {
        $dateFormat = 'n/j/Y';
        if ($withTime)
            return date($dateFormat . ' g:i A', strtotime($this->arrived_at));
        return date($dateFormat, strtotime($this->arrived_at));
    }

    /**
     * Gets the friendly ID.
     *
     * @return string
     */
    public function prettyId()
    {
        return $this->id;
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
     * Calculates the actual weight of the warehouse in pounds.
     *
     * @param  int $precision
     * @return float
     */
    public function calculateGrossWeight($precision = 2)
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->weight;
        }

        return round($total, $precision);
    }

    /**
     * Calculates the volume weight of the warehouse in pounds.
     *
     * @param  int $precision
     * @return float
     */
    public function calculateVolumeWeight($precision = 2)
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->calculateVolumeWeight(5);
        }

        return round($total, $precision);
    }

    /**
     * Calculates the cubic feet.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->calculateCubicFeet();
        }

        return round($total, 3);
    }

    /**
     * Calculates the cubic meter.
     *
     * @return float
     */
    public function calculateCubicMeter()
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->calculateCubicMeter();
        }

        return round($total, 3);
    }

    /**
     * Calculates the charge weight of the warehouse in pounds.
     *
     * @param  int $precision
     * @return float
     */
    public function calculateChargeWeight($precision = 2)
    {
        $grossWeight = $this->calculateGrossWeight($precision);
        $volumeWeight = $this->calculateVolumeWeight($precision);
        return ($grossWeight > $volumeWeight) ? $grossWeight : $volumeWeight;
    }
}
