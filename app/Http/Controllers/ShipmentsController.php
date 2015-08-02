<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Shipment;
use App\Models\Carrier;
use App\Models\Package;
use App\Models\Warehouse;
use Flash;
use App\Exceptions\ValidationException;
use App\Http\ToastrJsonResponse;

/**
 * ShipmentsController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ShipmentsController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('auth.agentOrHigher');
    }

    /**
     * Shows a list of shipments.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $params['limit'] = $request->input('limit', 10);
        $params['sort'] = $request->input('sort', 'id');
        $params['order'] = $request->input('order', 'desc');
        $params['search'] = $request->input('search');

        $criteria['search'] = $params['search'];
        $criteria['company_id'] = $this->user->isAdmin() ? NULL : $this->user->company_id;

        $shipments = Shipment::search($criteria, $params['sort'], $params['order'], $params['limit']);

        return view('shipments.index', [
            'shipments' => $shipments,
            'params' => $params
        ]);
    }

    /**
     * Shows a specific shipment.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function getShow(Request $request, $id)
    {
        $shipment = Shipment::findMineOrFail($id);

        return view('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Shows the form for creating a new shipment.
     *
     * @return Response
     */
    public function getCreate()
    {
        // Retrieve all unprocessed packages
        $unprocessed = Package::mine()->unprocessed()
            ->with('type', 'customer')
            ->orderBy('warehouse_id', 'DESC')
            ->orderBy('id', 'ASC')
            ->get();

        return view('shipments.edit', [
            'shipment' => new Shipment,
            'packages' => $unprocessed
        ]);
    }

    /**
     * Creates a new shipment.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postStore(Request $request)
    {
        $shipment = new Shipment;

        // Validate input and save shipment
        if ( ! $this->validateAndSave($request, $shipment))
        {
            return ToastrJsonResponse::error('Shipment creation failed, please try again.', 500);
        }

        Flash::success('Shipment created.');

        return response()->json(['redirect_url' => '/shipments/show/' . $shipment->id]);
    }

    /**
     * Shows the form for editing a shipment.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $shipment = Shipment::findMineOrFail($id);

        // Retrieve packages assigned to this shipment
        $assigned = $shipment->packages()->with('customer', 'type')->get();

        // Retrieve all other unprocessed packages
        $unprocessed = Package::mine()->unprocessed()
            ->with('type', 'customer')
            ->orderBy('warehouse_id', 'DESC')
            ->orderBy('id', 'ASC')
            ->get();

        return view('shipments.edit', [
            'shipment' =>  $shipment,
            'packages' => $assigned->merge($unprocessed)
        ]);
    }

    /**
     * Updates a specific shipment.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return JsonResponse
     */
    public function postUpdate(Request $request, $id)
    {
        // Find shipment
        $shipment = Shipment::findMine($id);

        if ( ! $shipment)
        {
            return ToastrJsonResponse::error('Shipment not found.', 404);
        }

        // Validate input and save shipment
        if ( ! $this->validateAndSave($request, $shipment))
        {
            return ToastrJsonResponse::error('Shipment update failed, please try again.', 500);
        }

        Flash::success('Shipment updated.');

        return response()->json(['redirect_url' => '/shipments/edit/' . $shipment->id]);
    }

    /**
     * Prepares and validates the given input and applies it to the given shipment.
     *
     * @param  Request  $request
     * @param  Shipment $shipment
     * @return array
     * @throws ValidationException
     */
    private function validateAndSave(Request $request, Shipment $shipment)
    {
        $input = $request->only('shipment', 'pieces');

        $rules = [
            'departure_date' => 'required',
            'reference_number' => 'required',
            'carrier_name' => Carrier::$rules['name']
        ];

        // Validate input
        $validator = Validator::make($input['shipment'], $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }

        // Create new carrier if necessary
        if (empty($input['shipment']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['shipment']['carrier_name']]);

            $input['shipment']['carrier_id'] = $carrier->id;
        }

        // Save shipment
        $shipment->reference_number = $input['shipment']['reference_number'];
        $shipment->departed_at = $input['shipment']['departure_date'];
        $shipment->carrier_id = $input['shipment']['carrier_id'];

        if ( ! $shipment->save())
        {
            return FALSE;
        }

        // Save packages
        $shipment->syncPackages($input['pieces'] ? array_keys($input['pieces']) : []);

        return TRUE;
    }
}
