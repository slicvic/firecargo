<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Address;

/**
 * Client Accounts Controller
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ClientsController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('agent');
    }

    /**
     * Shows a list of client accounts.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $accounts = Account::mine()->clients()->get();

        return view('accounts.client.index', ['accounts' => $accounts]);
    }

    /**
     * Shows the form for creating a new client account.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('accounts.client.edit', [
            'account' => new Account,
            'address' => new Address
        ]);
    }

    /**
     * Creates a new client account.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $request->only('account', 'address');

        $rules = [
            'name' => 'required',
            'email' => 'email|unique:accounts,email',
        ];

        // Validate input
        $this->validate($input['account'], $rules);

        // Create account
        $account = new Account($input['account']);
        $account->type_id = AccountType::CLIENT;

        if ( ! $account->save())
        {
            return $this->redirectBackWithError('Client creation failed, please try again.');
        }

        // Create address
        $account->address()->save(new Address($input['address']));

        return $this->redirectWithSuccess('clients', 'Client created.');
    }

    /**
     * Shows the form for editing an client account.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $account = Account::findMineOrFail($id);

        return view('accounts.client.edit', [
            'account' => $account,
            'address' => $account->address ?: new Address
        ]);
    }

    /**
     * Updates a specific client account.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('account', 'address');

        $rules = [
            'name' => 'required',
            'email' => 'email|unique:accounts,email,' . $id,
        ];

        // Validate input
        $this->validate($input['account'], $rules);

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

        return $this->redirectBackWithSuccess('Client updated.');
    }
}
