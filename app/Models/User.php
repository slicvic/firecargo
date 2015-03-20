<?php namespace App\Models;

use Hash;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends BaseModel implements AuthenticatableInterface {
    use AuthenticableTrait;

    public static $rules = [
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
        'company_id',
        'email',
        'password',
        'id_type_id',
        'id_number',
        'company_name',
        'firstname',
        'lastname',
        'dob',
        'home_phone',
        'cell_phone',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
        'country_id'
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
        return $this->belongsToMany('App\Models\Role', 'user_roles');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function idtype()
    {
        return $this->belongsTo('App\Models\UserIdType', 'id_type_id');
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
        return  $this->company->code . $this->id;
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
     * Determines if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(Role::ADMIN);
    }

    /**
     * Determines if the user is a master.
     *
     * @return bool
     */
    public function isMaster()
    {
        return $this->hasRole(Role::MASTER);
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
     * @param  int  $role_id
     * @return bool
     */
    public function hasRole($role_id)
    {
        return in_array($role_id, array_fetch($this->roles->toArray(), 'id'));
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
     * Retrieves a list of users for a jQuery autocomplete field.
     *
     * @param  string $search_term  A search keyword
     *
     * @return User[]
     * @uses   Auth
     */
    public static function getAutocomplete($search_term)
    {
        $auth_user = Auth::user();
        $search_term = '%' . $search_term . '%';
        $where = '(id LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR company_name LIKE ? OR email LIKE ?)';
        $where .= $auth_user->isMaster() ? '' : ' AND company_id = ' . $auth_user->company_id;
        return User::whereRaw($where, [$search_term, $search_term, $search_term, $search_term, $search_term])->get();
    }

    /**
     * Retrieves a list of users for a jQuery DataTable.
     *
     * @param  string   $search_term  A search keyword
     * @param  bool     $count
     * @param  int      $offset
     * @param  int      $limit
     * @param  string   $order_by
     * @param  string   $order
     *
     * @return User[]
     * @uses   Auth
     */
    public static function getDatatable($search_term = NULL, $count = FALSE, $offset = 0, $limit = 10, $order_by = 'id', $order = 'DESC')
    {
        $auth_user = Auth::user();

        if (empty($search_term)) {
            $users = User::whereRaw($auth_user->isMaster() ? 1 : 'company_id = ' . $auth_user->company_id);
        }
        else {
            $search_term = '%' . $search_term . '%';
            $where = '(id LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR company_name LIKE ? OR email LIKE ?)';
            $where .= $auth_user->isMaster() ? '' : ' AND company_id = ' . $auth_user->company_id;
            $users = User::whereRaw($where, [$search_term, $search_term, $search_term, $search_term, $search_term]);
        }

        if ($count) {
            return $users->count();
        }

        return $users
            ->orderBy($order_by, $order)
            ->limit($limit)
            ->get();
    }
}
