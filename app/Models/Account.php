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
        'name' => ['required', 'min:3', 'regex:/(^[A-Za-z0-9 ]+$)+/'],
        'email' => 'email'
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
     * @var string
     */
    protected $presenter = 'App\Presenters\AccountPresenter';

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
            case 'name':
                $value = ucwords($value);
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
     * Gets the account user.
     *
     * NOTE: ONLY "CUSTOMER" ACCOUNTS HAVE A USER.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Finds customer accounts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCustomers($query)
    {
        return $query->where('type_id', AccountType::CUSTOMER);
    }

    /**
     * Finds shipper accounts.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeShippers($query)
    {
        return $query->where('type_id', AccountType::SHIPPER);
    }

    /**
     * Checks if this is a customer account or not.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return ((int) $this->type_id === AccountType::CUSTOMER);
    }

    /**
     * Finds accounts matching the provided search term and type for an
     * ajax autocomplete field.
     *
     * @param  string  $searchTerm
     * @param  int     $accountTypeId
     * @return Builder
     */
    public static function autocompleteSearch($searchTerm, $accountTypeId)
    {
        $query = Account::query();

        $searchTerm = '%' . $searchTerm . '%';

        $query->whereRaw('
            type_id = ?
            AND (id LIKE ?
            OR name LIKE ?
            OR firstname LIKE ?
            OR lastname LIKE ?
            OR email LIKE ?
            OR phone LIKE ?
            OR fax LIKE ?
            OR mobile_phone LIKE ?)', [
            $accountTypeId,
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
