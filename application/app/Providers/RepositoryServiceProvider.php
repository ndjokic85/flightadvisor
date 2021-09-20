<?php

namespace App\Providers;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\IRepository;
use App\Repositories\IRoleRepository;
use App\Repositories\IUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRepository::class, BaseRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
