<?php

namespace App\Providers;

use App\View\Components\Alert;
use App\View\Components\form\modal;
use App\View\Components\Input\Button;

// use App\View\Components\Form\Button as FormButton;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('alert', Alert::class);
//        Blade::component('modal', modal::class);
        // Blade::component('button', Button::class);

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
