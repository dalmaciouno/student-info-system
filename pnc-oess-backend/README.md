# PnC-OESS Backend

This folder contains the Laravel API for the PnC-OESS frontend. The frontend
must be run separately and configured to use this API.

## Requirements

- PHP 8.2 or newer with the required Laravel extensions, including `pdo_mysql`
- Composer
- MySQL 8 or another database supported by Laravel

## Set up locally

1. Open a terminal in this backend folder and install PHP dependencies:

   ```powershell
   composer install
   ```

2. Create your local environment file:

   ```powershell
   Copy-Item .env.example .env
   ```

3. Edit `.env` and configure your local database. For MySQL, set values similar
   to these, using your own database name, username, and password:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pnc_oess
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

   Create the database before continuing. Do not share your `.env` file or put
   database passwords in source control.

4. Generate an application key and create the database tables with initial
   sample records:

   ```powershell
   php artisan key:generate
   php artisan migrate --seed
   ```

   The seeder only adds sample data when the database has no users. Use a fresh
   database if you want the complete initial sample dataset.

5. Start the API:

   ```powershell
   php artisan serve
   ```

   The API is normally available at `http://127.0.0.1:8000/api`. Check
   `http://127.0.0.1:8000/api/health` to verify the server is responding.

6. In the separately installed frontend, set `VITE_API_URL` to
   `http://127.0.0.1:8000/api` in its local `.env.local` file, then start the
   frontend.

## Tests

Run the backend tests with:

```powershell
php artisan test
```
