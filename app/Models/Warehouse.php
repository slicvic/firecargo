<?php namespace App\Models;

class Warehouse extends BaseRestrictedAccess {

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

    public function trackingNumber()
    {
        return 'WR-' . $this->id;
    }

    /**
     * Retrieves a list of untrashed packages.
     *
     * @return Package[]
     */
    public function packages()
    {
        return Package::where('warehouse_id', $this->id)
            ->where('trashed', '<>', 1)
            ->get();
    }

    /**
     * Counts untrashed packages.
     *
     * @return int
     */
    public function countPackages()
    {
        return Package::where('warehouse_id', $this->id)
            ->where('trashed', '<>', 1)
            ->count();
    }

    /**
     * Calculates the weight.
     *
     * @return float
     */
    public function calculateWeight()
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->weight;
        }

        return $total;
    }

    /**
     * Calculates the volumne.
     *
     * @return float
     */
    public function calculateVolume()
    {
        $total = 0;

        foreach ($this->packages() as $package)
        {
            $total += $package->calculateVolume();
        }

        return $total;
    }
}
