<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Address;
use App\Helpers\Flash;

/**
 * CompaniesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CompaniesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Shows a list of companies.
     */
    public function getIndex()
    {
        $companies = Company::all();
        return view('companies.index', ['companies' => $companies]);
    }

    /**
     * Shows the form for creating a new company.
     */
    public function getCreate()
    {
        return view('companies.form', ['company' => new Company]);
    }

    /**
     * Creates a new company.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, Company::$rules);

        // Create company
        $company = new Company($input);
        $company->save();

        // Create address
        $address = new Address();
        $address->company()->associate($company);
        $address->save();

        return $this->redirectWithSuccessMessage('companies', 'Company created.');
    }

    /**
     * Shows the form for editing a company.
     */
    public function getEdit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.form', ['company' => $company]);
    }

    /**
     * Updates a specific company.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, Company::$rules);

        // Update company
        $company = Company::findOrFail($id);
        $company->update($input);

        return $this->redirectBackWithSuccessMessage('Company updated.');
    }
}
