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
        $input['limit'] = $request->input('limit', 10);
        $input['sort'] = $request->input('sort', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');

        // Perform search criteria
        $criteria['q'] = $input['q'];

        if ( ! $this->authUser->isAdmin())
        {
            $criteria['company_id'] = $this->authUser->company_id;
        }

        // Run query
        $shipments = Shipment::search($criteria, $input['sort'], $input['order'], $input['limit']);

        return view('shipments.index', [
            'shipments' => $shipments,
            'input' => $input,
            'oppositeOrder' => ($input['order'] === 'asc' ? 'desc' : 'asc'),
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
        $shipment = Shipment::findOrFailByIdAndCurrentUserCompanyId($id);

        return view('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Shows the form for creating a shipment.
     *
     * @return Response
     */
    public function getCreate()
    {
        $nestablePackages = [];

        // Get all packages not assigned to a shipment
        $packages = Package::allPendingShipmentByCompanyId($this->authUser->company_id);

        foreach ($packages as $package)
        {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        return view('shipments.edit', [
            'shipment' => new Shipment,
            'nestablePackages' => $nestablePackages
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
        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidateInput($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Create shipment
        $shipment = new Shipment;
        $shipment->reference_number = $input['shipment']['reference_number'];
        $shipment->departed_at = date('Y-m-d H:i:s', strtotime($input['shipment']['departure_date']));
        $shipment->carrier_id = $input['shipment']['carrier_id'];
        $shipment->company_id = $this->authUser->company_id;

        if ( ! $shipment->save())
        {
            return response()->json(['error' => Flash::view('Shipment creation failed, please try again.')], 500);
        }

        // Update packages
        if ($input['packages'])
        {
            $shipment->syncPackages(array_keys($input['packages']), FALSE);
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
        $shipment = Shipment::findOrFailByIdAndCurrentUserCompanyId($id);
        $nestablePackages = [];

        // Get the current packages in the shipment
        foreach ($shipment->packages as $package)
        {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        // Get all other packages not assigned to a shipment
        $packages = Package::allPendingShipmentByCurrentUserCompany();

        foreach ($packages as $package)
        {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        return view('shipments.edit', [
            'shipment' =>  $shipment,
            'nestablePackages' => $nestablePackages
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
        // Make sure shipment exists before proceeding
        $shipment = Shipment::findByIdAndCurrentUserCompanyId($id);

        if ( ! $shipment)
        {
            return response()->json(['error' => Flash::view('Shipment not found.')], 404);
        }

        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidateInput($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Update shipment
        $shipment->reference_number = $input['shipment']['reference_number'];
        $shipment->departed_at = date('Y-m-d H:i:s', strtotime($input['shipment']['departure_date']));
        $shipment->carrier_id = $input['shipment']['carrier_id'];
        $shipment->company_id = $this->authUser->company_id;
        $shipment->save();

        // Update packages
        $shipment->syncPackages($input['packages'] ? array_keys($input['packages']) : []);

        Flash::success('Shipment updated.');

        return response()->json(['redirect_url' => '/shipments/edit/' . $shipment->id]);
    }

    /**
     * Prepares and validates the input for creating and updating a shipment.
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function prepareAndValidateInput(Request $request)
    {
        $input = $request->only('shipment', 'packages');

        // Prepare rules
        $rules = [
            'departure_date' => 'required',
            'reference_number' => 'required',
            'carrier_name' => 'required|min:3',
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

        return $input;
    }
}
