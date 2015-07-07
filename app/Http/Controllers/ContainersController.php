<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Container;
use App\Helpers\Flash;

/**
 * ContainersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ContainersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of warehouse groups.
     */
    public function getIndex()
    {
        $groups = Container::allByCurrentCompany();
        return view('containers.index', ['groups' => $groups]);
    }

    /**
     * Shows the form for creating a new company.
     */
    public function getCreate()
    {
        return view('container.form', ['group' => new WarehouseGroup()]);
    }

    /**
     * Creates a new company.
     */
    public function postStore(Request $request)
    {
        $validator = Validator::make($input = $request->all(), Company::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        Company::create($input);

        Flash::success('New company created.');
        return redirect('companies');
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
        $validator = Validator::make($input, Company::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $company = Company::findOrFail($id);
        $company->update($input);

        Flash::success('Company updated.');
        return redirect()->back();
    }
}
