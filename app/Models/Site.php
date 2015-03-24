<?php namespace App\Models;

class Site extends BaseModel {
    const ONE = 1;
    protected $table = 'sites';

    public static $rules = [
        'company_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name'
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
