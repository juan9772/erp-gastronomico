<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Strategies\Database\DatabaseConfigStrategy;
use App\Strategies\Database\PostgresStrategy;
use App\Strategies\Database\SqliteStrategy;

class DatabaseStrategyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Vinculamos la interfaz a una implementación concreta mediante una fábrica de resolución
        $this->app->bind(DatabaseConfigStrategy::class, function ($app) {
            // Render.com siempre expone la variable de entorno 'RENDER'
            if (env('RENDER') === 'true' || env('RENDER') === true) {
                return new PostgresStrategy();
            }

            // Por defecto, entorno local usará SQLite
            return new SqliteStrategy();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Resuelve la estrategia y aplícala
        $strategy = $this->app->make(DatabaseConfigStrategy::class);
        $strategy->configure();
    }
}
