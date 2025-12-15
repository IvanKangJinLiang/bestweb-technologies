# Laravel User Management System

## Project Overview
This is a complete User Management System developed with **Laravel 11**. It features:  
- A full **Admin Dashboard** for managing web users  
- A **RESTful API** for external integration  
- Focus on **code quality, security, and testability**  

This project is suitable for learning, testing, or extending a robust Laravel application.

---

## 1. Prerequisites
Before setting up the project locally, make sure you have the following installed:

- **PHP 8.2** or higher
- **Composer**
- **Node.js** & **NPM**
- **MySQL** (or any database supported by Laravel)
- Optional: **Redis** or **Memcached** if you want caching support

---

## 2. Installation Steps

### 2.1 Clone the repository
git clone https://github.com/IvanKangJinLiang/bestweb-technologies.git
```bash
cd bestweb-technologies
```

### 2.2 Install dependencies
```bash
composer install
npm install
npm run build
```

### 2.3 Set up your environment file
```bash
cp .env.example .env
```

### 2.4 Set up your environment file
```bash
php artisan key:generate
```

### 2.5 Run database migrations
```bash
php artisan migrate
```

### 2.6 Generate API documentation
```bash
php artisan l5-swagger:generate
```

### 2.7 Start the development server
```bash
php artisan serve
```

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
