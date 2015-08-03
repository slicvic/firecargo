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
use App\Http\ToastrJsonResponse;

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
     * Shows the company profile.
     *
     * @return Response
     */
    public function getProfile()
    {
        return view('company_profile.show', [
            'company' => $this->user->company,
        ]);
    }

    /**
     * Shows the form for editing the company profile.
     *
     * @return Response
     */
    public function getEditProfile()
    {
        return view('company_profile.edit', [
            'company' => $this->user->company,
            'address' => $this->user->company->address ?: new Address
        ]);
    }

    /**
     * Updates the company profile.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postProfile(Request $request)
    {
        $input = $request->only('company', 'address');

        $rules = [
            'name' => 'required'
        ];

        // Validate input
        $this->validate($input['company'], $rules);

        // Update company
        $this->user->company->update($input['company']);

        // Update address
        if ($this->user->company->address)
        {
            $this->user->company->address->update($input['address']);
        }
        else
        {
            $this->user->company->address()->save(new Address($input['address']));
        }

        return $this->redirectWithSuccess('company/profile', 'Your company profile has been updated.');
    }

    /**
     * Uploads the company logo.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postLogo(Request $request)
    {
        $input = $request->only('file');

        // Validate file

        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . Upload::MAX_FILE_SIZE
        ]);

        if ($validator->fails())
        {
            return ToastrJsonResponse::error($validator, 404);
        }

        // Save logo

        try
        {
            Upload::saveCompanyLogo($input['file'], $this->user->company->id);

            $this->user->company->update(['has_logo' => TRUE]);

            return ToastrJsonResponse::success('Your logo has been uploaded.');
        }
        catch(Exception $e)
        {
            $this->user->company->update(['has_logo' => FALSE]);

            Log::error($e);

            return ToastrJsonResponse::error('Upload failed, please try again.', 500);
        }
    }
}
