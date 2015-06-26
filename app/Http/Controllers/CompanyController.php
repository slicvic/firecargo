<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Company;
use App\Helpers\Flash;

/**
 * CompanyController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
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
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $this->user->site->company->update($input);

        Flash::success('Record updated successfully.');

        return redirect()->back();
    }

    public function postUploadLogo(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            //  Request::file('photo')->move($destinationPath, $fileName);
            //$request->file('file')->move(__DIR__)
            echo __DIR__ . '../../uploads/';exit;
        }
    }
}
