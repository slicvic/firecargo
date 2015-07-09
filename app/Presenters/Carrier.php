<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends BasePresenter {

    /**
     * Presents the company.
     *
     * @return string
     */
    public function company()
    {
        return ($this->model->company_id) ? $this->model->company->name : 'Global';
    }
}
