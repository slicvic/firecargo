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
        return view('sites.form', ['site' => new Site]);
    }

    /**
     * Creates a new site.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, Site::$rules);

        // Create site
        Site::create($input);

        return $this->redirectWithSuccess('sites', 'Site created.');
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
        $input['company_id'] = ($this->user->isAdmin()) ? $input['company_id'] : $this->user->company_id;

        // Validate input
        $this->validate($input, Site::$rules);

        // Update site
        $site = Site::findOrFailByIdAndCurrentCompany($id);
        $site->update($input);

        return $this->redirectBackWithSuccess('Site updated.');
    }
}
