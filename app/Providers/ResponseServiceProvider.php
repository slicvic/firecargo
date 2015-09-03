<?php

namespace App\Providers;

use Response;
use Illuminate\Support\ServiceProvider;

use App\Session\FlashMessageNormalizer;

/**
 * ResponseServiceProvider
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ResponseServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonError', function($message, $status = 500)
        {
            $data['title'] = trans('messages.flash_notification_title_error');
            $data['message'] = FlashMessageNormalizer::normalize($message);

            return Response::json($data, $status);
        });

        Response::macro('jsonSuccess', function($message, $status = 200)
        {
            $data['title'] = trans('messages.flash_notification_title_success');
            $data['message'] = FlashMessageNormalizer::normalize($message);

            return Response::json($data, $status);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
