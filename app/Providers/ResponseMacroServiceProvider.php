<?php namespace App\Providers;

use Response;
use Illuminate\Support\ServiceProvider;

use App\Session\Flash;

/**
 * ResponseMacroServiceProvider
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ResponseMacroServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonFlash', function($message, $status = 200)
        {
            $data['title'] = ($status >= 200 && $status < 300) ? trans('messages.success_msg_title') : trans('messages.error_msg_title');
            $date['message'] = Flash::normalizeMessage($message);

            return Response::json($data, $status);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
