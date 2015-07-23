<?php namespace App\Models;

use Hash;
use DB;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use App\Presenters\PresentableTrait;
use App\Observers\UserObserver;
use App\Helpers\Upload;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends Base implements AuthenticatableInterface {

    use AuthenticableTrait, CompanyTrait, PresentableTrait;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\User';

    /**
     * @var array
     */
    protected $fillable = [
        'company_id',
        'role_id',
        'active',
        'email',
        'password',
        'firstname',
        'lastname',
        'has_photo'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        User::observe(new UserObserver);
    }

    /**
     * Gets the role of the user.
     *
     * @return Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Gets the account associated with the user.
     *
     * NOTE: ONLY "CLIENT" USERS HAVE AN ACCOUNT.
     *
     * @return Account
     */
    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }

    /**
     * Checks if the user is an agent.
     *
     * @return bool
     */
    public function isAgent()
    {
        return ((int) $this->role_id === Role::SUPER_AGENT);
    }

    /**
     * Checks if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return ((int) $this->role_id === Role::SUPER_ADMIN);
    }

    /**
     * Checks if the user is a client.
     *
     * @return bool
     */
    public function isClient()
    {
        return ((int) $this->role_id === Role::CLIENT);
    }

    /**
     * Generates a password recovery token.
     *
     * @return string
     */
    public function makePasswordRecoveryToken()
    {
        return urlencode(base64_encode(Hash::make($this->makePlainPasswordRecoveryToken())));
    }

    /**
     * Generates a plain-text password recovery token.
     *
     * @return string
     */
    private function makePlainPasswordRecoveryToken()
    {
        return $this->email . '$$$$$' . $this->password . '$$$$$' . $this->created_at;
    }

    /**
     * Checks if a password recovery token is valid.
     *
     * @param  string  $token
     * @return bool
     */
    public function verifyPasswordRecoveryToken($token)
    {
        return Hash::check($this->makePlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Overrides parent method to sanitize attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key)
        {
            case 'firstname':
            case 'lastname':
                $value = ucwords(strtolower(trim($value)));
                break;

            case 'password':
                $value = empty($value) ? $this->password : Hash::make($value);
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Gets the profile photo URL.
     *
     * @param  string  $size  sm|md
     * @return string
     */
    public function profilePhotoUrl($size = 'sm')
    {
        if ($this->has_photo)
        {
            return Upload::resourceUrl('profile_photo', $this->id, "{$size}.png?cb=" . time());
        }

        return asset('assets/admin/img/avatar.png');
    }

    /**
     * Validates the given credentials.
     *
     * @param  string  $email
     * @param  string  $password
     * @return User|FALSE
     */
    public static function validateCredentials($email, $password)
    {
        $user = User::where(['email' => $email, 'active' => TRUE])->first();

        if ($user && Hash::check($password, $user->password))
        {
            return $user;
        }

        return FALSE;
    }

    /**
     * Finds all users matching the given criteria.
     *
     * @param  string   $criteria  List of criterias
     * @return Builder
     */
    public static function search(array $criteria = [])
    {
        $query = User::query();

        if (isset($criteria['company_id']))
        {
            $query = $query->where('company_id', '=', $criteria['company_id']);
        }

        if (isset($criteria['role_id']))
        {
            $query = $query->whereIn('role_id', $criteria['role_id']);
        }

        if ( ! empty($criteria['search']))
        {
            $q = '%' . $criteria['q'] . '%';

            $query->whereRaw(
                '(id LIKE ? OR name LIKE ? OR company_name LIKE ? OR email LIKE ? OR phone LIKE ? or mobile_phone LIKE ?)',
                [$q, $q, $q, $q, $q, $q]
            );
        }

        return $query;
    }
}
