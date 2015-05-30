<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\PackageStatus;
use App\Helpers\Flash;

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
        $validator = Validator::make($input, PackageStatus::$rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        PackageStatus::create($input);

        Flash::success('Record created successfully.');

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
        $validator = Validator::make($input, PackageStatus::$rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $status = PackageStatus::findOrFailByIdAndCurrentSiteId($id);
        $status->update($input);

        Flash::success('Record updated successfully.');

        return redirect('package-statuses');
    }

    /**
     * Deletes a specific status.
     */
    public function getDelete(Request $request, $id)
    {
        $status = PackageStatus::findByIdAndCurrentSiteId($id);

        if ($status)
        {
            $status->softDelete();
            Flash::success('Record deleted successfully.');
        }
        else
        {
            Flash::error('Record not found.');
        }

        return redirect('package-statuses');
    }
}
