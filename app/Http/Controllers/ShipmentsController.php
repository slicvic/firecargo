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

        $this->middleware('agent');
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
        $criteria['company_id'] = $this->authUser->isAdmin() ? NULL : $this->authUser->company_id;

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
        $shipment = Shipment::findMine($id);

        if ( ! $shipment)
        {
            return $this->redirectBackWithError('Shipment not found.');
        }

        return view('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Shows the form for creating a shipment.
     *
     * @return Response
     */
    public function getCreate()
    {
        // Retrive all packages pending shipment
        $packages = Package::allPendingShipmentByCompanyId($this->authUser->company_id);

        // Group them by warehouse
        $groupedPackages = [];

        foreach ($packages as $package)
        {
            $groupedPackages[$package->warehouse_id][] = $package;
        }

        return view('shipments.edit', [
            'shipment' => new Shipment,
            'groupedPackages' => $groupedPackages
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
        try
        {
            $shipment = new Shipment;

            // Validate input and save shipment

            if ( ! $this->validateAndSave($request, $shipment))
            {
                return response()->json(['error' => Flash::view('Shipment creation failed, please try again.')], 500);
            }

            Flash::success('Shipment created.');

            return response()->json(['redirect_url' => '/shipments/show/' . $shipment->id]);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }
    }

    /**
     * Shows the form for editing a shipment.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        // Lookup shipment
        $shipment = Shipment::findMine($id);

        if ( ! $shipment)
        {
            return $this->redirectBackWithError('Shipment not found.');
        }

        // Group packages by warehouse
        $groupedPackages = [];

        // Retrieve the current packages in the shipment
        foreach ($shipment->packages as $package)
        {
            $groupedPackages[$package->warehouse_id][] = $package;
        }

        // Retrieve all other packages pending shipment
        $packages = Package::allPendingShipmentByCompanyId($this->authUser->company_id);

        foreach ($packages as $package)
        {
            $groupedPackages[$package->warehouse_id][] = $package;
        }

        return view('shipments.edit', [
            'shipment' =>  $shipment,
            'groupedPackages' => $groupedPackages
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
        try
        {
            // Lookup shipment

            $shipment = Shipment::findMine($id);

            if ( ! $shipment)
            {
                return response()->json(['error' => Flash::view('Shipment not found.')], 404);
            }

            // Validate input and save shipment

            if ( ! $this->validateAndSave($request, $shipment))
            {
                return response()->json(['error' => Flash::view('Shipment update failed, please try again.')], 500);
            }

            Flash::success('Shipment updated.');

            return response()->json(['redirect_url' => '/shipments/edit/' . $shipment->id]);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }
    }

    /**
     * Prepares and validates the input for creating and updating a shipment.
     *
     * @param  Request  $request
     * @param  Shipment $shipment
     * @return array
     * @throws ValidationException
     */
    private function validateAndSave(Request $request, Shipment $shipment)
    {
        $input = $request->only('shipment', 'packages');

        // Validate input

        $rules = [
            'departure_date' => 'required',
            'reference_number' => 'required',
            'carrier' => 'required|min:3',
        ];

        $validator = Validator::make($input['shipment'], $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }

        // Create new carrier if necessary

        if (empty($input['shipment']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['shipment']['carrier']]);

            $input['shipment']['carrier_id'] = $carrier->id;
        }

        // Save shipment

        $shipment->reference_number = $input['shipment']['reference_number'];
        $shipment->departed_at = date('Y-m-d H:i:s', strtotime($input['shipment']['departure_date']));
        $shipment->carrier_id = $input['shipment']['carrier_id'];

        if ( ! $shipment->save())
        {
            return FALSE;
        }

        // Save packages
        $shipment->syncPackages($input['packages'] ? array_keys($input['packages']) : []);

        return TRUE;
    }
}
