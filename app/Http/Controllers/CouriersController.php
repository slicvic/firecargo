<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Courier;
use App\Helpers\Flash;

/**
 * CouriersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CouriersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of couriers.
     */
    public function getIndex()
    {
        $couriers = Courier::allByCurrentSiteId();
        return view('couriers.index', ['couriers' => $couriers]);
    }

    /**
     * Shows the form for creating a new courier.
     */
    public function getCreate()
    {
        return view('couriers.form', ['courier' => new Courier()]);
    }

    /**
     * Creates a new courier.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Courier::$rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        Courier::create($input);

        Flash::success('Record created successfully.');

        return redirect('couriers');
    }

    /**
     * Shows the form for editing a status.
     */
    public function getEdit($id)
    {
        $courier = Courier::findOrFailByIdAndCurrentSiteId($id);
        return view('couriers.form', ['courier' => $courier]);
    }

    /**
     * Updates a specific status.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, Courier::$rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $courier = Courier::findOrFailByIdAndCurrentSiteId($id);
        $courier->update($input);

        Flash::success('Record updated successfully.');

        return redirect('couriers');
    }

    /**
     * Deletes a specific courier.
     */
    public function getDelete(Request $request, $id)
    {
        $courier = Courier::findByIdAndCurrentSiteId($id);

        if ($courier)
        {
            $courier->softDelete();
            Flash::success('Record deleted successfully.');
        }
        else
        {
            Flash::error('Record not found.');
        }

        return redirect('couriers');
    }
}
