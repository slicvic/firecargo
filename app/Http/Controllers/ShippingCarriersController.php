<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\ShippingCarrier;
use App\Helpers\Flash;

class ShippingCarriersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Displays a list of carriers.
     */
    public function getIndex()
    {
        $carriers = ShippingCarrier::where('company_id', '=', Auth::user()->company_id)->get();
        return $this->getPageView('shipping_carriers.index', ['carriers' => $carriers]);
    }

    /**
     * Shows the form for creating a new carrier.
     */
    public function getCreate()
    {
        return $this->getPageView('shipping_carriers.form', ['carrier' => new ShippingCarrier()]);
    }

    /**
     * Stores a newly created carrier.
     */
    public function postStore(Request $request)
    {
        $validator = Validator::make($input = $request->all(), ShippingCarrier::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $input['company_id'] = Auth::user()->company_id;
        ShippingCarrier::create($input);

        return redirect('carriers');
    }

    /**
     * Shows the form for editing a status.
     */
    public function getEdit($id)
    {
        $carrier = ShippingCarrier::findOrFail($id);
        return $this->getPageView('shipping_carriers.form', ['carrier' => $carrier]);
    }

    /**
     * Updates the specified status.
     */
    public function postUpdate(Request $request, $id)
    {
        $carrier = ShippingCarrier::findOrFail($id);

        $validator = Validator::make($input = $request->all(), ShippingCarrier::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $carrier->update($input);

        return redirect('carriers');
    }
}
