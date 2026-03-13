<?php

namespace App\Strategies\Database;

use Illuminate\Support\Facades\Config;

class PostgresStrategy implements DatabaseConfigStrategy
{
    /**
     * Aplica la configuración de la base de datos PostgreSQL extraída de Render.
     */
    public function configure(): void
    {
        // Render inyecta la URL de conexión completa en DATABASE_URL
        $databaseUrl = env('DATABASE_URL');
        
        if ($databaseUrl) {
            $parsedUrl = parse_url($databaseUrl);

            Config::set('database.connections.pgsql', [
                'driver' => 'pgsql',
                'url' => env('DATABASE_URL'),
                'host' => $parsedUrl['host'] ?? '127.0.0.1',
                'port' => $parsedUrl['port'] ?? '5432',
                'database' => ltrim($parsedUrl['path'], '/'),
                'username' => $parsedUrl['user'] ?? '',
                'password' => $parsedUrl['pass'] ?? '',
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ]);

            Config::set('database.default', 'pgsql');
        }
    }
}
