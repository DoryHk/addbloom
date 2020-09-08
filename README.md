## Installation
```
composer install
npm install
```

## Compiles and hot-reloads for development
```
npm run dev
```

## Configuration
Add a `.env` file in the root of your project.
Copy the content of `.env.example` file to the `.env` and ensure that all the settings are correct for your local environment.
```
cp .env.example .env
```
## Requirements
Generating the key.
```
php artisan key:generate
```
This command will run all migrations. 

```bash
php artisan migrate
```
This commad will create dummy data in the database.
```bash
php artisan db:seed
```

## To run this project you must use the Laravel Artisan serve command.
```
php artisan serve
```
## Sample endpoints

### Views
 - `/` - Default route that redirects to the home page 
