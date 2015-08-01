<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\AccountType;

/**
 * General Purpose Accounts Controller
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
     * Retrieves customer or shipper accounts for an ajax autocomplete field.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAjaxAutocomplete(Request $request)
    {
        $input = $request->only('term', 'type');

        // Validate input
        if (strlen($input['term']) < 2)
        {
            return response()->json([]);
        }

        // Determine account type ID
        $typeId = ($input['type'] === 'shipper') ? AccountType::SHIPPER : AccountType::CUSTOMER;

        // Search
        $accounts = Account::autocompleteSearch($input['term'], $typeId)
            ->mine()
            ->limit(25)
            ->get();

        $json = [];

        foreach($accounts as $account)
        {
            $json[] = [
                'id'    => $account->id,
                'label' => $account->name
            ];
        }

        return response()->json($json);
    }
}
