<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use App\Http\Services\ApiService;
// use App\Http\Services\ApiService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bindIf(ApiService::class, function($app){return new ApiService();});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $service = new ApiService();
        Schema::defaultStringLength(191);
        // View::share('help_contacts', \App\Models\School::first()->help_contacts??'');
        View::share('api_service', new \App\Http\Services\ApiService());
    }
}
