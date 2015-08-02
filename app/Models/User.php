<?php namespace App\Models;

use Hash;
use DB;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use App\Presenters\PresentableTrait;
use App\Observers\UserObserver;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends Base implements AuthenticatableInterface {

    use AuthenticableTrait, CompanyTrait, PresentableTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The presenter path.
     *
     * @var string
     */
    protected $presenter = 'App\Presenters\UserPresenter';

    /**
     * A list of fillable fields.
     *
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
     * Gets the user role.
     *
     * @return Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Gets the user customer account.
     *
     * NOTE: ONLY "CUSTOMER" USERS HAVE AN ACCOUNT.
     *
     * @return Account
     */
    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }

    /**
     * Checks if the user is an agent or not.
     *
     * @return bool
     */
    public function isAgent()
    {
        return (in_array((int) $this->role_id, [Role::AGENT, Role::SUPER_AGENT]));
    }

    /**
     * Checks if the user is an administrator or not.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return (in_array((int) $this->role_id, [Role::ADMIN, Role::SUPER_ADMIN]));
    }

    /**
     * Checks if the user is a customer or not.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return ((int) $this->role_id === Role::CUSTOMER);
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
     * Checks if a password recovery token is valid or not.
     *
     * @param  string  $token
     * @return bool
     */
    public function verifyPasswordRecoveryToken($token)
    {
        return Hash::check($this->makePlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Validates the given login credentials.
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
            $query->where('company_id', $criteria['company_id']);
        }

        if (isset($criteria['role_id']))
        {
            $query->whereIn('role_id', $criteria['role_id']);
        }

        if ( ! empty($criteria['search']))
        {
            $searchTerm = '%' . $criteria['search'] . '%';

            $query->whereRaw('(
                id LIKE ?
                OR name LIKE ?
                OR company_name LIKE ?
                OR email LIKE ?
                OR phone LIKE ?
                OR mobile_phone LIKE ?
                )', [
                $searchTerm,
                $searchTerm,
                $searchTerm,
                $searchTerm,
                $searchTerm,
                $searchTerm
                ]);
        }

        return $query;
    }
}
