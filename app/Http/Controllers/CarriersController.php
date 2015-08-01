<?php namespace App\Http\Controllers;

use Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Carrier;

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
        $carrier = Carrier::findOrFail($id);

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
        Carrier::findOrFail($id)->update($input);

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
        if ( ! Carrier::findOrFail($id)->delete())
        {
            return $this->redirectBackWithError('Carrier deletion failed.');
        }

        return $this->redirectBackWithSuccess('Carrier deleted.');
    }

    /**
     * Retrieves a list of carriers for an ajax autocomplete field.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAjaxAutocomplete(Request $request)
    {
        $input = $request->only('term');

        // Validate input
        if (strlen($input['term']) < 2)
        {
            return response()->json([]);
        }

        // Search
        $carriers = Carrier::autocompleteSearch($input['term']);

        $response = [];

        foreach($carriers as $carrier)
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
