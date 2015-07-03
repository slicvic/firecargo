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

    public function getProfile()
    {
        return view('company.profile', ['company' => $this->user->site->company]);
    }

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

    public function postUploadLogo(Request $request)
    {
        $input = $request->only('file');

        // Validate input
        $maxKb = 10000; // 10 MB
        $validator = Validator::make($input, [
            'file' => 'required|mimes:gif,jpg,jpeg,png|max:' . $maxKb
        ]);

        if ($validator->fails()) {
           return response()->json($validator->messages()->toArray(), 500);
        }

        // Save file
        $file = $input['file'];
        $destination = public_path() . '/uploads/companies/' . $this->user->site->company->id . '/images/logo/';
        $dimensions = [
            'sm' => 100,
            'md' => 200,
            'lg' => 300
        ];

        foreach ($dimensions as $filename => $dimension) {
            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, NULL, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($destination . $filename . '.png');
        }

        unlink($file->getPathName());
        return response()->json(['status' => 'ok']);
    }
}
