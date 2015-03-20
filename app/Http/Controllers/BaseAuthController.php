<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

abstract class BaseAuthController extends BaseController {
    protected $layout = 'layouts.member';
    protected $auth;
    protected $user;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->user = $auth->user();
        $this->middleware('auth');
    }
}
