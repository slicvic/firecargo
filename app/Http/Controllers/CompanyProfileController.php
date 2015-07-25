<?php namespace App\Http\Controllers;

use Validator;
use Config;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Company;
use App\Models\Address;
use App\Models\Country;
use App\Helpers\Upload;
use Flash;

/**
 * CompanyProfileController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CompanyProfileController extends BaseAuthController {

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
     * Shows the company's profile.
     *
     * @return Response
     */
    public function getProfile()
    {
        return view('company_profile.show', [
            'company' => $this->authUser->company,
        ]);
    }

    /**
     * Shows the form for editing a company's profile.
     *
     * @return Response
     */
    public function getEditProfile()
    {
        return view('company_profile.edit', [
            'company' => $this->authUser->company,
            'address' => $this->authUser->company->address ?: new Address
        ]);
    }

    /**
     * Updates the company's profile.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postProfile(Request $request)
    {
        $input = $request->only('company', 'address');

        // Validate input
        $rules = [
            'name' => 'required'
        ];

        $this->validate($input['company'], $rules);

        // Update company
        $this->authUser->company->update($input['company']);

        // Update address
        if ($this->authUser->company->address)
        {
            $this->authUser->company->address->update($input['address']);
        }
        else
        {
            $this->authUser->company->address()->save(new Address($input['address']));
        }

        return $this->redirectBackWithSuccess('Company updated.');
    }

    /**
     * Uploads the company's logo.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postAjaxUploadLogo(Request $request)
    {
        $input = $request->only('file');

        // Validate input
        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . Upload::MAX_FILE_SIZE
        ]);

        if ($validator->fails())
        {
           return response()->json(Flash::view($validator), 500);
        }

        // Save photo
        try
        {
            Upload::saveCompanyLogo($input['file'], $this->authUser->company->id);
            $this->authUser->company->update(['has_logo' => TRUE]);
            return response()->json([]);
        }
        catch(\Exception $e)
        {
            $this->authUser->company->update(['has_logo' => FALSE]);
            return response()->json(Flash::view('Upload failed, please try again.'), 500);
        }
    }
}
