<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Role;
use App\Helpers\Upload;
use Html;

/**
 * UserPresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserPresenter extends BasePresenter {

    /**
     * Presents the full name.
     *
     * @return string
     */
    public function fullname()
    {
        return "{$this->model->firstname} {$this->model->lastname}";
    }

    /**
     * Presents the last login date.
     *
     * @return string
     */
    public function lastLogin()
    {
        return date('m/d/y g:i A', strtotime($this->model->last_login));
    }

    /**
     * Presents the profile photo URL.
     *
     * @param  string  $size  The possible values are: 'sm'|'md'
     * @param  string  $default
     * @return string
     */
    public function profilePhotoUrl($size = 'sm', $default = 'assets/admin/img/avatar.png')
    {
        if ( ! Upload::resourceExists('user.profile_photo', "{$size}.png", $this->model->id))
        {
            return asset($default);
        }

        return Upload::resourceUrl('user.profile_photo', "{$size}.png", $this->model->id);
    }

    /**
     * Presents the active status.
     *
     * @return string
     */
    public function active()
    {
        return $this->model->active
            ? '<span class="badge badge-primary">Yes</span>'
            : '<span class="badge badge-danger">No</span>';
    }

    /**
     * Presents the role as a bootstrap badge.
     *
     * @return html
     */
    public function role()
    {
        switch ($this->model->role_id)
        {
            case Role::SUPER_ADMIN:
                $cssClass = 'danger';
                break;
            case Role::SUPER_AGENT:
                $cssClass = 'warning';
                break;
            default:
                $cssClass = 'primary';
                break;
        }

        return sprintf('<div class="label label-%s">%s</div>', $cssClass, $this->model->role->name);
    }
}
