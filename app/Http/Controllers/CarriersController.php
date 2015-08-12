<?php namespace App\Http\Controllers;

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

        $this->middleware('auth.adminOrHigher');
    }

    /**
     * Display a list of carriers.
     *
     * @return View
     */
    public function getIndex()
    {
        $carriers = Carrier::all();

        return view('admin.carriers.index', ['carriers' => $carriers]);
    }

    /**
     * Display the form for creating a new carrier.
     *
     * @return View
     */
    public function getCreate()
    {
        return view('admin.carriers.create', ['carrier' => new Carrier]);
    }

    /**
     * Create a new carrier.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        $this->validate($input, Carrier::$rules);

        Carrier::create($input);

        return $this->redirectWithSuccess('carriers', 'Carrier created.');
    }

    /**
     * Show the form for editing a carrier.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id)
    {
        $carrier = Carrier::findOrFail($id);

        return view('admin.carriers.edit', ['carrier' => $carrier]);
    }

    /**
     * Update a specific carrier.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return RedirectResponse
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name');

        $this->validate($input, Carrier::$rules);

        Carrier::findOrFail($id)->update($input);

        return $this->redirectBackWithSuccess('Carrier updated.');
    }

    /**
     * Delete a specific carrier.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return RedirectResponse
     */
    public function getDelete(Request $request, $id)
    {
        $model = Carrier::findOrFail($id);

        try
        {
            $model->delete();

            return $this->redirectBackWithSuccess('Carrier deleted.');
        }
        catch(Exception $e)
        {
            Log::error($e);

            return $this->redirectBackWithError(trans('messages.error_delete_constraint', ['name' => 'carrier']));
        }
    }

    /**
     * Retrieve a list of carriers for an autocomplete field.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @uses   Ajax
     */
    public function getAutocompleteSearch(Request $request)
    {
        $input = $request->only('term');

        if (strlen($input['term']) < 2)
        {
            return response()->json([]);
        }

        $carriers = Carrier::autocompleteSearch($input['term']);

        $json = [];

        foreach($carriers as $carrier)
        {
            $json[] = [
                'id'    => $carrier->id,
                'label' => $carrier->name,
                'prefix' => $carrier->prefix
            ];
        }

        return response()->json($json);
    }
}
