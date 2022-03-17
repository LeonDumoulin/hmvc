<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

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
        view()->composer('*', function ($view) {
            $settings = app('settings');
            return $view->with('settings', $settings);
        });
    }
}