<?php

namespace App\Strategies\Database;

use Illuminate\Support\Facades\Config;

class SqliteStrategy implements DatabaseConfigStrategy
{
    /**
     * Aplica la configuración de la base de datos SQLite para desarrollo local.
     */
    public function configure(): void
    {
        // Asegurar que exista el archivo en local
        $databasePath = database_path('database.sqlite');
        
        if (!file_exists($databasePath)) {
            touch($databasePath);
        }

        Config::set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => $databasePath,
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        Config::set('database.default', 'sqlite');
    }
}
