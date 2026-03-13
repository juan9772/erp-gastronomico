# Gastronomic ERP

A modern and lightweight Enterprise Resource Planning (ERP) solution tailored for the culinary industry. This project is designed to help restaurants, cafes, and related businesses manage their Ingredients, Recipes, and Products while automatically calculating production costs in real-time.

## 🚀 Key Features

-   **Ingredient Management**: Manage raw materials with their unit cost and measurement unit (kg, gr, l, unit, etc.).
-   **Product Manager**: Define the final products you sell and link them to a base recipe to determine true profitability.
-   **Dynamic Recipe System**: Build recipes by adding any number of ingredients.
-   **Automatic Cost Calculation**: Powered by the `CostCalculationService`, any change in an ingredient's price instantly updates the recurring cost of all recipes using it, seamlessly updating the final product's cost.
-   **Modern and Responsive Interface**: Built with Tailwind CSS, ensuring excellent usability on both mobile and desktop devices.
-   **Real-Time Synchronization (Dev)**: Configured with `nodemon` and `Vite (HMR)` to instantly reflect your entire workflow on your local network during development.

## 🛠️ Tech Stack

-   **Backend**: [Laravel 12](https://laravel.com)
-   **Frontend**: [Blade](https://laravel.com/docs/blade), [Tailwind CSS](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
-   **Database**: SQLite (configured by default for easy deployment and development)
-   **Authentication**: Laravel Breeze
-   **Testing**: Pest PHP
-   **Dev Tools**: Vite, Nodemon

## ⚙️ Local Installation & Setup

Follow these steps to deploy the project in your local development environment.

1. **Clone the repository:**
   ```bash
   git clone https://github.com/juan9772/erp-gastronomico.git
   cd erp-gastronomico
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Environment setup:**
   Copy the example environment file and generate your application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Prepare the Database:**
   Since we're using SQLite, simply make sure the file is created and run the migrations.
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Start the Server (Development Mode):**
   For the best development experience (with automatic reloading via Nodemon and Vite running on your local network), run this in _two separate terminal tabs_:

   **Terminal 1 (Backend with Nodemon):**
   ```bash
   npm run watch
   ```
   *(Alternatively, you can use the traditional `php artisan serve`)*

   **Terminal 2 (Frontend with Vite):**
   ```bash
   npm run dev
   ```

7. **Access the application:**
   Open your browser and navigate to `http://localhost:8000`. Register a new local user and start exploring the Dashboard.

## 🧪 Testing

This project features a robust Unit and Feature test suite built with [Pest PHP](https://pestphp.com/). The tests ensure that the transactional cost calculation engine remains perfectly accurate at all times.

To run the test suite:
```bash
php artisan test
```

## 📄 License

This project is Open Source and distributed under the [MIT License](LICENSE). You are free to use, modify, and distribute it according to the terms of the license.
