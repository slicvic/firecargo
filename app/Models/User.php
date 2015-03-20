<?php namespace App\Models;

use Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends BaseModel implements AuthenticatableInterface {
    use AuthenticableTrait;

    const CID_PREFIX            = 'SSG';

    public static $rules = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'first_name' => 'required',
        'last_name' => 'required'
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
        'first_name',
        'last_name',
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

    public function name()
    {
        return ucwords(strtolower($this->first_name . ' ' . $this->last_name));
    }

    /**
     * Gets list of roles as array.
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
     * Gets the Casillero ID aka CID.
     *
     * @return string
     */
    public function cid()
    {
        return  self::CID_PREFIX . $this->id;
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
     * Verifies a given password recovery token against a user.
     *
     * @param  string $token
     * @return bool
     */
    public function checkPasswordRecoveryToken($token)
    {
        return Hash::check($this->getPlainPasswordRecoveryToken(), base64_decode(urldecode($token)));
    }

    /**
     * Assigns the given Role IDs.
     *
     * @param  array  $role_ids
     * @return void
     */
    public function attachRoles(array $role_ids = [])
    {
        return $this->roles()->sync($role_ids);
    }

    /**
     * Determines if the user has a given role.
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
                if (is_string($value)) {
                    $value = date('Y-m-d', strtotime($value));
                }
                else if (is_array($value)) {
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
     * ----------------------------------------------------
     * Private Methods
     * ----------------------------------------------------
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
     * Extracts User ID from Casillero ID.
     *
     * @param  string $cid
     * @return int
     */
    public static function cid2id($cid)
    {
        if (empty($cid))
            return NULL;

        $cid = strtolower(trim($cid));
        $id = str_replace(strtolower(self::CID_PREFIX), '', $cid);
        return $id;
    }

    /**
     * Validates a username and password.
     *
     * @param  string $username
     * @param  string $password
     * @return User|FALSE
     */
    public static function checkLogin($username, $password)
    {
        $user = User::where('id', self::cid2id($username))
            ->orWhere('email', $username)
            ->first();

        if ($user && Hash::check($password, $user->password) && $user->hasRole(Role::LOGIN))
            return $user;

        return FALSE;
    }

  /**
     * Fetches results for a jQuery Autocomplete field.
     *
     * @param  string $keyword  A search keyword
     *
     * @return User[]
     */
    public static function getAutocomplete($keyword)
    {
        $keyword = '%' . $keyword . '%';

        return User::whereRaw('
            id LIKE ? OR
            first_name LIKE ? OR
            last_name LIKE ? OR
            company LIKE ? OR
            email LIKE ?',
            [$keyword, $keyword, $keyword, $keyword, $keyword]
        )->get();
    }

    /**
     * Fetches rows for a jQuery DataTable.
     *
     * @param  string   $search_value  A search keyword
     * @param  bool     $count
     * @param  int      $offset
     * @param  int      $limit
     * @param  string   $order_by
     * @param  string   $order
     *
     * @return User[]
     */
    public static function getDatatableData($search_value = NULL, $count = FALSE, $offset = 0, $limit = 10, $order_by = 'id', $order = 'DESC')
    {
        if (empty($search)) {
            $users = User::whereRaw(1);
        }
        else {
            $search = '%' . $search . '%';
            $users = User::whereRaw(
                'id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR company LIKE ? OR email LIKE ?',
                [$search, $search, $search, $search, $search]
            );
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
