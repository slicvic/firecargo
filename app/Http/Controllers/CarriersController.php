<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Auth;

use App\Models\Carrier;
use App\Helpers\Flash;

/**
 * CarriersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CarriersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Shows a list of carriers.
     */
    public function getIndex()
    {
        $carriers = Carrier::all();
        return view('carriers.index', ['carriers' => $carriers]);
    }

    /**
     * Shows the form for creating a new carrier.
     */
    public function getCreate()
    {
        return view('carriers.form', ['carrier' => new Carrier]);
    }

    /**
     * Creates a new carrier.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, Carrier::$rules);

        // Create carrier
        Carrier::create($input);

        return $this->redirectWithSuccess('carriers', 'Carrier created.');
    }

    /**
     * Shows the form for editing a carrier.
     */
    public function getEdit($id)
    {
        $carrier = Carrier::findOrFail($id);
        return view('carriers.form', ['carrier' => $carrier]);
    }

    /**
     * Updates a specific carrier.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, Carrier::$rules);

        // Update carrier
        $carrier = Carrier::findOrFail($id);
        $carrier->update($input);

        return $this->redirectBackWithSuccess('Carrier updated.');
    }

    /**
     * Deletes a specific carrier.
     */
    public function getDelete(Request $request, $id)
    {
        if (Carrier::deleteByIdAndCurrentCompany($id)) {
            return $this->redirectBackWithSuccess(sprintf('Carrier "%s (%s)" deleted.', $carrier->name, $carrier->id));
        }

        return $this->redirectBackWithError('Carrier delete failed.');
    }
}
