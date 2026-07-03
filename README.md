# Системаи Идоракунии Ҳозирии Донишҷӯён
# Student Attendance Management System

## Technology Stack
- Laravel 12, PHP 8.3+, MySQL, Bootstrap 5, Blade Templates
- Spatie Permission, DomPDF, Maatwebsite Excel

## Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
# Configure .env with MySQL credentials
php artisan migrate
php artisan db:seed
php artisan serve
```

## Login Credentials
- Admin: admin@attendance.tj / password123
- Dean: dean@attendance.tj / password123  
- Supervisor: supervisor@attendance.tj / password123

## Educational Structure
Institution → Faculty → Specialty → Course → Group → Student

## Attendance
- Once per day per group
- Statuses: Present, Absent, Excused, Late
