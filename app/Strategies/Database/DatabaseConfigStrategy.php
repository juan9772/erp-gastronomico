<?php

namespace App\Strategies\Database;

interface DatabaseConfigStrategy
{
    /**
     * Aplica la configuración de la base de datos al sistema de Laravel.
     */
    public function configure(): void;
}
