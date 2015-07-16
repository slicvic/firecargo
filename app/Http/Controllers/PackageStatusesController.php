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
        $statuses = PackageStatus::filterByCompany()->get();

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
        PackageStatus::create($input);

        return $this->redirectWithSuccess('package-statuses', 'Package status created.');
    }

    /**
     * Shows the form for editing a package status.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $status = PackageStatus::find($id);

        if ( ! $status)
        {
            return $this->redirectBackWithError('Package status not found.');
        }

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
        $status = PackageStatus::find($id);

        if ( ! $status)
        {
            return $this->redirectBackWithError('Package status not found.');
        }

        $status->update($input);

        return $this->redirectBackWithSuccess('Package status updated.');
    }

    /**
     * Deletes a specific package status.
     *
     * @return Redirector
     */
    public function getDelete(Request $request, $id)
    {
        $status = PackageStatus::find($id);

        if ( ! $status)
        {
            return $this->redirectBackWithError('Package status not found.');
        }

        if ( ! $status->delete())
        {
            return $this->redirectBackWithError('Package status delete failed.');
        }

        return $this->redirectBackWithSuccess('Package status deleted.');
    }
}
