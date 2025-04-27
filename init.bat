:: Install Composer packages without any interaction or console log
:: You can uncomment the next line if you're starting from a specific directory (e.g., zoo-animal-registry)
:: call cd zoo-animal-registry

echo Installing Composer packages...
call composer install --no-interaction --quiet

:: .env file initialization
echo Initializing .env file...
@echo off
(
    echo APP_NAME="Zoo-Animal-Registry"
    echo APP_ENV=local
    echo APP_KEY=
    echo APP_DEBUG=true
    echo APP_TIMEZONE=UTC
    echo APP_URL=http://localhost:8000
    echo.
    echo DB_CONNECTION=sqlite
    echo FILESYSTEM_DISK=local
) > .env
@echo on

:: Generate the encryption key
echo Generating the APP_KEY...
call php artisan key:generate

:: Install frontend packages with Node Package Manager (without console log)
echo Installing NPM packages...
call npm install --silent

:: Build frontend assets using Mix (use npm run build for production)
echo Building frontend assets...
call npm run dev -- --build

:: Create an empty database\database.sqlite file, so we can run the migrations
echo Creating database.sqlite file...
type nul > database\database.sqlite

:: Running migrations and seed the database
echo Running migrations and seeding the database...
call php artisan migrate:fresh --seed

:: Create storage folder if missing and symlink the public directory
echo Ensuring storage symlink is created...
mkdir .\storage\app\public
call php artisan storage:link

:: Run the development server
echo Running Laravel development server...
call php artisan serve

:: Additional commands (if needed, uncomment if you prefer to run them):
:: composer install
:: npm install
:: npm run build
:: cp .env.example .env
:: touch database/database.sqlite
:: php artisan key:generate
:: php artisan migrate:fresh --seed
:: php artisan storage:link
:: php artisan serve

echo Setup completed. Your project is now running!