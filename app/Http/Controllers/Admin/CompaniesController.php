<?php

namespace App\Http\Controllers\Admin;

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
class CompaniesController extends BaseAdminController {

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
     * Show a list of companies.
     *
     * @return View
     */
    public function getIndex()
    {
        $companies = Company::all();

        return view('admin.companies.index', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new company.
     *
     * @return View
     */
    public function getCreate()
    {
        return view('admin.companies.create', ['company' => new Company]);
    }

    /**
     * Create a new company.
     *
     * @param  Request  $request
     * @return RedirectResponse
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
     * Show the form for editing a company.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id)
    {
        $company = Company::findOrFail($id);

        return view('admin.companies.edit', ['company' => $company]);
    }

    /**
     * Update a specific company.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return RedirectResponse
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
