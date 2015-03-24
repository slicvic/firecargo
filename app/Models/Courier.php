<?php namespace App\Models;

use Auth;

class Courier extends BaseModel {

    protected $table = 'couriers';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name'
    ];

    public static function all($columns = ['*'])
    {
        return Courier::where('site_id', '=', Auth::user()->site_id)
            ->get($columns);
    }
}
