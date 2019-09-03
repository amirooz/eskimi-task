<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Contracts\TaskRepository;
use App\Repositories\Implementations\Eloquent\TaskImplementation;
use App\Repositories\Contracts\DashboardRepository;
use App\Repositories\Implementations\Eloquent\DashboardImplementation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TaskRepository::class,TaskImplementation::class);
        $this->app->singleton(DashboardRepository::class,DashboardImplementation::class);
    }


}
