# To Do List App

A To Do List App developed with CakePHP and Vue.js.

## Prerequisites

1. PHP 7.2 (>= 5.6 supported)
2. Composer
3. MySQL 5.6
4. Node.js (>= 8.9 supported)
5. PHP extensions (mbstring, intl, simplexml, PDO PHP)

## Database creation and configuration

1. Create a database and execute the script inside `config/schema/cake_todo.sql` for creating the database schema.
2. Copy the file `config/app_local.example.php` renaming it as `app_local.php` and configure the database parameters.

## Running the project

1. Install composer dependencies

```bash
composer install
```

2. Install npm dependencies

```bash
npm install
```

3. Build assets

```bash
npm run build
```

4. Start up the built-in webserver with:

```bash
bin/cake server
```

The app will be running on `http://localhost:8765`.