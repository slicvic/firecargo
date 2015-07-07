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
        $couriers = Courier::allByCurrentCompany();
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

        // Validate input
        $validator = Validator::make($input, Courier::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create courier
        Courier::create($input);

        Flash::success('Courier created.');
        return redirect('couriers');
    }

    /**
     * Shows the form for editing a status.
     */
    public function getEdit($id)
    {
        $courier = Courier::findOrFailByIdAndCurrentCompany($id);
        return view('couriers.form', ['courier' => $courier]);
    }

    /**
     * Updates a specific status.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, Courier::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update courier
        $courier = Courier::findOrFailByIdAndCurrentCompany($id);
        $courier->update($input);

        Flash::success('Courier updated.');
        return redirect()->back();
    }

    /**
     * Deletes a specific courier.
     */
    public function getDelete(Request $request, $id)
    {
        $courier = Courier::findByIdAndCurrentCompany($id);

        if ($courier) {
            $courier->delete();
            Flash::success('Courier deleted.');
        }
        else {
            Flash::error('Courier not found.');
        }

        return redirect()->back();
    }
}
