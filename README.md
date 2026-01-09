# Laravel User Management System

## Project Overview
This is a complete User Management System developed with **Laravel 11**. It features:  
- An
 **Admin Dashboard** for managing web users  
- A **RESTful API** for external integration  
- Focus on **code quality, security, and testability**  

---

## 1. Prerequisites
Before setting up the project locally, make sure you have the following installed:

- **PHP 8.2** or higher
- **Composer**
- **Node.js** & **NPM**
- **MySQL** (or any database supported by Laravel)

---

## 2. Installation Steps

### 2.1 Clone the repository
```bash
git clone https://github.com/IvanKangJinLiang/bestweb-technologies.git
cd bestweb-technologies
```

### 2.2 Install dependencies
```bash
composer install
npm install
npm run build
```

### 2.3 Set up environment file
```bash
cp .env.example .env
```

### 2.4 Generate the application key & Run database migrations
Ensure you create a database in your MySQL server (e.g., via phpMyAdmin) that matches the DB_DATABASE value in your .env file (Default: bestweb_technologies)
```bash
php artisan key:generate
php artisan migrate --seed
```

### 2.5 Generate API documentation
```bash
php artisan l5-swagger:generate
```

### 2.6 Start the development server
```bash
php artisan serve
```
Access the application at: http://127.0.0.1:8000

## 3. API Endpoints Documentation

The API is fully documented using Swagger/OpenAPI.  
Interactive documentation is available at: [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation) [Make sure php artisan serve is running]

| Method | Endpoint                  | Description                                         |
|--------|---------------------------|-----------------------------------------------------|
| GET    | /api/users                | List users (Supports pagination & status filtering) |
| POST   | /api/users                | Create a new user                                   |
| GET    | /api/users/{id}           | Get details of a specific user                      |
| PUT    | /api/users/{id}           | Update user details                                 |
| DELETE | /api/users/{id}           | Soft delete a user                                  |
| POST   | /api/users/bulk-delete    | Bulk delete users (Requires array of IDs)           |


## 4. Running Tests:
The application includes Feature tests covering CRUD operations.
```bash
php artisan test
```

## 5. Assumptions & Design Choices

### A. Separation of Concerns (Web vs API)
- **App\Http\Controllers\UserController**: Handles Web requests (Views/Redirects).  
- **App\Http\Controllers\Api\UserController**: Handles API requests (JSON responses).

### B. Smart Validation Handling
- Custom Form Requests (`StoreUserRequest`, `UpdateUserRequest`) handle validation centrally.  
- `failedValidation` is overridden to detect request context:
  - **Browser:** redirects back with errors (user-friendly).  
  - **API:** returns JSON errors (machine-friendly).

### C. Route Naming Convention
- API routes are explicitly named using `->names('api.users')` to avoid conflicts between Web and API routes.

### D. Data Integrity (Soft Deletes)
- Users are **soft deleted** using Laravel’s `SoftDeletes` trait.  
- Deleted users are hidden from the frontend but remain in the database with a `deleted_at` timestamp.

### E. Testing Strategy
- Unit and Feature tests implemented with **PHPUnit**.  
- `UserTest.php` covers the critical CRUD operations: list, create, update, and soft delete.

---

## Technologies Used
- **Framework:** Laravel 11  
- **Database:** MySQL  
- **Frontend:** Blade Templates + Bootstrap  
- **API Documentation:** L5-Swagger  
- **Export:** Maatwebsite/Laravel-Excel

