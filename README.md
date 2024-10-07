# PMov - Grade Helper API

This is the API for the PMov - Grade Helper project.

## Overview

The API is designed to provide a simple and easy way to manage student grades. It includes resources for:

- Users
- Courses
- Exercises
- Grades

All of these resources are returned in JSON format.

## Installation

**Previous requisites:**

- PHP 8.2 or higher
- Composer

To install the project run the following commands;
```bash
  git clone https://github.com/diegohpezet/PMov-GradeHelper-Backend.git PMov-GradeHelper-Backend
  cd PMov-GradeHelper-Backend
  composer install
  php artisan migrate
  php artisan db:seed # Optional
```

Then, to run the server run the following command:
```bash
php artisan serve
```