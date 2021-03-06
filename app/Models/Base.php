<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * Base
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class Base extends Model {

    /**
     * Save the model to the database and log the transaction.
     *
     * @todo  turn on log write
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $queryType = $this->exists ? LogUserAction::UPDATE : LogUserAction::CREATE;

        $result = parent::save($options);

        if ($result && Auth::check() && ! ($this instanceof LogUserAction))
        {
            $this->logQuery($queryType);
        }

        return $result;
    }

    /**
     * Delete the model from the database and log the transaction.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $result = parent::delete();

        if ($result)
        {
            $this->logQuery(LogUserAction::DELETE);
        }

        return $result;
    }

    /**
     * Log a database transaction.
     *
     * @param  string  $action  create|read|update|delete
     * @return void
     */
    private function logQuery($action)
    {
        $log = new LogUserAction;
        $log->user_id = Auth::user()->id;
        $log->action = $action;
        $log->record_id = $this->id;
        $log->table_name = $this->table;
        $log->save();
    }
}
