<?php namespace App\Models;

/**
 * LogUserAction
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class LogUserAction extends Base {

    /**
     * @var string
     */
    const CREATE = 'create';
    const READ   = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * @var string
     */
    protected $table = 'log_user_actions';
}
