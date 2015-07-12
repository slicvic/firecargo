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
        $statuses = PackageStatus::allByCurrentUserCompanyId();

        return view('package_statuses.index', ['statuses' => $statuses]);
    }

    /**
     * Shows the form for creating a new package status.
     */
    public function getCreate()
    {
        return view('package_statuses.form', ['status' => new PackageStatus]);
    }

    /**
     * Creates a new package status.
     */
    public function postStore(Request $request)
    {
        $input = $request->only('name', 'is_default');

        // Validate input
        $this->validate($input, PackageStatus::$rules);

        // Create status
        $status = new PackageStatus($input);
        $status->company_id = $this->user->company_id;
        $status->save();

        return $this->redirectWithSuccess('package-statuses', 'Package status created.');
    }

    /**
     * Shows the form for editing a package status.
     */
    public function getEdit($id)
    {
        $status = PackageStatus::findOrFailByIdAndCurrentUserCompanyId($id);

        return view('package_statuses.form', ['status' => $status]);
    }

    /**
     * Updates a specific package status.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name', 'is_default');

        // Validate input
        $this->validate($input, PackageStatus::$rules);

        // Update status
        $status = PackageStatus::findOrFailByIdAndCurrentUserCompanyId($id);
        $status->fill($input);
        $status->save();

        return $this->redirectBackWithSuccess('Package status updated.');
    }

    /**
     * Deletes a specific package status.
     */
    public function getDelete(Request $request, $id)
    {
        if (PackageStatus::deleteByIdAndCurrentUserCompanyId($id))
        {
            return $this->redirectBackWithSuccess('Package status deleted.');
        }

        return $this->redirectBackWithError('Package status delete failed.');
    }
}
