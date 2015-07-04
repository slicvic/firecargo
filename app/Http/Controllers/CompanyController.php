<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Company;
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
        $content = view('company.show');
        return view('company.layout', ['company' => $this->user->site->company, 'content' => $content]);
    }

    /**
     * Displays the form for editing a company's profile.
     */
    public function getEdit()
    {
        $company = $this->user->site->company;
        $content = view('company.edit', ['company' => $company]);
        return view('company.layout', ['company' => $company, 'content' => $content]);
    }

    /**
     * Updates the company's profile.
     */
    public function postProfile(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Company::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $this->user->site->company->update($input);

        Flash::success('Profile updated.');
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
        $destination = public_path() . '/uploads/companies/' . $this->user->site->company->id . '/images/logo/';
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
