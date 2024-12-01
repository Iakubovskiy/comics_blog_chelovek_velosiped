<?php

namespace App\Providers;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\PhotoService;
use App\Services\PostService;
use App\Services\RoleService;
use App\Services\TomService;
use App\Repositories\PhotoRepository;
use App\Repositories\PostRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TomRepository;
use App\Repositories\UserRepository;
use App\Services\CloudinaryUploadService;
use App\Services\Interfaces\FileUploadServiceInterface;
use Illuminate\Support\Facades\Gate;
use App\Policies\RolePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(UserService::class)
        ->needs(RepositoryInterface::class)
        ->give(UserRepository::class);

        $this->app->when(PhotoService::class)
        ->needs(RepositoryInterface::class)
        ->give(PhotoRepository::class);

        $this->app->when(PostService::class)
        ->needs(RepositoryInterface::class)
        ->give(PostRepository::class);

        $this->app->when(RoleService::class)
        ->needs(RepositoryInterface::class)
        ->give(RoleRepository::class);

        $this->app->when(TomService::class)
        ->needs(RepositoryInterface::class)
        ->give(TomRepository::class);

        $this->app->singleton(FileUploadServiceInterface::class, 
        CloudinaryUploadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    
    }
}
