🚀 AdCrm – Laravel API CRM Backend

A lightweight, scalable CRM API built using Laravel 10 and Sanctum, supporting:
- Organization registration with image upload
- Role-based user creation (TL, Associate)
- File storage via polymorphic relationships

------------------------------------------------------------
📦 Installation Guide

1. Clone the Repository

    git clone https://github.com/your-username/AdCrm.git
    cd AdCrm

2. Install Dependencies

    composer install

3. Configure .env File

    cp .env.example .env

    # Then edit .env with:
    APP_NAME=AdCrm
    APP_URL=http://127.0.0.1:8000
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

4. Generate App Key

    php artisan key:generate

5. Run Migrations

    php artisan migrate

6. Run Seeder (Populate Default Users)

    php artisan db:seed

7. Link Storage for Uploaded Files

    php artisan storage:link

    # Uploaded images will be accessible at:
    # http://127.0.0.1:8000/storage/organization/filename.jpg

------------------------------------------------------------
🔐 Sanctum Setup (if needed)

    composer require laravel/sanctum
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate

    # Ensure this is in app/Http/Kernel.php in the api middleware group:
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

------------------------------------------------------------
🧪 API Endpoints

Public Routes:
/api/register  [POST]  → organization registration (form-data, supports image)
/api/login     [POST]  → login and receive Bearer token

Protected Routes (require Bearer token):
/api/user      [GET]   → get logged-in user
/api/logout    [POST]  → logout user

------------------------------------------------------------
🗃️ File Upload & Structure

- Images stored in: storage/app/public/organization/
- Related via polymorphic relation to `users`
- File URLs returned using `url` accessor in File model

------------------------------------------------------------
👥 Roles Summary

- organization → registers publicly
- tl          → created by organization
- associate   → created under TL or directly by org

Ready to build TL/associate relationships and scale features!
