<?php namespace App\Models;

use Hash;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use App\Presenters\PresentableTrait;
use App\Models\SiteTrait;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends Base implements AuthenticatableInterface {

    use AuthenticableTrait, SiteTrait, PresentableTrait;

    protected $presenter = 'App\Presenters\User';

    protected $table = 'users';

    protected $fillable = [
        'site_id',
        'email',
        'password',
        'business_name',
        'first_name',
        'last_name',
        'dob',
        'id_number',
        'phone',
        'mobile_phone',
        'fax',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country_id',
        'autoship_packages'
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
     * Gets the country.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * Gets the site.
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
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
     * @param  string $token
     * @return bool
     */
    public function checkPasswordRecoveryToken($token)
    {
        return Hash::check($this->makePlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Assigns the specified roles to the user.
     *
     * @param  array  $roleIds
     * @return void
     */
    public function attachRoles(array $roleIds = [])
    {
        return $this->roles()->sync($roleIds);
    }

    /**
     * Determines if the user has the given role.
     *
     * @param  int  $roleId
     * @return bool
     */
    public function hasRole($roleId)
    {
        return in_array($roleId, array_fetch($this->roles->toArray(), 'id'));
    }

    /**
     * Overrides parent method to sanitize certain attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key) {
            case 'first_name':
            case 'last_name':
            case 'city':
            case 'state':
                $value = ucwords(strtolower(trim($value)));
                break;

            case 'address1':
            case 'address2':
                $value = strtoupper(trim($value));
                break;

            case 'password':
                $value = empty($value) ? $this->password : Hash::make($value);
                break;

            case 'dob':
                if (is_string($value))
                    $value = date('Y-m-d', strtotime($value));
                else if (is_array($value))
                    $value = date('Y-m-d', strtotime($value['year'] . '/' . $value['month'] . '/' . $value['day']));
                else
                    $value = NULL;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Checks if a profile photo image file exists.
     *
     * @param  string $size sm|md
     * @return bool
     */
    public function hasProfilePhoto($size)
    {
        $path = 'uploads/users/' . $this->id . '/images/profile/' . $size . '.png';
        return file_exists(public_path() . '/' . $path);
    }

    /**
     * Validates the specified credentials.
     *
     * @param  string $username
     * @param  string $password
     * @return User|FALSE
     */
    public static function validateCredentials($username, $password)
    {
        $user = User::where('id', $username)
            ->orWhere('email', $username)
            ->first();

        if ($user && Hash::check($password, $user->password) && $user->hasRole(Role::LOGIN))
            return $user;

        return FALSE;
    }

    /**
     * Retrieves a list of users for a jQuery Autocomplete input field.
     *
     * @param  string $searchTerm  A search query
     * @param  array  $siteIds     List of site ids
     * @return User[]
     */
    public static function getUsersForAutocomplete($searchTerm, array $siteIds = NULL)
    {
        $searchTerm = '%' . $searchTerm . '%';
        $where = '(id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR business_name LIKE ? OR email LIKE ? OR phone LIKE ? or mobile_phone LIKE ?)';
        $where .= count($siteIds) ? ' AND site_id IN (' . implode(',', $siteIds) . ')' : '';
        return User::whereRaw($where, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm])->get();
    }

    /**
     * Retrieves a list of users for a jQuery Datatable plugin.
     *
     * @param  string   $criteria     Lists of criterias
     * @param  int      $offset
     * @param  int      $limit
     * @param  string   $orderBy
     * @param  string   $order
     *
     * @return [total => X, users => User[]]
     */
    public static function getUsersForDatatable(array $criteria = [], $offset = 0, $limit = 10, $orderBy = 'id', $order = 'DESC')
    {
        $sql = '1';
        $bindings = [];

        if (isset($criteria['site_id']) && is_array($criteria['site_id']) && count($criteria['site_id'])) {
            $sql .= ' AND site_id IN (' . implode(',', $criteria['site_id']) . ')';
        }

        if ( ! empty($criteria['search_term'])) {
            $searchTerm = '%' . $criteria['search_term'] . '%';
            $sql .= ' AND (id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR business_name LIKE ? OR email LIKE ? OR phone LIKE ? or mobile_phone LIKE ?)';
            $bindings = [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm];
        }

        $query = User::whereRaw($sql, $bindings);
        $total = $query->count();
        $results = $query
            ->orderBy($orderBy, $order)
            ->limit($limit)
            ->get();

        return ['total' => $total, 'users' => $results];
    }
}
