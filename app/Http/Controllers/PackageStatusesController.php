<?php namespace App\Http\Controllers;

use Validator;
use Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\PackageStatus;
use Flash;

/**
 * PackageStatusesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatusesController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('agent');
    }

    /**
     * Shows a list of package statuses.
     *
     * @return Response
     */
    public function getIndex()
    {
        $statuses = PackageStatus::allByCurrentUserCompanyId();

        return view('package_statuses.index', ['statuses' => $statuses]);
    }

    /**
     * Shows the form for creating a new package status.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('package_statuses.edit', ['status' => new PackageStatus]);
    }

    /**
     * Creates a new package status.
     *
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $request->only('name', 'is_default');

        // Validate input
        $this->validate($input, PackageStatus::$rules);

        // Create status
        $status = new PackageStatus($input);
        $status->company_id = $this->authUser->company_id;
        $status->save();

        return $this->redirectWithSuccess('package-statuses', 'Package status created.');
    }

    /**
     * Shows the form for editing a package status.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $status = PackageStatus::findOrFailByIdAndCurrentUserCompanyId($id);

        return view('package_statuses.edit', ['status' => $status]);
    }

    /**
     * Updates a specific package status.
     *
     * @return Redirector
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
     *
     * @return Redirector
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
