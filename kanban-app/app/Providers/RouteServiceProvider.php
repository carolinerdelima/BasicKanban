<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public const HOME = '/';

    /**
     * Definindo as rotas da aplicação
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Rotas de API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Rotas web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
