
# aintern

Gallery

- resize image with php laravel 

setup 

1. enter command in terminal (setup composer first)
```
php artisan serve --port=8080
```
2. enter url in browser (or create database name aintern)
```
http://localhost:8080/createdatabase/aintern 
```
3. set up .env file
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=YOUR_PORT
DB_DATABASE=aintern
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
```
4. migrate in artisan
```
php artisan migrate
```