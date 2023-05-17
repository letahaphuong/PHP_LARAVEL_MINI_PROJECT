<?php

namespace App\Providers;

use App\Repositories\User\UserRepositoryRepository;
use App\Repositories\User\UserRepositoryRepositoryEloquent;
use App\View\Components\Alert;
use App\View\Components\form\modal;
use App\View\Components\Input\Button;

// use App\View\Components\Form\Button as FormButton;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        Blade::component('alert', Alert::class);
//        Blade::component('modal', modal::class);
        // Blade::component('button', Button::class);
        App::bind(UserRepositoryRepository::class, UserRepositoryRepositoryEloquent::class);
        // Blade::component('form-button', FormButton::class);

        Blade::directive('datetime', function ($expression) {
            $expression = trim($expression, '\'');
            $expression = trim($expression, '"');
            $dateObject = date_create($expression);
            $dateFormat = $dateObject->format('d/m/Y H:m:s');
            if (!empty($dateFormat)) {
                return $dateFormat;
            } else {
                return false;
            }
        });
    }
}
