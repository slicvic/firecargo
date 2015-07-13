<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Cargo;
use App\Models\Carrier;
use App\Models\Package;
use App\Models\Warehouse;
use App\Helpers\Flash;
use App\Exceptions\ValidationException;

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
        // Prepare input
        $input['limit'] = $request->input('limit', 10);
        $input['sort'] = $request->input('sort', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');

        // Perform query
        $criteria['q'] = $input['q'];
        $criteria['company_id'] = $this->user->company_id;
        $cargos = Cargo::search($criteria, $input['sort'], $input['order'], $input['limit']);

        return view('cargos.index', [
            'cargos' => $cargos,
            'input' => $input,
            'orderInverse' => ($input['order'] === 'asc' ? 'desc' : 'asc'),
        ]);
    }

    /**
     * Shows a specific cargo.
     *
     * @return Response
     */
    public function getShow(Request $request, $id)
    {
        $cargo = Cargo::findOrFailByIdAndCurrentUserCompanyId($id);

        return view('cargos.show', ['cargo' => $cargo]);
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

        return view('cargos.edit', [
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
        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidateInput($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Create cargo
        $cargo = new Cargo($input['cargo']);
        $cargo->company_id = $this->user->company_id;

        if ( ! $cargo->save())
        {
            return response()->json(['error' => Flash::view('Cargo creation failed, please try again.')], 500);
        }

        // Update packages
        if ($input['packages'])
        {
            $cargo->syncPackages(array_keys($input['packages']), FALSE);
        }

        Flash::success('Cargo created.');

        return response()->json(['redirect_url' => '/cargos/show/' . $cargo->id]);
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

        return view('cargos.edit', [
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
        // Make sure cargo exists before proceeding
        $cargo = Cargo::findByIdAndCurrentUserCompanyId($id);

        if ( ! $cargo)
        {
            return response()->json(['error' => Flash::view('Cargo not found.')], 404);
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

        // Update cargo
        $cargo->update($input['cargo']);

        // Update packages
        $cargo->syncPackages($input['packages'] ? array_keys($input['packages']) : []);

        Flash::success('Cargo updated.');

        return response()->json(['redirect_url' => '/cargos/edit/' . $cargo->id]);
    }

    /**
     * Prepares and validates the input for creating and updating a cargo.
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function prepareAndValidateInput(Request $request)
    {
        $input = $request->only('cargo', 'packages');

        // Prepare rules
        $rules = [
            'departed_at' => 'required',
            'receipt_number' => 'required',
            'carrier_id' => 'required_without:carrier_name',
            'carrier_name' => 'required_without:carrier_id',
        ];

        // Validate input
        $validator = Validator::make($input['cargo'], $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
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
