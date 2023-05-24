<?php

namespace App\Providers;

use App\Repositories\BilliardDetails\BilliardDetailRepository;
use App\Repositories\BilliardDetails\BilliardDetailRepositoryEloquent;
use App\Repositories\Billiards\BilliardsRepository;
use App\Repositories\Billiards\BilliardsRepositoryEloquent;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Categories\CategoriesRepositoryEloquent;
use App\Repositories\Facilities\AttachFacilityRepository;
use App\Repositories\Facilities\AttachFacilityRepositoryEloquent;
use App\Repositories\Management\ManagementRepository;
use App\Repositories\Management\ManagementRepositoryEloquent;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Orders\OrderRepositoryEloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind(BilliardsRepository::class, BilliardsRepositoryEloquent::class);
        App::bind(AttachFacilityRepository::class, AttachFacilityRepositoryEloquent::class);
        App::bind(OrderRepository::class, OrderRepositoryEloquent::class);
        App::bind(BilliardDetailRepository::class, BilliardDetailRepositoryEloquent::class);
        App::bind(CategoriesRepository::class, CategoriesRepositoryEloquent::class);
        App::bind(ManagementRepository::class, ManagementRepositoryEloquent::class);
    }
}
