<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# Laravel RBAC API









A complete Role-Based Access Control (RBAC) API built with Laravel 11, Laravel Passport, and PostgreSQL.

##  Features

-  User Authentication (Register, Login, Logout) with Laravel Passport
-  Custom Role-Based Access Control (RBAC) without third-party packages
-  User CRUD operations with permission enforcement
-  Role and Permission management
-  External API integration (JSONPlaceholder)
-  Standardized JSON response format
-  Database seeders for quick setup

##  Requirements

- PHP 8.1 or higher
- Composer
- PostgreSQL 12 or higher

## 🛠️ Installation

### 1. Clone the Repository

\`\`\`bash
git clone <your-repo-url>
cd rbac2-api
\`\`\`

### 2. Install Dependencies

\`\`\`bash
composer install
\`\`\`

### 3. Environment Configuration

Copy the \`.env.example\` file and configure your database:

\`\`\`bash
cp .env.example .env
\`\`\`

Edit \`.env\` file with your database credentials.

### 4. Generate Application Key

\`\`\`bash
php artisan key:generate
\`\`\`

### 5. Run Migrations

\`\`\`bash
php artisan migrate
\`\`\`

### 6. Install Passport

\`\`\`bash
php artisan passport:install
\`\`\`

### 7. Seed Database

This creates admin user (admin@example.com / password123) and regular user (user@example.com / password123):

\`\`\`bash
php artisan db:seed --class=RolePermissionSeeder
\`\`\`

### 8. Start the Server

\`\`\`bash
php artisan serve
\`\`\`

The API will be available at: \`http://localhost:8000/api\`

## 📚 API Documentation

### Base URL
\`\`\`
http://localhost:8000/api
\`\`\`

### Test Accounts

| Email | Password | Role | Permissions |
|-------|----------|------|-------------|
| admin@example.com | password123 | admin | All |
| user@example.com | password123 | user | view-users only |

### Authentication Endpoints

#### Register
\`\`\`http
POST /api/register
Content-Type: application/json

{
  "name": "John Obi",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
\`\`\`

#### Login
\`\`\`http
POST /api/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password123"
}
\`\`\`

#### Logout
\`\`\`http
POST /api/logout
Authorization: Bearer {token}
\`\`\`

### User Management Endpoints

All user management endpoints require authentication and appropriate permissions.

#### Get All Users
\`\`\`http
GET /api/users
Authorization: Bearer {token}
\`\`\`
**Required Permission:** \`view-users\`

#### Create User
\`\`\`http
POST /api/users
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "New User",
  "email": "newuser@example.com",
  "password": "password123"
}
\`\`\`
**Required Permission:** \`create-user\`

#### Update User
\`\`\`http
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Updated Name",
  "email": "updated@example.com"
}
\`\`\`
**Required Permission:** \`update-user\`

#### Delete User
\`\`\`http
DELETE /api/users/{id}
Authorization: Bearer {token}
\`\`\`
**Required Permission:** \`delete-user\`

### External API Endpoint

#### Get External Users
\`\`\`http
GET /api/external/users
Authorization: Bearer {token}
\`\`\`

Fetches users from JSONPlaceholder API.

##  Testing with Postman

Import the Postman collection included in this repository:
- File: \`Laravel-RBAC-API.postman_collection.json\`
- Public Collection: [Add your public link here]



##  RBAC System

### Default Permissions
- \`view-users\` - View user list and details
- \`create-user\` - Create new users
- \`update-user\` - Update existing users
- \`delete-user\` - Delete users

### Default Roles
**Admin Role:** Has all permissions
**User Role:** Has only \`view-users\` permission

##  Troubleshooting

### Database Connection Error
Make sure PostgreSQL is running and credentials in \`.env\` are correct.

### Passport Token Issues
Reinstall Passport:
\`\`\`bash
php artisan passport:install --force
\`\`\`

### Clear Cache
\`\`\`bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
\`\`\`

##  API Endpoints Summary

| Method | Endpoint | Auth | Permission | Description |
|--------|----------|------|------------|-------------|
| POST | /api/register | No | - | Register new user |
| POST | /api/login | No | - | Login user |
| POST | /api/logout | Yes | - | Logout user |
| GET | /api/users | Yes | view-users | Get all users |
| POST | /api/users | Yes | create-user | Create user |
| GET | /api/users/{id} | Yes | view-users | Get single user |
| PUT | /api/users/{id} | Yes | update-user | Update user |
| DELETE | /api/users/{id} | Yes | delete-user | Delete user |
| GET | /api/external/users | Yes | - | Get external users |

##  License

This project is created for educational and assessment purposes.

---

**Note:** This project implements custom RBAC without using third-party packages like Spatie or Laratrust.
EOF

echo "README.md created successfully!"


## postman link

https://prince-3477030.postman.co/workspace/Accian~0a60f04e-5050-48c1-a2f4-7b54857e9cc9/request/45864169-1c50a520-452a-45d9-8a79-12996a9909ed?action=share&creator=45864169&ctx=documentation&active-environment=45864169-9e78777c-438c-472f-8fae-82119d2685e6
