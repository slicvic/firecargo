<?php namespace App\Models;

/**
 * LogUserAction
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class LogUserAction extends Base {

    const CREATE = 'create';
    const READ   = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    protected $table = 'log_user_actions';
}
