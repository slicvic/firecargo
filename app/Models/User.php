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
        'email',
        'password',
        'company_name',
        'first_name',
        'last_name',
        'dob',
        'id_number',
        'phone',
        'mobile_phone',
        'autoship_setting'
    ];

    /**
     * Gets the packages.
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Gets the roles.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'roles_users');
    }

    /**
     * Gets the address.
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * Gets the site.
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Gets the company.
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
        return $this->hasRole(Role::AGENT);
    }

    /**
     * Determines if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(Role::ADMIN);
    }

    /**
     * Determines if the user is a client.
     *
     * @return bool
     */
    public function isClient()
    {
        return $this->hasRole(Role::CLIENT);
    }

    /**
     * Determines if the user has the given role.
     *
     * @param  int  $roleId
     * @return bool
     */
    public function hasRole($roleId)
    {
        return in_array($roleId, $this->roles->lists('id'));
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
        return $this->email . ':' . $this->password . ':' . $this->created_at;
    }

    /**
     * Determines if a password recovery token is valid.
     *
     * @param  string  $token
     * @return bool
     */
    public function checkPasswordRecoveryToken($token)
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
            case 'first_name':
            case 'last_name':
                $value = ucfirst(strtolower(trim($value)));
                break;

            case 'company_name':
                $value = strtoupper(trim($value));
                break;

            case 'password':
                $value = empty($value) ? $this->password : Hash::make($value);
                break;

            case 'dob':
                if (is_string($value)) {
                    $value = date('Y-m-d', strtotime($value));
                }
                else if (is_array($value) && isset($value['year'], $value['month'], $value['day'])) {
                    $value = date('Y-m-d', strtotime($value['year'] . '/' . $value['month'] . '/' . $value['day']));
                }
                else {
                    $value = NULL;
                }
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Checks if a profile photo image file exists.
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
     * Validates the specified credentials.
     *
     * @param  string  $username
     * @param  string  $password
     * @return User|false
     */
    public static function validateCredentials($username, $password)
    {
        $user = User::where('id', $username)
            ->orWhere('email', $username)
            ->first();

        if ($user && Hash::check($password, $user->password) && $user->hasRole(Role::LOGIN))
        {
            return $user;
        }

        return FALSE;
    }

    /**
     * Retrieves a list of users for a jquery autocomplete field.
     *
     * @param  string  $term       A search query
     * @param  int     $companyId
     * @return User[]
     */
    public static function autocompleteSearch($term, $companyId)
    {
        $term = '%' . $term . '%';
        $where = '(id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR company_name LIKE ? OR email LIKE ? OR phone LIKE ? or mobile_phone LIKE ?)';
        $where .= ' AND company_id IN (?)';

        return User::whereRaw($where, [$term, $term, $term, $term, $term, $term, $term, $companyId])->get();
    }

    /**
     * Retrieves a list of users for a jquery datatable.
     *
     * @param  string   $criteria  List of criterias
     * @param  int      $offset
     * @param  int      $limit
     * @param  string   $orderBy
     * @param  string   $order
     * @return [total => X, users => User[]]
     */
    public static function datatableSearch(array $criteria = [], $offset = 0, $limit = 10, $orderBy = 'id', $order = 'DESC')
    {
        $sql = '1';
        $bindings = [];

        if ( ! empty($criteria['company_id']))
        {
            $sql .= ' AND company_id IN (' . implode(',', $criteria['company_id']) . ')';
        }

        if ( ! empty($criteria['q']))
        {
            $q = '%' . $criteria['q'] . '%';
            $sql .= ' AND (id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR company_name LIKE ? OR email LIKE ? OR phone LIKE ? or mobile_phone LIKE ?)';
            $bindings = [$q, $q, $q, $q, $q, $q, $q];
        }

        $query = User::whereRaw($sql, $bindings);
        $total = $query->count();
        $results = $query
            ->orderBy($orderBy, $order)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return ['total' => $total, 'users' => $results];
    }
}
