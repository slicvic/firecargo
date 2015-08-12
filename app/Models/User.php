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
     * Register model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        User::observe(new UserObserver);
    }

    /**
     * Override parent method to sanitize attributes.
     *
     * {@inheritdoc}
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
     * Get the user role.
     *
     * @return Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Get the user customer account.
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
     * Determine if the user is an agent.
     *
     * @return bool
     */
    public function isAgent()
    {
        return (in_array((int) $this->role_id, [Role::AGENT, Role::SUPER_AGENT]));
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return (in_array((int) $this->role_id, [Role::ADMIN, Role::SUPER_ADMIN]));
    }

    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return ((int) $this->role_id === Role::CUSTOMER);
    }

    /**
     * Generate a password recovery token.
     *
     * @return string
     */
    public function makePasswordRecoveryToken()
    {
        return urlencode(base64_encode(Hash::make($this->makePlainPasswordRecoveryToken())));
    }

    /**
     * Generate a plain-text password recovery token.
     *
     * @return string
     */
    private function makePlainPasswordRecoveryToken()
    {
        return $this->email . '#####' . $this->password . '#####' . $this->created_at;
    }

    /**
     * Determine if a password recovery token is valid.
     *
     * @param  string  $token
     * @return bool
     */
    public function verifyPasswordRecoveryToken($token)
    {
        return Hash::check($this->makePlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Generate an account activation code for registration.
     *
     * @return string
     */
    public static function makeActivationCode()
    {
        return md5(md5(time()));
    }

    /**
     * Validate the given login credentials.
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
}
