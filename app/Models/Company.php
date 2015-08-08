<?php namespace App\Models;

use DB;

use App\Presenters\PresentableTrait;
use App\Observers\CompanyObserver;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends Base {

    use PresentableTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The presenter path.
     *
     * @var string
     */
    protected $presenter = 'App\Presenters\CompanyPresenter';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'has_logo',
        'firstname',
        'lastname'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        Company::observe(new CompanyObserver);
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
     * Gets the shipping address.
     *
     * @return Address
     */
    public function shippingAddress()
    {
        return $this->belongsTo('App\Models\Address', 'shipping_address_id');
    }

    /**
     * Gets the billing address.
     *
     * @return Address
     */
    public function billingAddress()
    {
        return $this->belongsTo('App\Models\Address', 'billing_address_id');
    }

    /**
     * Overrides parent method to assign link code.
     *
     * {@inheritdoc}
     */
    public function save(array $options = array())
    {
        if ($this->exists)
        {
            return parent::save();
        }
        else
        {
            $result = parent::save();

            $this->assignLinkCode();

            return $result;
        }
    }

    /**
     * Generates and assigns a link code.
     *
     * @return void
     */
    private function assignLinkCode()
    {
        if ( ! $this->exists || $this->link_code)
        {
            // Company musts exist and not already have a link code assigned.
            return FALSE;
        }

        $words = explode(' ', strtolower(trim($this->name)));

        if (count($words) === 1)
        {
            $this->link_code = trim($words[0]);
        }
        else
        {
            $acronym = '';

            foreach ($words as $word)
            {
                $acronym .= $word[0];
            }

            $this->link_code = $acronym;
        }

        $this->link_code .= $this->id;

        $this->save();
    }
}
