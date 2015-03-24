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
        $types = PackageType::whereIn('site_id', [1, $this->user->site_id])->get();
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
        $input['site_id'] = $this->user->site_id;

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
        $type = PackageType::findOrFail($id);
        return view('package_types.form', ['type' => $type]);
    }

    /**
     * Updates a specific type.
     */
    public function postUpdate(Request $request, $id)
    {
        $type = PackageType::findOrFail($id);

        $validator = Validator::make($input = $request->all(), PackageType::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $type->update($input);

        Flash::success('Saved');

        return redirect('package-types');
    }
}
