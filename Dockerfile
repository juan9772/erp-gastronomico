FROM php:8.3-cli

# Instalar dependencias del sistema necesarias para PostgreSQL y Node (para Vite)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql mbstring pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar el proyecto
COPY . .

# Ejecutar el script completo de construcción (composer install, npm run build, cachés y migraciones)
RUN chmod +x bin/render-build.sh
RUN bin/render-build.sh

EXPOSE 8000

# Render inyecta la variable $PORT automáticamente
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
