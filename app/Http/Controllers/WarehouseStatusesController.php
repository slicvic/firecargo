<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\WarehouseStatus;
use App\Helpers\Flash;

class WarehouseStatusesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Displays a list of statuses.
     */
    public function getIndex()
    {
        $statuses = WarehouseStatus::where('company_id', '=', Auth::user()->company_id)->get();
        return $this->getPageView('warehouse_statuses.index', ['statuses' => $statuses]);
    }

    /**
     * Shows the form for creating a new status.
     */
    public function getCreate()
    {
        return $this->getPageView('warehouse_statuses.form', ['status' => new WarehouseStatus()]);
    }

    /**
     * Stores a newly created status.
     */
    public function postStore(Request $request)
    {
        $validator = Validator::make($input = $request->all(), WarehouseStatus::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $input['company_id'] = Auth::user()->company_id;
        WarehouseStatus::create($input);

        return redirect('ws');
    }

    /**
     * Shows the form for editing a status.
     */
    public function getEdit($id)
    {
        $status = WarehouseStatus::findOrFail($id);
        return $this->getPageView('warehouse_statuses.form', ['status' => $status]);
    }

    /**
     * Updates the specified status.
     */
    public function postUpdate(Request $request, $id)
    {
        $status = WarehouseStatus::findOrFail($id);

        $validator = Validator::make($input = $request->all(), WarehouseStatus::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $status->update($input);

        return redirect('ws');
    }
}
