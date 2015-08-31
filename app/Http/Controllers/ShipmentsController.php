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
     * Show a list of shipments.
     *
     * @param  Request  $request
     * @return View
     */
    public function getIndex(Request $request)
    {
        $params['limit'] = 10;
        $params['sort'] = $request->input('sort', 'id');
        $params['order'] = $request->input('order', 'desc');
        $params['search'] = $request->input('search');

        $criteria['search'] = $params['search'];
        $criteria['company_id'] = $this->user->isAdmin() ? NULL : $this->user->company_id;

        $shipments = Shipment::search($criteria, $params['sort'], $params['order'], $params['limit']);

        return view('admin.shipments.index', [
            'shipments' => $shipments,
            'params' => $params
        ]);
    }

    /**
     * Show a specific shipment.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return View
     */
    public function getShow(Request $request, $id)
    {
        $shipment = Shipment::findMineOrFail($id);

        return view('admin.shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Show the form for creating a new shipment.
     *
     * @return View
     */
    public function getCreate()
    {
        // Retrieve all unprocessed packages
        $unprocessed = Package::mine()->unprocessed()
            ->with('type', 'customer')
            ->orderBy('warehouse_id', 'DESC')
            ->orderBy('id', 'ASC')
            ->get();

        return view('admin.shipments.form', [
            'shipment' => new Shipment,
            'packages' => $unprocessed
        ]);
    }

    /**
     * Create a new shipment.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postStore(Request $request)
    {
        $shipment = new Shipment;

        $this->validateAndSave($request, $shipment);

        Flash::success('Shipment created.');

        return response()->json(['redirect_url' => '/shipment/' . $shipment->id]);
    }

    /**
     * Shos the form for editing a shipment.
     *
     * @param  int  $id
     * @return View
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

        return view('admin.shipments.form', [
            'shipment' =>  $shipment,
            'packages' => $assigned->merge($unprocessed)
        ]);
    }

    /**
     * Update a specific shipment.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return JsonResponse
     */
    public function postUpdate(Request $request, $id)
    {
        $shipment = Shipment::findMine($id);

        if ( ! $shipment)
        {
            return response()->jsonError('Shipment not found.', 404);
        }

        $this->validateAndSave($request, $shipment);

        Flash::success('Shipment updated.');

        return response()->json(['redirect_url' => "/shipment/{$shipment->id}/edit"]);
    }

    /**
     * Prepare and validate the given input and apply it to the given shipment.
     *
     * @param  Request  $request
     * @param  Shipment $shipment
     * @return void
     * @throws ValidationException
     */
    private function validateAndSave(Request $request, Shipment $shipment)
    {
        $input = $request->only('shipment', 'pieces');

        $rules = [
            'departure_date'   => 'required',
            'reference_number' => 'required',
            'carrier_name'     => Carrier::$rules['name']
        ];

        // Validate input
        $validator = Validator::make($input['shipment'], $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }

        // Create new carrier if no carrier ID provided
        if (empty($input['shipment']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['shipment']['carrier_name']]);

            $input['shipment']['carrier_id'] = $carrier->id;
        }

        // Save shipment
        $shipment->reference_number = $input['shipment']['reference_number'];
        $shipment->departed_at = $input['shipment']['departure_date'];
        $shipment->carrier_id = $input['shipment']['carrier_id'];
        $shipment->save();

        // Save packages
        $shipment->syncPackages($input['pieces'] ? array_keys($input['pieces']) : []);
    }
}
