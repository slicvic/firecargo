<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Company;
use App\Helpers\Flash;

class CompanyController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    public function getProfile()
    {
        return view('company.profile', ['company' => $this->user->site->company]);
    }

    public function postProfile(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, Company::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $this->user->site->company->update($input);

        Flash::success('Saved');
        return redirect()->back();
    }
}
