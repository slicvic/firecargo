<?php namespace App\Models;

use Hash;
use DB;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use App\Presenters\PresentableTrait;
use App\Models\CompanyTrait;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends Base implements AuthenticatableInterface {

    use AuthenticableTrait, CompanyTrait, PresentableTrait;

    protected $presenter = 'App\Presenters\User';

    protected $table = 'users';

    protected $fillable = [
        'company_id',
        'role_id',
        'is_active',
        'email',
        'password',
        'company_name',
        'full_name',
        'dob',
        'id_number',
        'phone',
        'mobile_phone',
        'autoship_setting'
    ];

    /**
     * Gets the packages relation.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Gets the role relation.
     *
     * @return Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Gets the address relation.
     *
     * @return Address
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * Gets the site relation.
     *
     * @return Site
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Gets the company relation.
     *
     * @return Company
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Determines if the user is an agent.
     *
     * @return bool
     */
    public function isAgent()
    {
        return ($this->role_id == Role::AGENT);
    }

    /**
     * Determines if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->role_id == Role::ADMIN);
    }

    /**
     * Determines if the user is a client.
     *
     * @return bool
     */
    public function isClient()
    {
        return ($this->role_id == Role::CLIENT);
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
     * Determines if a password recovery token is valid.
     *
     * @param  string  $token
     * @return bool
     */
    public function verifyPasswordRecoveryToken($token)
    {
        return Hash::check($this->makePlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Overrides parent method to sanitize certain attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key)
        {
            case 'full_name':
                $value = ucwords(strtolower(trim($value)));
                break;

            case 'company_name':
                $value = strtoupper(trim($value));
                break;

            case 'password':
                $value = empty($value) ? $this->password : Hash::make($value);
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Checks if a profile photo has been uploaded.
     *
     * @param  string  $size  sm|md
     * @return bool
     */
    public function hasProfilePhoto($size)
    {
        $path = 'uploads/users/' . $this->id . '/images/profile/' . $size . '.png';

        return file_exists(public_path() . '/' . $path);
    }

    /**
     * Gets the profile photo URL.
     *
     * @param  string  $size  sm|md
     * @return string
     */
    public function getProfilePhotoURL($size = 'sm')
    {
        $path = 'uploads/users/' . $this->id . '/images/profile/' . $size . '.png';

        if (file_exists(public_path() . '/' . $path))
        {
            return asset($path) . '?cb=' . time();
        }

        return asset('assets/admin/img/avatar.png');
    }

    /**
     * Validates the given credentials.
     *
     * @param  string  $username
     * @param  string  $password
     * @return User|false
     */
    public static function validateCredentials($username, $password)
    {
        $user = User::where(['email' => $username, 'is_active' => TRUE])
            ->first();

        if ($user && Hash::check($password, $user->password))
        {
            return $user;
        }

        return FALSE;
    }

    /**
     * Finds all the users with the given criteria.
     *
     * @param  string   $criteria  List of criterias
     * @param  int      $offset
     * @param  int      $limit
     * @param  string   $orderBy
     * @param  string   $order
     * @return [total => X, users => User[]] or User[]
     */
    public static function search(array $criteria = [], $offset = 0, $limit = 10, $orderBy = 'id', $order = 'DESC')
    {
        $sql = '1';
        $bindings = [];

        // Filter by company id
        if (isset($criteria['company_id']) && is_array($criteria['company_id']))
        {
            $sql .= ' AND company_id IN (' . implode(',', $criteria['company_id']) . ')';
        }

        // Filter by role id
        if (isset($criteria['role_id']) && is_array($criteria['role_id']))
        {
            $sql .= ' AND role_id IN (' . implode(',', $criteria['role_id']) . ')';
        }

        // Full text search
        if ( ! empty($criteria['q']))
        {
            $q = '%' . $criteria['q'] . '%';
            $sql .= ' AND (id LIKE ? OR full_name LIKE ? OR company_name LIKE ? OR email LIKE ? OR phone LIKE ? or mobile_phone LIKE ?)';
            $bindings = [$q, $q, $q, $q, $q, $q];
        }

        // Run query
        $result = [];

        $query = User::whereRaw($sql, $bindings);

        if (isset($criteria['count']))
        {
            $result['total'] = $query->count();
        }

        $result['users'] = $query
            ->orderBy($orderBy, $order)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return isset($criteria['count']) ? $result : $result['users'];
    }
}
