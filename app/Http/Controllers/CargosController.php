<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Cargo;
use App\Models\Carrier;
use App\Models\Package;
use App\Models\Warehouse;
use App\Helpers\Flash;

/**
 * CargosController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CargosController extends BaseAuthController {

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
     * Shows a list of cargos.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $input['limit'] = $request->input('limit', 10);
        $input['sortby'] = $request->input('sortby', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');

        $criteria['q'] = $input['q'];
        $criteria['company_id'] = $this->user->company_id;
        $cargos = Cargo::search($criteria, $input['sortby'], $input['order'], $input['limit']);

        return view('cargos.index', [
            'cargos' => $cargos,
            'input' => $input,
            'orderInverse' => ($input['order'] === 'asc' ? 'desc' : 'asc'),
        ]);
    }

    /**
     * Shows the form for creating a cargo.
     *
     * @return Response
     */
    public function getCreate()
    {
        $nestablePackages = [];

        // Get all packages not assigned to a cargo
        $packages = Package::allPendingCargoByCurrentUserCompany();

        foreach ($packages as $package)
        {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        return view('cargos.form', [
            'cargo' => new Cargo,
            'nestablePackages' => $nestablePackages
        ]);
    }

    /**
     * Creates a new cargo.
     *
     * @return JsonResponse
     */
    public function postStore(Request $request)
    {
        $input = $request->only('cargo', 'packages');

        // Prepare rules
        $rules =  [
            'departed_at' => 'required',
            'receipt_number' => 'required',
            'carrier_id' => 'required_without:carrier_id',
            'carrier_name' => 'required_without:carrier_name',
        ];

        // Validate input
        $validator = Validator::make($input['cargo'], $rules);

        if ($validator->fails())
        {
            return response()->json(['error' => Flash::view($validator)], 400);
        }

        // Create new carrier if necessary
        if (empty($input['cargo']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['cargo']['carrier_name']]);
            $input['cargo']['carrier_id'] = $carrier->id;
        }

        // Not a real attribute
        unset($input['cargo']['carrier_name']);

        // Create cargo
        $cargo = new Cargo($input['cargo']);
        $cargo->company_id = $this->user->company_id;

        if ( ! $cargo->save())
        {
            return response()->json(['error' => Flash::view('Cargo creation failed, please try again.')], 500);
        }

        // Update packages
        if ($input['packages']) {
            Package::whereIn('id', array_keys($input['packages']))->update(['cargo_id' => $cargo->id]);
        }

        Flash::success('Cargo created.');
        return response()->json(['redirect_to' => '/cargos/show/' . $cargo->id]);
    }

    /**
     * Shows the form for editing a cargo.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $cargo = Cargo::findOrFailByIdAndCurrentUserCompanyId($id);
        $nestablePackages = [];

        // Get the current packages in the cargo
        foreach ($cargo->packages as $package)
        {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        // Get all other packages not assigned to a cargo
        $packages = Package::allPendingCargoByCurrentUserCompany();
        foreach ($packages as $package)
        {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        return view('cargos.form', [
            'cargo' =>  $cargo,
            'nestablePackages' => $nestablePackages
        ]);
    }

    /**
     * Updates a specific cargo.
     *
     * @return JsonResponse
     */
    public function postUpdate(Request $request, $id)
    {


        // Create cargo
        $cargo = Cargo::findByIdAndCurrentUserCompanyId($id);

        if ( ! $cargo)
        {
            return response()->json(['error' => Flash::view('Cargo not found.')], 404);
        }

        // Create new carrier if necessary
        if (empty($input['cargo']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['cargo']['carrier_name']]);
            $input['cargo']['carrier_id'] = $carrier->id;
        }

        // Not a real attribute
        unset($input['cargo']['carrier_name']);

        // Update packages
        Package::where(['cargo_id' => $cargo->id])->update(['cargo_id' => NULL]);

        if ($input['packages'])
        {
            Package::whereIn('id', array_keys($input['packages']))->update(['cargo_id' => $cargo->id]);
        }

        Flash::success('Cargo updated.');
        return response()->json(['redirect_to' => '/cargos/edit/' . $cargo->id]);
    }

    /**
     * Prepares and validates the input for creating and updating a cargo.
     *
     * @param  Request  $request
     * @return array|JsonResponse  An input array or JsonResponse
     */
    private function prepareAndValidateInput(Request $request)
    {
        $input = $request->only('cargo', 'packages');

        // Prepare rules
        $rules = [
            'departed_at' => 'required',
            'receipt_number' => 'required',
            'carrier_id' => 'required_without:carrier_id',
            'carrier_name' => 'required_without:carrier_name',
        ];

        // Validate input
        $validator = Validator::make($input['cargo'], $rules);

        if ($validator->fails())
        {
            return response()->json(['error' => Flash::view($validator)], 400);
        }

        // Create new carrier if necessary
        if (empty($input['cargo']['carrier_id'])) {
            $carrier = Carrier::firstOrCreate(['name' => $input['cargo']['carrier_name']]);
            $input['cargo']['carrier_id'] = $carrier->id;
        }

        // Not a real attribute
        unset($input['cargo']['carrier_name']);

        return $input;
    }
}
