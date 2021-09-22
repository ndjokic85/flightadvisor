<?php

namespace App\Providers;

use App\Http\Controllers\Api\v1\Admin\AirportImporterController;
use App\Http\Controllers\Api\v1\Admin\RouteImporterController;
use App\Repositories\Eloquent\AirportRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\RouteRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\IAirportRepository;
use App\Repositories\ICityRepository;
use App\Repositories\ICommentRepository;
use App\Repositories\IRepository;
use App\Repositories\IRoleRepository;
use App\Repositories\IRouteRepository;
use App\Repositories\IUserRepository;
use App\Validators\Imports\AirportImportValidator;
use App\Validators\Imports\RouteImportValidator;
use App\Validators\IValidator;
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
        $this->app->bind(ICityRepository::class, CityRepository::class);
        $this->app->bind(IAirportRepository::class, AirportRepository::class);
        $this->app->bind(IRouteRepository::class, RouteRepository::class);
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
        $this->app->when('App\Http\Controllers\Api\v1\Admin\AirportImporterController')
            ->needs('App\Validators\IValidator')
            ->give('App\Validators\Imports\AirportImportValidator');

        $this->app->when('App\Http\Controllers\Api\v1\Admin\RouteImporterController')
            ->needs('App\Validators\IValidator')
            ->give('App\Validators\Imports\RouteImportValidator');
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
