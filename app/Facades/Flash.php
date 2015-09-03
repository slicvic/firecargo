<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Flash
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Flash extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flash';
    }
}
