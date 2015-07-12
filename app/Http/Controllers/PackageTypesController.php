<?php namespace App\Http\Controllers;

use Validator;
use Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\PackageType;
use App\Helpers\Flash;

/**
 * PackageTypesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageTypesController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('admin');
    }

    /**
     * Shows a list of package types.
     *
     * @return Response
     */
    public function getIndex()
    {
        $types = PackageType::all();

        return view('package_types.index', ['types' => $types]);
    }

    /**
     * Shows the form for creating a new package type.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('package_types.form', ['type' => new PackageType]);
    }

    /**
     * Creates a new package type.
     *
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, PackageType::$rules);

        // Create package type
        PackageType::create($input);

        return $this->redirectWithSuccess('package-types', 'Package type created.');
    }

    /**
     * Shows the form for editing a package type.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $type = PackageType::findOrFail($id);

        return view('package_types.form', ['type' => $type]);
    }

    /**
     * Updates a specific package type.
     *
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name');

        // Validate input
        $this->validate($input, PackageType::$rules);

        // Update package type
        PackageType::updateById($id, $input);

        return $this->redirectBackWithSuccess('Package type updated.');
    }

    /**
     * Deletes a specific package type.
     *
     * @return Redirector
     */
    public function getDelete(Request $request, $id)
    {
        // TODO
        return redirect()->back();
    }
}
