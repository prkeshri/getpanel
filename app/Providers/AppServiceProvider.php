<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $basic_config=Config::get('basic');
        $config=$basic_config[$basic_config['save_in']];
        if($basic_config['save_in']==='folder')
        {
            Config::set('filesystems.disks.'.$config['filesystem_key'],[
                'driver' => 'local',
                'root' => $config['path'],
            ]);
        }
        else if($basic_config['save_in']=='database')
        {
            if(is_array($config['connection']))
            {
                Config::set('database.connections.'.$config['connection_key'],
                    $config['connection']);
            }
        }

        view()->composer('*', function ($view) {

            $message_type=\Session::get('message_type');
            $message=\Session::get('message');
            $other_data=\Session::get('other_data');
            $view->with(['message_type'=>$message_type,'message'=>$message,'other_data'=>$other_data]);
        
        });
        require_once(__DIR__.'/../Util/helpers.php');
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
