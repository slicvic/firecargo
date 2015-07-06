<?php namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;

/**
 * Base
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class Base {

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
