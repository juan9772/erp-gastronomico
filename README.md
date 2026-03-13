# ERP Gastronómico

Una solución moderna y ligera para la planificación de recursos empresariales (ERP) orientada a la industria gastronómica. Este proyecto está diseñado para ayudar a restaurantes, cafeterías y negocios afines a gestionar sus Insumos, Recetas y Productos, calculando automáticamente y en tiempo real los costos de producción.

## 🚀 Características Principales

-   **Gestión de Insumos**: Administra materias primas con su costo unitario y unidad de medida (kg, gr, l, unidad, etc).
-   **Gestor de Productos**: Define los productos finales que vendes y asócialos a una receta base para conocer su rentabilidad real.
-   **Sistema de Recetas Dinámico**: Construye recetas agregando N cantidad de insumos.
-   **Cálculo Automático de Costos**: Gracias al `CostCalculationService`, cualquier variación en el precio de un insumo actualizará instantáneamente el costo recurrente de todas las recetas que lo utilizan y, por ende, el costo del producto final.
-   **Interfaz Moderna y Responsiva**: Construido con Tailwind CSS, garantizando una excelente usabilidad tanto en dispositivos móviles como de escritorio.
-   **Sincronización en Tiempo Real (Dev)**: Configurado con `nodemon` y `Vite (HMR)` para reflejar todo el flujo de trabajo en tu red local instantáneamente durante el desarrollo.

## 🛠️ Tecnologías Utilizadas

-   **Backend**: [Laravel 12](https://laravel.com)
-   **Frontend**: [Blade](https://laravel.com/docs/blade), [Tailwind CSS](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
-   **Base de Datos**: SQLite (configurado por defecto para fácil despliegue y desarrollo)
-   **Autenticación**: Laravel Breeze
-   **Testing**: Pest PHP
-   **Herramientas Dev**: Vite, Nodemon

## ⚙️ Instalación y Configuración Local

Sigue estos pasos para desplegar el proyecto en tu entorno de desarrollo.

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/juan9772/erp-gastronomico.git
   cd erp-gastronomico
   ```

2. **Instalar dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Instalar dependencias de Node.js:**
   ```bash
   npm install
   ```

4. **Configurar el entorno:**
   Copia el archivo de entorno de ejemplo y genera tu clave de aplicación.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Alistando la Base de Datos:**
   Como estamos usando SQLite, simplemente asegúrate de crear el archivo y correr las migraciones.
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Iniciar el Servidor (Modo Desarrollo):**
   Para tener la mejor experiencia de desarrollo (con recarga automática mediante Nodemon y Vite corriendo en red local), ejecuta en _dos pestañas separadas de tu terminal_:

   **Terminal 1 (Backend con Nodemon):**
   ```bash
   npm run watch
   ```
   *(Alternativamente, puedes usar el tradicional `php artisan serve`)*

   **Terminal 2 (Frontend Frontend con Vite):**
   ```bash
   npm run dev
   ```

7. **Acceder a la aplicación:**
   Abre tu navegador y dirígete a `http://localhost:8000`. Regístrate con un nuevo usuario local y comienza a explorar el Dashboard.

## 🧪 Pruebas (Testing)

Este proyecto cuenta con una robusta suite de Unit y Feature Tests construidos bajo [Pest PHP](https://pestphp.com/). Los tests aseguran que el motor transaccional de cálculos de costos siempre sea exacto.

Para correr todas las pruebas:
```bash
php artisan test
```

## 📄 Licencia

Este proyecto es Open Source y se distribuye bajo la licencia [MIT](LICENSE). Eres libre de usarlo, modificarlo y distribuirlo de acuerdo con los términos de dicha licencia.
