<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\ResponseFactory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::singleton('settings', function () {
            $allSettings = Setting::all();
            $settings = [];
            foreach ($allSettings as $set) {
                if ($set->data_type == 'fileWithPreview' && $set->photo) {
                    $settings +=
                        [
                            $set['key'] => asset($set->photo->path)
                        ];
                } else {
                    $settings +=
                        [
                            $set['key'] => $set['value']
                        ];
                }
            }
            return $settings;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // adding faunction to ResponseFactory using macro instead of using trait
        ResponseFactory::macro('api',function($data=null, $error=0, $message =''){
            return response()->json([
                'data'      =>  $data,
                'error'     => $error,
                'message'   => $message
            ]);
        });

        view()->composer('*', function ($view) {
            $settings = app('settings');
            return $view->with('settings', $settings);
        });
    }
}
