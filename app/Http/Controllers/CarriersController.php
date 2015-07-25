<?php namespace App\Http\Controllers;

use Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Carrier;
use Flash;

/**
 * CarriersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CarriersController extends BaseAuthController {

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
     * Shows a list of carriers.
     *
     * @return Response
     */
    public function getIndex()
    {
        $carriers = Carrier::all();

        return view('carriers.index', ['carriers' => $carriers]);
    }

    /**
     * Shows the form for creating a new carrier.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('carriers.edit', ['carrier' => new Carrier]);
    }

    /**
     * Creates a new carrier.
     *
     * @param  Request  $request
     * @return Redirector
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
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $carrier = Carrier::find($id);

        if ( ! $carrier)
        {
            return $this->redirectBackWithError('Carrier not found.');
        }

        return view('carriers.edit', ['carrier' => $carrier]);
    }

    /**
     * Updates a specific carrier.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name');

        // Validate input
        $this->validate($input, Carrier::$rules);

        // Update carrier
        $carrier = Carrier::find($id);

        if ( ! $carrier)
        {
            return $this->redirectBackWithError('Carrier not found.');
        }

        $carrier->update($input);

        return $this->redirectBackWithSuccess('Carrier updated.');
    }

    /**
     * Deletes a specific carrier.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function getDelete(Request $request, $id)
    {
        $carrier = Carrier::find($id);

        if ( ! $carrier)
        {
            return $this->redirectBackWithError('Carrier not found.');
        }

        if ( ! $carrier->delete())
        {
            return $this->redirectBackWithError('Carrier delete failed.');
        }

        return $this->redirectBackWithSuccess('Carrier deleted.');
    }

    /**
     * Retrieves a list of carriers for a jquery autocomplete field.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAjaxAutocomplete(Request $request)
    {
        $input = $request->only('term');
        $response = [];

        if (strlen($input['term']) < 2)
        {
            // Return nothing
            return response()->json($response);
        }

        foreach(Carrier::autocompleteSearch($input['term']) as $carrier)
        {
            $response[] = [
                'id'    => $carrier->id,
                'label' => $carrier->name,
                'prefix' => $carrier->prefix
            ];
        }

        return response()->json($response);
    }
}
