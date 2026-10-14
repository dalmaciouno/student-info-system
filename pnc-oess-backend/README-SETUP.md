# PnC-OESS backend

This Laravel API serves the React frontend in the separate `pinaka updated na
front-end` folder. It uses Laravel Sanctum bearer tokens and the configured
database connection.

## Local development

1. Install PHP 8.2+ and Composer, then install the dependencies:

   ```powershell
   composer install
   ```

2. Create `.env` from `.env.example`, set the database connection, and generate
   the application key:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   For local SQLite development, ensure `database/database.sqlite` exists and
   set `DB_CONNECTION=sqlite` in `.env`. For MySQL or PostgreSQL, configure the
   corresponding `DB_*` values instead.

3. Run the migrations and seed the demo records:

   ```powershell
   php artisan migrate --seed
   ```

4. Start the API:

   ```powershell
   php artisan serve
   ```

   The health endpoint is `http://127.0.0.1:8000/api/health`. The frontend
   defaults to `http://localhost:8000/api`; set its `VITE_API_URL` if using a
   different API URL.

5. Set `CORS_ALLOWED_ORIGINS` to the frontend origin (comma-separated if
   there are multiple). The default allows the local Vite origin
   `http://localhost:5173`; the deployed backend must be configured with the
   actual frontend origin.

Demo logins use the password `password123`: `student`, `registrar`, `cashier`,
`department`, and `admin`.

## Render deployment

1. Create a Render PostgreSQL database and a Docker web service for this
   repository.
2. Configure the environment variables in `.env.render.example`, including
   the database URL, generated `APP_KEY`, and the production frontend origin in
   `CORS_ALLOWED_ORIGINS`.
3. Set the service health check path to `/api/health`.
