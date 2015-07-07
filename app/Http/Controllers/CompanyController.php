<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Company;
use App\Models\Address;
use App\Helpers\Flash;
use Config;
use Intervention\Image\ImageManagerStatic as Image;

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

    /**
     * Displays the company's profile.
     */
    public function getProfile()
    {
        $company = $this->user->company;
        $view = view('company_profile.show', ['company' => $company]);
        return view('company_profile.layout', ['company' => $company, 'content' => $view]);
    }

    /**
     * Displays the form for editing a company's profile.
     */
    public function getEditProfile()
    {
        $company = $this->user->company;
        $view = view('company_profile.edit', ['company' => $company]);
        return view('company_profile.layout', ['company' => $company, 'content' => $view]);
    }

    /**
     * Updates the company's profile.
     */
    public function postProfile(Request $request)
    {
        $input = $request->only('company', 'address');

        // Validate input
        $validator = Validator::make($input['company'], Company::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update company
        $company = $this->user->company;
        $company->update($input['company']);

        // Update address
        if ($company->address) {
            $company->address->update($input['address']);
        }
        else {
            $address = new Address($input['address']);
            $address->company()->associate($company);
            $address->save();
        }

        Flash::success('Company updated.');
        return redirect()->back();
    }

    /**
     * Uploads the company's logo.
     *
     * @uses    ajax
     * @return  json
     */
    public function postAjaxUploadLogo(Request $request)
    {
        $input = $request->only('file');

        // Validate input
        $maxKb = 10000; // 10 MB
        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . $maxKb
        ]);

        if ($validator->fails()) {
           return response()->json($validator->messages()->toArray(), 500);
        }

        // Create destination directory
        $destination = public_path() . '/uploads/companies/' . $this->user->company->id . '/images/logo/';
        if ( ! file_exists($destination)) {
            mkdir($destination, 0775, TRUE);
        }

        // Make thumbnails
        $dimensions = [
            'sm' => 100,
            'md' => 200,
            'lg' => 300
        ];

        foreach ($dimensions as $filename => $dimension) {
            Image::make($input['file']->getPathName())
                ->orientate()
                ->resize($dimension, NULL, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($destination . $filename . '.png');
        }

        unlink($input['file']->getPathName());
        return response()->json([]);
    }
}
