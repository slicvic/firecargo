<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Address;
use App\Http\Requests\ShipperAccountFormRequest;

/**
 * ShipperAccountsController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ShipperAccountsController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('auth.agentOrHigher');
    }

    /**
     * Shows a list of shipper accounts.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $accounts = Account::shippers()->mine()->get();

        return view('admin.accounts.shippers.index', ['accounts' => $accounts]);
    }

    /**
     * Shows the form for creating a new shipper account.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('admin.accounts.shippers.create', [
            'account' => new Account,
            'address' => new Address
        ]);
    }

    /**
     * Creates a new shipper account.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(ShipperAccountFormRequest $request)
    {
        $input = $request->all();

        // Create account
        $account = new Account;
        $account->name = $input['name'];
        $account->type_id = AccountType::SHIPPER;

        // Create address
        $address = new Address;
        $address->address1 = $input['address1'];
        $address->address2 = $input['address2'];
        $address->city = $input['city'];
        $address->state = $input['state'];
        $address->postal_code = $input['postal_code'];
        $address->country_id = $input['country_id'];
        $address->save();

        $account->shippingAddress()
            ->associate($address)
            ->save();

        return $this->redirectWithSuccess('accounts/shippers', 'Shipper created.');
    }

    /**
     * Shows the form for editing an account.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $account = Account::findMineOrFail($id);

        return view('admin.accounts.shippers.edit', [
            'account' => $account,
            'address' => $account->shippingAddress ?: new Address
        ]);
    }

    /**
     * Updates a specific shipper account.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(ShipperAccountFormRequest $request, $id)
    {
        $input = $request->all();

        // Update account
        $account = Account::findMineOrFail($id);
        $account->name = $input['name'];

        // Update address
        $address = ($account->shippingAddress) ?: new Address;
        $address->address1 = $input['address1'];
        $address->address2 = $input['address2'];
        $address->city = $input['city'];
        $address->state = $input['state'];
        $address->postal_code = $input['postal_code'];
        $address->country_id = $input['country_id'];
        $address->save();

        $account->shippingAddress()
            ->associate($address)
            ->save();

        return $this->redirectBackWithSuccess('Shipper updated.');
    }
}
