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
        $this->middleware('admin');
    }

    /**
     * Shows a list of sites.
     */
    public function getIndex()
    {
        $sites = Site::all();
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
        $input = $request->only('name', 'company_id');

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
        $site = Site::findOrFail($id);
        return view('sites.form', ['site' => $site]);
    }

    /**
     * Updates a specific site.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name', 'company_id');

        // Validate input
        $this->validate($input, Site::$rules);

        // Update site
        Site::updateWhereId($id, $input);

        return $this->redirectBackWithSuccess('Site updated.');
    }
}
