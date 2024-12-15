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

Or use (Sail)[https://laravel.com/docs/11.x/sail]

### Local installation
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

### Using Sail
To install the project without Composer or PHP locally installed, we can use a ephimeral docker image to install everything and then start using Sail.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

To run the docker container:

```bash
./vendor/bin/sail up
```

To execute a command within the container with Sail:

```bash
./vendor/bin/sail artisan migrate
```