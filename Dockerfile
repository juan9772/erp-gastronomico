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

# Instalar dependencias backend y frontend, y construir Vite durante el BIT DE CONSTRUCCIÓN
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# Otorga permisos de ejecución al script de entrada
RUN chmod +x bin/docker-entrypoint.sh

EXPOSE 8000

# Usamos el script como punto de entrada (ejecutará migraciones y caché usando env vars de Render antes de iniciar)
CMD ["bin/docker-entrypoint.sh"]
