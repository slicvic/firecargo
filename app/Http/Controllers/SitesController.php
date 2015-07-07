<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Site;
use App\Helpers\Flash;

/**
 * SitesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class SitesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent', ['only' => ['getIndex', 'getEdit', 'postUpdate']]);
        $this->middleware('admin', ['except' => ['getIndex', 'getEdit', 'postUpdate']]);
    }

    /**
     * Shows a list of sites.
     */
    public function getIndex()
    {
        $sites = $this->user->isAdmin() ? Site::all() : Site::allByCurrentCompany();
        return view('sites.index', ['sites' => $sites]);
    }

    /**
     * Shows the form for creating a new site.
     */
    public function getCreate()
    {
        return view('sites.form', ['site' => new Site()]);
    }

    /**
     * Creates a new site.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, Site::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create site
        Site::create($input);

        Flash::success('Site created.');
        return redirect('sites');
    }

    /**
     * Shows the form for editing a site.
     */
    public function getEdit($id)
    {
        $site = Site::findOrFailByIdAndCurrentCompany($id);
        return view('sites.form', ['site' => $site]);
    }

    /**
     * Updates a specific site.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $rules = Site::$rules;
        unset($rules['company_id']);
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update site
        $site = Site::findOrFailByIdAndCurrentCompany($id);
        $site->update($input);

        Flash::success('Site updated.');
        return redirect()->back();
    }
}
