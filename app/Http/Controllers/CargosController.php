<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Cargo;
use App\Models\Package;
use App\Models\Warehouse;
use App\Helpers\Flash;

/**
 * CargosController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CargosController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of cargos.
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
     */
    public function getCreate()
    {
        $packages = Package::allPendingShipmentByCurrentUserCompanyId();
        $nestablePackages = [];

        foreach ($packages as $package) {
            $nestablePackages[$package->warehouse_id][] = $package;
        }

        return view('cargos.form', [
            'cargo' => new Cargo,
            'nestablePackages' => $nestablePackages
        ]);
    }

    /**
     * Creates a new cargo.
     */
    public function postStore(Request $request)
    {
        $input = $request->only('cargo', 'packages');
        $input['cargo']['company_id'] = $this->user->company_id;

        // Prepare rules
        $rules = Cargo::$rules;
        $rules['carrier_name'] = 'required_without:carrier_id';
        $rules['carrier_id'] = 'required_without:carrier_name';

        // Validate input
        $validator = Validator::make($input['cargo'], $rules);

        if ($validator->fails())
        {
            $message = view('flash_messages.error', [
                'message' => $validator->messages()->all(':message')
            ])->render();

            return response()->json(['status' => 'error', 'message' => $message]);
        }

        // Create new carrier if necessary
        if (empty($input['cargo']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate([
                'name' => $input['cargo']['carrier_name']
            ]);

            $input['cargo']['carrier_id'] = $carrier->id;
        }

        // Not a database field
        unset($input['cargo']['carrier_name']);

        // Create cargo
        $cargo = Cargo::create($input['cargo']);

        // Update packages
        if ($input['packages']) {
            Package::whereIn('id', array_keys($input['packages']))->update(['cargo_id' => $cargo->id]);
        }

        Flash::success('Cargo created.');
        return response()->json(['status' => 'ok', 'redirect_to' => '/cargos/show/' . $cargo->id]);
    }

    /**
     * Shows the form for editing a cargo.
     */
    public function getEdit($id)
    {
        $cargo = Cargo::findOrFailByIdAndCurrentUserCompanyId($id);
        return view('cargos.form', ['cargo' => $cargo]);
    }

    /**
     * Updates a specific cargo.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $rules = Cargo::$rules;
        $rules['receipt_number'] .= ',' . $id;
        unset($rules['company_id']);

        $validator = Validator::make($input['cargo'], $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update cargo
        $cargo = Cargo::findOrFailByIdAndCurrentUserCompanyId($id);
        $cargo->update($input['cargo']);

        // Assign warehouses
        Warehouse::where('container_id', $cargo->id)
            ->update(['container_id' => NULL]);
        Warehouse::whereIn('id', explode("\n", $input['warehouse_ids']))
            ->update(['container_id' => $cargo->id]);

        Flash::success('Cargo updated.');
        return redirect()->back();
    }

}
