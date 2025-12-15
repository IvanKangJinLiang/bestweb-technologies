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

### 2.6 Start the development server
```bash
php artisan serve
```