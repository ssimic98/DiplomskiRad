<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

    }

    public function map()
    {
        $this->mapApiRoutes();
        // Ostale mapiranje ruta...
    }

    protected function mapApiRoutes()
    {
        Route::middleware('auth:sanctum')
             ->prefix('api')
             ->group(base_path('routes/api.php'));
    }
}
