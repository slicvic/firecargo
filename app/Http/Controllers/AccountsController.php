<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Session;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Role;
use App\Models\Address;
use Flash;

/**
 * AccountsController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountsController extends BaseAuthController {

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
     * Shows a list of accounts.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $accounts = Account::mine()->get();

        return view('accounts.index', ['accounts' => $accounts]);
    }

    /**
     * Shows the form for creating an account.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('accounts.edit', [
            'account' => new Account,
            'address' => new Address
        ]);
    }

    /**
     * Creates a new account.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $request->only('account', 'address');

        // Validate input
        $rules = [
            'type_id' => 'required',
            'email' => 'email',
            'name' => 'required'
        ];

        $this->validate($input['account'], $rules);

        // Create account
        $account = new Account($input['account']);

        if ( ! $account->save())
        {
            return $this->redirectBackWithError('Account creation failed, please try again.');
        }

        // Create address
        $account->address()->save(new Address($input['address']));

        return $this->redirectWithSuccess('accounts', 'Account created.');
    }

    /**
     * Shows the form for editing an account.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $account = Account::findMine($id);

        if ( ! $account)
        {
            return $this->redirectBackWithError('Account not found.');
        }

        return view('accounts.edit', [
            'account' => $account,
            'address' => $account->address ?: new Address
        ]);
    }

    /**
     * Updates a specific user.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('account', 'address');

        // Validate input
        $rules = [
            'type_id' => 'required',
            'email' => 'email',
            'name' => 'required'
        ];

        $this->validate($input['account'], $rules);

        // Update account
        $account = Account::findMine($id);

        if ( ! $account)
        {
            return $this->redirectBackWithError('Account not found.');
        }

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

        return $this->redirectBackWithSuccess('Account updated.');
    }
}
