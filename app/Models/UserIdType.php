<?php namespace App\Models;

class UserIdType extends BaseModel {
    const CC = 1;
    const NIT = 2;
    const RUT = 3;

    protected $table = 'user_id_types';
}
