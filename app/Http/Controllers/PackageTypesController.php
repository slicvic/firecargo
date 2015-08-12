<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\PackageType;

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

        $this->middleware('auth.adminOrHigher');
    }

    /**
     * Show a list of package types.
     *
     * @return View
     */
    public function getIndex()
    {
        $types = PackageType::all();

        return view('admin.package_types.index', ['types' => $types]);
    }

    /**
     * Show the form for creating a new package type.
     *
     * @return View
     */
    public function getCreate()
    {
        return view('admin.package_types.create', ['type' => new PackageType]);
    }

    /**
     * Create a new package type.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        $this->validate($input, PackageType::$rules);

        PackageType::create($input);

        return $this->redirectWithSuccess('package-types', 'Package type created.');
    }

    /**
     * Show the form for editing a package type.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id)
    {
        $model = PackageType::findOrFail($id);

        return view('admin.package_types.edit', ['type' => $model]);
    }

    /**
     * Update a specific package type.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return RedirectResponse
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name');

        $this->validate($input, PackageType::$rules);

        PackageType::findOrFail($id)->update($input);

        return $this->redirectBackWithSuccess('Package type updated.');
    }

    /**
     * Delete a specific package type.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return RedirectResponse
     */
    public function getDelete(Request $request, $id)
    {
        $model = PackageType::findOrFail($id);

        try
        {
            $model->delete();

            return $this->redirectBackWithSuccess('Package type deleted.');
        }
        catch(Exception $e)
        {
            Log::error($e);

            return $this->redirectBackWithError(trans('messages.error_delete_constraint', ['name' => 'package type']));
        }
    }

    /**
     * Return all the package types formatted for an x-editable select field.
     *
     * @return JsonResponse
     * @uses   Ajax
     */
    public function getEditableOptions()
    {
        $types = PackageType::all();

        $json = [];

        foreach ($types as $type)
        {
            $json[] = ['value' => $type->id, 'text' => $type->name];
        }

        return response()->json($json);
    }
}
