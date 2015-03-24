<?php namespace App\Models;

use Hash;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends BaseModel implements AuthenticatableInterface {
    use AuthenticableTrait;

    public static $rules = [
        'site_id',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'firstname' => 'required',
        'lastname' => 'required'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $fillable = [
        'site_id',
        'country_id',
        'email',
        'password',
        'company',
        'firstname',
        'lastname',
        'dob',
        'phone',
        'cellphone',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
    ];

    /**
     * ----------------------------------------------------
     * Relationships
     * ----------------------------------------------------
     */

    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'roles_users');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * ----------------------------------------------------
     * Public Methods
     * ----------------------------------------------------
     */

    /**
     * Gets the full name.
     *
     * @return string
     */
    public function name()
    {
        return ucwords(strtolower($this->firstname . ' ' . $this->lastname));
    }

    /**
     * Gets list of assigned roles as an array.
     *
     * @return array
     */
    public function rolesArray()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[$role->id] = $role->name;
        }
        return $roles;
    }

    /**
     * Gets the casillero id.
     *
     * @return string
     */
    public function cid()
    {
        return  '';
    }

    /**
     * Login event callback.
     *
     * @see app/observers.php
     */
    public function afterLogin()
    {
        $this->logins += 1;
        $this->last_login = date('Y-m-d H:i:s');
        $this->save();
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
     * Determines if the user is a store customer.
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
    public function generatePasswordRecoveryToken()
    {
        return urlencode(base64_encode(Hash::make($this->getPlainPasswordRecoveryToken())));
    }

    /**
     * Determines if a password recovery token is valid.
     *
     * @param  string $token
     * @return bool
     */
    public function checkPasswordRecoveryToken($token)
    {
        return Hash::check($this->getPlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Assigns the specified roles.
     *
     * @param  array  $role_ids
     * @return void
     */
    public function attachRoles(array $role_ids = [])
    {
        return $this->roles()->sync($role_ids);
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
     * Overrides parent method to add password and DOB formatting.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key) {
            case 'password':
                $value = (empty($value)) ? $this->password : Hash::make($value);
                break;
            case 'dob':
                if (is_string($value))
                    $value = date('Y-m-d', strtotime($value));
                else if (is_array($value))
                    $value = date('Y-m-d', strtotime($value['year'] . '/' . $value['month'] . '/' . $value['day']));
                else
                    $value = NULL;
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * ----------------------------------------------------
     * Private Methods
     * ----------------------------------------------------
     */

    /**
     * Generates a plain text password recovery token.
     *
     * @return string
     */
    private function getPlainPasswordRecoveryToken()
    {
        return $this->email . $this->password . $this->created_at;
    }

    /**
     * ----------------------------------------------------
     * Static Methods
     * ----------------------------------------------------
     */

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
     * Retrieves a list of users for a jquery autocomplete field.
     *
     * @param  string $query        A search keyword
     * @param  array  $siteIds      List of site ids
     * @return User[]
     */
    public static function getAutocomplete($query, array $siteIds = NULL)
    {
        $query = '%' . $query . '%';
        $where = '(id LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR company LIKE ? OR email LIKE ? OR phone LIKE ? or cellphone LIKE ?)';
        $where .= count($siteIds) ? ' AND site_id IN (' . implode(',', $siteIds) . ')' : '';
        return User::whereRaw($where, [$query, $query, $query, $query, $query, $query, $query])->get();
    }

    /**
     * Retrieves a list of users for a jquery datatable.
     *
     * @param  string   $query        A search keyword
     * @param  array    $siteIds      List of site ids
     * @param  bool     $count
     * @param  int      $offset
     * @param  int      $limit
     * @param  string   $orderBy
     * @param  string   $order
     *
     * @return User[]
     */
    public static function getDatatable($query = NULL, array $siteIds = NULL, $count = FALSE, $offset = 0, $limit = 10, $orderBy = 'id', $order = 'DESC')
    {
        $where = count($siteIds) ? 'site_id IN (' . implode(',', $siteIds) . ')' : '1';

        if (empty($query))
        {
            $users = User::whereRaw($where);
        }
        else
        {
            $query = '%' . $query . '%';
            $where .= ' AND (id LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR company LIKE ? OR email LIKE ? OR phone LIKE ? or cellphone LIKE ?)';
            $users = User::whereRaw($where, [$query, $query, $query, $query, $query, $query, $query]);
        }

        if ($count)
            return $users->count();

        return $users
            ->orderBy($orderBy, $order)
            ->limit($limit)
            ->get();
    }
}
