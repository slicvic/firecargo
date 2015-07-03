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
     * Shows a list of statuses.
     */
    public function getIndex()
    {
        $statuses = PackageStatus::allByCurrentSiteId();
        return view('package_statuses.index', ['statuses' => $statuses]);
    }

    /**
     * Shows the form for creating a new status.
     */
    public function getCreate()
    {
        return view('package_statuses.form', ['status' => new PackageStatus()]);
    }

    /**
     * Creates a new status.
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
        if (isset($input['is_default'])) {
            PackageStatus::unsetDefaultBySiteId($this->user->site_id);
        }

        PackageStatus::create($input);

        Flash::success('New package status created.');
        return redirect('package-statuses');
    }

    /**
     * Shows the form for editing a status.
     */
    public function getEdit($id)
    {
        $status = PackageStatus::findOrFailByIdAndCurrentSiteId($id);
        return view('package_statuses.form', ['status' => $status]);
    }

    /**
     * Updates a specific status.
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
        $status = PackageStatus::findOrFailByIdAndCurrentSiteId($id);

        if (isset($input['is_default']) && ! $status->is_default) {
            PackageStatus::unsetDefaultBySiteId($this->user->site_id);
        }

        $status->update($input);

        Flash::success('Package status updated.');
        return redirect()->back();
    }

    /**
     * Deletes a specific status.
     */
    public function getDelete(Request $request, $id)
    {
        $status = PackageStatus::findByIdAndCurrentSiteId($id);

        if ($status) {
            $status->delete();
            Flash::success('Package status deleted.');
        }
        else {
            Flash::error('Package status not found.');
        }

        return redirect('package-statuses');
    }
}
