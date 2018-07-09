<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Repositories\Abstraction\UserRepositoryInterface;
use App\Repositories\Implementation\UserRepositoryConcrete;
use App\Entities\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()  // REGISTRAR SERVICES AQUI
    {
        
        /**
         * REPOSITORIES
         */
        $this->app->bind(UserRepositoryInterface::class, function($app) {
            return new UserRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(User::class)
            );
        });
        
        /**
         * SERVICES
         */
        $this->app->bind(UserService::class, function($app)
        {
            return new UserService(
                $app->make('App\Repositories\Abstraction\UserRepositoryInterface')
            );
        });
        
        
    }
}
