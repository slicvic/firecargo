<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Site;
use App\Helpers\Flash;

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
        return view('sites.form', ['site' => new Site()]);
    }

    /**
     * Creates a new site.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Site::$rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        Site::create($input);

        Flash::success('Record created successfully.');

        return redirect('sites');
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
        $input = $request->all();
        $validator = Validator::make($input, Site::$rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $site = Site::findOrFail($id);
        $site->update($input);

        Flash::success('Record updated successfully.');

        return redirect('sites');
    }
}
