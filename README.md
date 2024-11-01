<h1 align="center">Library System</h1>

A library management system developed in PHP.

## Table of Contents

- [Description](#description)
- [Requirements](#requirements)
- [Cloning the Repository](#cloning-the-repository)
- [Installing Dependencies](#installing-dependencies)
- [Running Unit Tests](#running-unit-tests)

## Description

The Library System is a project that allows for the simple and efficient management of books and users. The system provides functionalities to add, list, and remove books and users.

## Requirements

Before you begin, you will need to have the following installed on your system:

- PHP 8.0 or higher
- Composer
- PDO (for database access)
- SQLite (the project uses an SQLite database)

## Cloning the Repository

To clone this repository, open the terminal and run the following command:

```bash
git clone https://github.com/AAndersonSantos/Library-System.git
```

## Installing Dependencies

Navigate to the project directory and run the following command to install the required dependencies:

```bash
cd library-system
composer install
```

## Database Setup

The project uses an SQLite database. To set it up, follow these steps:

1. Create a file named database.sqlite inside the src folder.
2. Ensure that the file has read and write permissions.

## Running the Project

To start the built-in PHP server and run the project, use the following command:

```bash
php -S localhost:8000 -t src
```

## Running Unit Tests

To run the unit tests for the project, use PHPUnit. Make sure you are in the project directory and run the following command:

```bash
vendor/bin/phpunit tests
```

The tests will be executed, and you will see the results in the terminal.

## Endpoints

You can access the following endpoints to test the routes using Postman or any API testing tool:

Books:

    GET: http://localhost:8000/index.php/livros

    POST: http://localhost:8000/index.php/livros

    PUT: http://localhost:8000/index.php/livros/{id}

    DELETE: http://localhost:8000/index.php/livros/{id}

Users:

    GET: http://localhost:8000/index.php/usuarios

    POST: http://localhost:8000/index.php/usuarios

    PUT: http://localhost:8000/index.php/usuarios/{id}

    DELETE: http://localhost:8000/index.php/usuarios/{id}

Loans:

    POST: http://localhost:8000/index.php/emprestimos
