<?php namespace App\Models;

use DB;
use App\Helpers\Math;
use App\Models\SiteTrait;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends Base {

    use SiteTrait;

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
     * Gets the packages.
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Gets the human readable arrival date and time.
     *
     * @param  $withTime
     * @return string
     */
    public function getArrivalDate($withTime = TRUE)
    {
        $dateFormat = 'n/j/Y';
        if ($withTime)
            return date($dateFormat . ' g:i A', strtotime($this->arrived_at));
        return date($dateFormat, strtotime($this->arrived_at));
    }

    /**
     * Calculates the actual weight of the warehouse in pounds.
     *
     * @return float
     */
    public function calculateGrossWeight()
    {
        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['weight'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += $package->weight;
        }

        return $total;
    }

    /**
     * Calculates the volume weight of the warehouse in pounds.
     *
     * @return float
     */
    public function calculateVolumeWeight()
    {
        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['length', 'width', 'height'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += Math::calculateVolumeWeight($package->length, $package->width, $package->height);
        }

        return $total;
    }

    /**
     * Calculates the cubic feet.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {
        $total = 0;

        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['length', 'width', 'height'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += Math::calculateCubicFeet($package->length, $package->width, $package->height);
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
        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['length', 'width', 'height'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += Math::calculateCubicMeter($package->length, $package->width, $package->height);
        }

        return round($total, 3);
    }

    /**
     * Calculates the charge weight of the warehouse in pounds.
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
