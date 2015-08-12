<?php namespace App\Http\Controllers;

use Validator;
use Config;
use Exception;
use Log;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Company;
use App\Models\Address;
use App\Models\Country;
use App\Helpers\Upload;
use App\Http\Requests\UpdateCompanyProfileFormRequest;

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

        $this->middleware('auth.agentOrHigher');
    }

    /**
     * Show the company profile.
     *
     * @return View
     */
    public function getProfile()
    {
        return view('admin.company_profile.show', [
            'company' => $this->user->company,
        ]);
    }

    /**
     * Show the form for editing the company profile.
     *
     * @return View
     */
    public function getEditProfile()
    {
        $company = $this->user->company;

        return view('admin.company_profile.edit', [
            'company' => $company,
            'address' => $company->billingAddress ?: new Address
        ]);
    }

    /**
     * Update the company profile.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postProfile(UpdateCompanyProfileFormRequest $request)
    {
        $input = $request->only('company', 'address');

        // Update company
        $company = $this->user->company;
        $company->name = $input['company']['name'];
        $company->phone = $input['company']['phone'];
        $company->fax = $input['company']['fax'];
        $company->email = $input['company']['email'];

        // Update address
        $address = $company->billingAddress ?: new Address;
        $address->address1 = $input['address']['address1'];
        $address->address2 = $input['address']['address2'];
        $address->city = $input['address']['city'];
        $address->state = $input['address']['state'];
        $address->postal_code = $input['address']['postal_code'];
        $address->country_id = $input['address']['country_id'];
        $address->save();

        $company->billingAddress()
            ->associate($address)
            ->save();

        return $this->redirectWithSuccess('company/profile', 'Your company profile has been updated.');
    }

    /**
     * Upload the company logo.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postUploadLogo(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . Upload::MAX_FILE_SIZE
        ]);

        if ($validator->fails())
        {
            return response()->jsonFlash($validator, 404);
        }

        try
        {
            Upload::saveCompanyLogo($input['file'], $this->user->company->id);

            $this->user->company->update(['has_logo' => TRUE]);

            return response()->jsonFlash('Your logo has been uploaded.');
        }
        catch(Exception $e)
        {
            Log::error($e);

            return response()->jsonFlash('Upload failed, please try again.', 500);
        }
    }
}
