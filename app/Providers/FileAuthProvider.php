<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use App\Providers\Extensions\FileUserProvider;

class FileAuthProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('file-auth', function($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new FileUserProvider($this->app['hash']);
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}