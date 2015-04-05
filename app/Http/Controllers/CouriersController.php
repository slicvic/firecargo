<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Courier;
use App\Helpers\Flash;

class CouriersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Displays a list of couriers.
     */
    public function getIndex()
    {
        $couriers = Courier::all();
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
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        Courier::create($input);

        Flash::success('Saved');

        return redirect('couriers');
    }

    /**
     * Shows the form for editing a status.
     */
    public function getEdit($id)
    {
        $courier = Courier::findOrFailByIdAndSiteId($id, $this->user->site_id);
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
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $courier = Courier::findOrFailByIdAndSiteId($id, $this->user->site_id);
        $courier->update($input);

        Flash::success('Saved');

        return redirect('couriers');
    }
}
