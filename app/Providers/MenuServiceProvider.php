<?php

namespace App\Providers;

use App\Http\Controllers\SeguridadController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\PerfilModulo;
use Illuminate\Support\Facades\Auth;


class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Compartir el menú con todas las vistas que incluyan 'aside'
        View::composer('modulos.layouts.aside', function ($view) {
            if (Auth::check()) {
                $seguridadController = new SeguridadController();
                $menuUsuario = $seguridadController->obtenerMenu();
                $view->with('menuUsuario', $menuUsuario);
            }
        });
    }
}
