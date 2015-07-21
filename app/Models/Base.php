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
     * Saves the model to the database and logs the transaction.
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
     * Deletes the model from the database.
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
     * Logs the database operation.
     *
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
