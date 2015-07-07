<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\PackageStatus;
use App\Helpers\Flash;

/**
 * PackageStatusesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatusesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of package statuses.
     */
    public function getIndex()
    {
        $statuses = PackageStatus::allByCurrentCompany();
        return view('package_statuses.index', ['statuses' => $statuses]);
    }

    /**
     * Shows the form for creating a new package status.
     */
    public function getCreate()
    {
        return view('package_statuses.form', ['status' => new PackageStatus()]);
    }

    /**
     * Creates a new package status.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, PackageStatus::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create status
        PackageStatus::create($input);

        Flash::success('Package status created.');
        return redirect('package-statuses');
    }

    /**
     * Shows the form for editing a package status.
     */
    public function getEdit($id)
    {
        $status = PackageStatus::findOrFailByIdAndCurrentCompany($id);
        return view('package_statuses.form', ['status' => $status]);
    }

    /**
     * Updates a specific package status.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, PackageStatus::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update status
        $status = PackageStatus::findOrFailByIdAndCurrentCompany($id);
        $status->update($input);

        Flash::success('Package status updated.');
        return redirect()->back();
    }

    /**
     * Deletes a specific package status.
     */
    public function getDelete(Request $request, $id)
    {
        $packageStatus = PackageStatus::findByIdAndCurrentCompany($id);

        if ($packageStatus) {
            $packageStatus->delete();
            Flash::success('Package status deleted.');
        }
        else {
            Flash::error('Package status not found.');
        }

        return redirect()->back();
    }
}
