<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\PackageType;
use App\Helpers\Flash;

class PackageTypesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Displays a list of types.
     */
    public function getIndex()
    {
        $types = PackageType::all();
        return view('package_types.index', ['types' => $types]);
    }

    /**
     * Shows the form for creating a new type.
     */
    public function getCreate()
    {
        return view('package_types.form', ['type' => new PackageType()]);
    }

    /**
     * Creates a new type.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, PackageType::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        PackageType::create($input);

        Flash::success('Saved');

        return redirect('package-types');
    }

    /**
     * Shows the form for editing a type.
     */
    public function getEdit($id)
    {
        $type = PackageType::findOrFailByIdAndSiteId($id, $this->user->site_id);
        return view('package_types.form', ['type' => $type]);
    }

    /**
     * Updates a specific type.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, PackageType::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $type = PackageType::findOrFailByIdAndSiteId($id, $this->user->site_id);
        $type->update($input);

        Flash::success('Saved');

        return redirect('package-types');
    }
}
