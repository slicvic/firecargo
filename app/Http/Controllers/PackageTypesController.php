<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\PackageType;
use App\Helpers\Flash;

/**
 * PackageTypesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageTypesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of package types.
     */
    public function getIndex()
    {
        $types = PackageType::allByCurrentCompany();
        return view('package_types.index', ['types' => $types]);
    }

    /**
     * Shows the form for creating a new package type.
     */
    public function getCreate()
    {
        return view('package_types.form', ['type' => new PackageType]);
    }

    /**
     * Creates a new package type.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, PackageType::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create package type
        PackageType::create($input);

        Flash::success('Package type created.');
        return redirect('package-types');
    }

    /**
     * Shows the form for editing a package type.
     */
    public function getEdit($id)
    {
        $type = PackageType::findOrFailByIdAndCurrentCompany($id);
        return view('package_types.form', ['type' => $type]);
    }

    /**
     * Updates a specific package type.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, PackageType::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update package type
        $type = PackageType::findOrFailByIdAndCurrentCompany($id);
        $type->update($input);

        Flash::success('Package type updated.');
        return redirect()->back();
    }

    /**
     * Deletes a specific package type.
     */
    public function getDelete(Request $request, $id)
    {
        $packageType = PackageType::findByIdAndCurrentCompany($id);

        if ($packageType) {
            $packageType->delete();
            Flash::success('Package type deleted.');
        }
        else {
            Flash::error('Package type not found.');
        }

        return redirect()->back();
    }
}
