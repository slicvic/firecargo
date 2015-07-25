<?php namespace App\Models;

use DB;
use Auth;

use App\Presenters\PresentableTrait;
use App\Observers\AccountObserver;

/**
 * Account
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Account extends Base {

    use CompanyTrait, PresentableTrait;

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'type_id' => 'required',
        'email' => 'email',
        'name' => 'required'
    ];
    
    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The presenter path.
     *
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\Account';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'type_id',
        'user_id',
        'email',
        'name',
        'firstname',
        'lastname',
        'phone',
        'mobile_phone',
        'fax',
        'autoship'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        Account::observe(new AccountObserver);
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
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Gets the account type.
     *
     * @return Role
     */
    public function type()
    {
        return $this->belongsTo('App\Models\AccountType');
    }

    /**
     * Gets the account address.
     *
     * @return Address
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * Gets the account owner.
     *
     * NOTICE: ONLY "CLIENT" ACCOUNTS HAVE A USER ASSIGNED.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Checks if the account is of a "client" type.
     *
     * @return bool
     */
    public function isClient()
    {
        return ((int) $this->type_id === AccountType::CLIENT);
    }

    /**
     * Finds accounts matching the given search term.
     *
     * @param  string   $searchTerm
     * @return Builder
     */
    public static function autocompleteSearch($searchTerm)
    {
        $query = Account::query();

        $searchTerm = '%' . $searchTerm . '%';

        $query->whereRaw('
            id LIKE ?
            OR name LIKE ?
            OR firstname LIKE ?
            OR lastname LIKE ?
            OR email LIKE ?
            OR phone LIKE ?
            OR fax LIKE ?
            OR mobile_phone LIKE ?', [
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm
        ]);

        return $query;
    }
}
