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
     * Updates a record by the id.
     *
     * @param  int $id
     * @param  array $input
     * @return bool|null
     */
    public static function updateWhereId($id, $input)
    {
        return self::where(['id' => $id])->update($input);
    }
}
