# PHP Challenge Studio Manager

## Story - Create Classes

As a studio owner i want to create classes for my studio so that my members can attend classes

### Acceptance Criteria

Implement an API to create classes(`/classes`). Assume this api don't need to have any authentication to start with.
Few bare minimum details we need to create classes are - class name, start_date, end_date, capacity. For now, assume that there will
be only one class per given day. Ex: If a class by name pilates starts on 1st Dec and ends on 20th Dec, with capacity 10, that means
Pilates have 20 classes and for each class the maximum capacity of attendance is 10.
No need to save the details in any database. Maintain an in memory array or a file to save the info. (If you want to use the database,
thats fine as well).
Use Restful standards and create the api end point with proper success and error responses.

## Story - Book for a class

As a member of a studio, I can book for a class, so that i can attend a class.

### Acceptance Criteria

Implement an API end point (`/bookings`). Assume this api don't need to have any authentication to start with.
Few bare minimum details we need for reserving a class are - name(name of the member who is booking the class), date(date for which
the member want to book a class)
No need to save the details in DB. If you can maintain the state in an in memory array or a file is good to start with. But no constraints if
you want to use database to save the state.
Use REST standards and think through basic api responses for success and failure.
No need to consider the scenario of overbooking for a given date. Ex: 14th Dec having a capacity of 20 , but number of booking can be
greater than 20.

## Setup

Requirements

PHP >= 7.0

OpenSSL PHP Extension

PDO PHP Extension

Mbstring PHP Extension

1- Create an empty file named database.sqlite inside the database/ folder.

2- Run `$ cp .env.example .env` to have the environment variables working.

3- Run `$ composer install` to install all the dependencies.

4- Run `$ php -S localhost:8000 -t public` after this the server will be up.

Feel free to change the port to anyother as needed (8001, 8080, etc..).

## Tests

### PHPUnit

Runs every automated tests using PHPUnit.

```
$ vendor/bin/phpunit
```

### Code Sniffer

Check if there is code style to fix on every file.

```
$ composer check-style
```

Apply the code style fix on every file.

```
$ composer fix-style
```
