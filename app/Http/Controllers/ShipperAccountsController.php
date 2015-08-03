<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Address;

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

        return view('accounts.shipper.index', ['accounts' => $accounts]);
    }

    /**
     * Shows the form for creating a new shipper account.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('accounts.shipper.edit', [
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
    public function postStore(Request $request)
    {
        $input = $request->only('account', 'address');

        // Validate input
        $this->validate($input['account'], Account::$rules['shipper']);

        // Create account
        $account = new Account($input['account']);
        $account->type_id = AccountType::SHIPPER;

        if ( ! $account->save())
        {
            return $this->redirectBackWithError('Shipper creation failed, please try again.');
        }

        // Create address
        $account->address()->save(new Address($input['address']));

        return $this->redirectWithSuccess('shippers', 'Shipper created.');
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

        return view('accounts.shipper.edit', [
            'account' => $account,
            'address' => $account->address ?: new Address
        ]);
    }

    /**
     * Updates a specific shipper account.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('account', 'address');

        // Validate input
        $this->validate($input['account'], Account::$rules['shipper']);

        // Update account
        $account = Account::findMineOrFail($id);
        $account->update($input['account']);

        // Update address
        if ($account->address)
        {
            $account->address->update($input['address']);
        }
        else
        {
            $account->address()->save(new Address($input['address']));
        }

        return $this->redirectBackWithSuccess('Shipper updated.');
    }
}
