<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Container;
use App\Models\Warehouse;
use App\Helpers\Flash;

/**
 * ContainersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ContainersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of warehouse groups.
     */
    public function getIndex(Request $request)
    {
        $input['limit'] = $request->input('limit', 10);
        $input['sortby'] = $request->input('sortby', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');

        $criteria['q'] = $input['q'];
        $criteria['company_id'] = $this->user->company_id;
        $containers = Container::search($criteria, $input['sortby'], $input['order'], $input['limit']);

        return view('containers.index', [
            'containers' => $containers,
            'input' => $input,
            'orderInverse' => ($input['order'] === 'asc' ? 'desc' : 'asc'),
        ]);
    }

    /**
     * Shows the form for creating a warehouse.
     */
    public function getCreate()
    {
        return view('containers.form', ['container' => new Container]);
    }

    /**
     * Creates a new container.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();
        $input['container']['company_id'] = $this->user->company_id;

        // Validate input
        $rules = Container::$rules;
        $validator = Validator::make($input['container'], $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create container
        $container = Container::create($input['container']);

        // Assign warehouses
        Warehouse::whereIn('id', explode("\n", $input['warehouse_ids']))
            ->update(['container_id' => $container->id]);

        Flash::success('Container created.');
        return redirect('containers');
    }

    /**
     * Shows the form for editing a container.
     */
    public function getEdit($id)
    {
        $container = Container::findOrFailByIdAndCurrentCompany($id);
        return view('containers.form', ['container' => $container]);
    }

    /**
     * Updates a specific container.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $rules = Container::$rules;
        $rules['tracking_number'] .= ',' . $id;
        unset($rules['company_id']);

        $validator = Validator::make($input['container'], $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update container
        $container = Container::findOrFailByIdAndCurrentCompany($id);
        $container->update($input['container']);

        // Assign warehouses
        Warehouse::where('container_id', $container->id)
            ->update(['container_id' => NULL]);
        Warehouse::whereIn('id', explode("\n", $input['warehouse_ids']))
            ->update(['container_id' => $container->id]);

        Flash::success('Container updated.');
        return redirect()->back();
    }

}
