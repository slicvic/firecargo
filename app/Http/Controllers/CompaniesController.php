<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Address;
use Flash;

/**
 * CompaniesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CompaniesController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('admin');
    }

    /**
     * Shows a list of companies.
     *
     * @return Response
     */
    public function getIndex()
    {
        $companies = Company::all();

        return view('companies.index', ['companies' => $companies]);
    }

    /**
     * Shows the form for creating a new company.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('companies.edit', ['company' => new Company]);
    }

    /**
     * Creates a new company.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $rules = [
            'name' => 'required',
            'shortname' => 'required'
        ];

        $this->validate($input, $rules);

        // Create company
        $company = Company::create($input);

        // Create address
        if ($company->exists)
        {
            $company->address()->save(new Address);
        }

        return $this->redirectWithSuccess('companies', 'Company created.');
    }

    /**
     * Shows the form for editing a company.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $company = Company::findOrFail($id);

        return view('companies.edit', ['company' => $company]);
    }

    /**
     * Updates a specific company.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name', 'shortname');

        // Validate input
        $rules = [
            'name' => 'required',
            'shortname' => 'required'
        ];

        $this->validate($input, $rules);

        // Update company
        Company::findOrFail($id)->update($input);

        return $this->redirectBackWithSuccess('Company updated.');
    }
}
