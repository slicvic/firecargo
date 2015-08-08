<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Address;
use App\Http\Requests\CompanyFormRequest;

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

        $this->middleware('auth.adminOrHigher');
    }

    /**
     * Shows a list of companies.
     *
     * @return Response
     */
    public function getIndex()
    {
        $companies = Company::all();

        return view('admin.companies.index', ['companies' => $companies]);
    }

    /**
     * Shows the form for creating a new company.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('admin.companies.create', ['company' => new Company]);
    }

    /**
     * Creates a new company.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(CompanyFormRequest $request)
    {
        $input = $request->all();

        $company = new Company;
        $company->name = $input['name'];
        $company->firstname = $input['firstname'];
        $company->lastname = $input['lastname'];
        $company->email = $input['email'];
        $company->phone = $input['phone'];
        $company->save();

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

        return view('admin.companies.edit', ['company' => $company]);
    }

    /**
     * Updates a specific company.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(CompanyFormRequest $request, $id)
    {
        $input = $request->all();

        $company = Company::findOrFail($id);
        $company->name = $input['name'];
        $company->firstname = $input['firstname'];
        $company->lastname = $input['lastname'];
        $company->email = $input['email'];
        $company->phone = $input['phone'];
        $company->save();

        return $this->redirectBackWithSuccess('Company updated.');
    }
}
