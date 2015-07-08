<?php namespace App\Models;

use DB;
use App\Models\CompanySpecificTrait;
use App\Presenters\PresentableTrait;

/**
 * ContainerReceiptType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ContainerReceiptType extends Base {

    protected $table = 'container_receipt_types';
}
