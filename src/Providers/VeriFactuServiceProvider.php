<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Providers;

use Illuminate\Support\ServiceProvider;

class VeriFactuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar bindings, singletons, etc.
        $this->mergeConfigFrom(__DIR__.'/../../config/verifactu.php', 'verifactu');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publicar archivos de configuración
        $this->publishes([
            __DIR__.'/../../config/verifactu.php' => config_path('verifactu.php'),
        ], 'config');

        // Publicar migraciones
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
} 