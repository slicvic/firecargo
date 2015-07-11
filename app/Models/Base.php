<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * Base
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class Base extends Model {

    /**
     * Overrides parent method to assign company_id.
     *
     * @see parent::save()
     */
    public function save(array $options = array())
    {
        if ($this->isFillable('company_id') && Auth::check() && ! Auth::user()->isAdmin()) {
            $this->company_id = Auth::user()->company_id;
        }

        return parent::save($options);
    }
}
