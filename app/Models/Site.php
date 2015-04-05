<?php namespace App\Models;

class Site extends Base {

    protected $table = 'sites';

    public static $rules = [
        'company_id' => 'required',
        'name' => 'required',
        'display_name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name',
        'display_name'
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
