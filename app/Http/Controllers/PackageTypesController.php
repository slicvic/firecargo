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
        $this->middleware('admin');
    }

    /**
     * Shows a list of package types.
     */
    public function getIndex()
    {
        $types = PackageType::all();
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
        $this->validate($input, PackageType::$rules);

        // Create package type
        PackageType::create($input);

        return $this->redirectWithSuccess('package-types', 'Package type created.');
    }

    /**
     * Shows the form for editing a package type.
     */
    public function getEdit($id)
    {
        $type = PackageType::findOrFail($id);
        return view('package_types.form', ['type' => $type]);
    }

    /**
     * Updates a specific package type.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, PackageType::$rules);

        // Update package type
        $type = PackageType::findOrFail($id);
        $type->update($input);

        return $this->redirectBackWithSuccess('Package type updated.');
    }

    /**
     * Deletes a specific package type.
     */
    public function getDelete(Request $request, $id)
    {
        $type = PackageType::findOrFail($id);

        if ($type && $type->delete()) {
            return $this->redirectBackWithSuccess(sprintf('Package type "%s (%s)" deleted.', $type->name, $type->id));
        }

        return $this->redirectBackWithError('Package type delete failed.');
    }
}
