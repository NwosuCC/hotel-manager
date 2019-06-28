# 24898. Test Assignment for Laravel _ Frontend 

https://app.codeline.io/#/projects/2622/tasks/24898


## Description
A simple tool to manage hotel rooms and keep track of its bookings. 
It consists of two major parts:
- An Admin backend for managing the hotel
- A RESTful API for prospective clients

### Setup and Configuration
-  Create a new laravel project 
    ~~~
    laravel new hotel-manager
    cd hotel-manager
    ~~~

-  The dependencies are in two parts: PHP and JS
   - Install PHP dependencies including Laravel Passport 
    ~~~
    composer install
    composer require laravel/passport
    ~~~

   - Install JS dependencies including Vue-router 
    ~~~
    npm install vue-router
    ~~~

-  Make configurations in the .env file as with any Laravel application.
    - Your preferred APP_KEY_NAME for the to-be-generated tokens
    - Your Database credentials

-  Generate new App key and run migrations and any available database seeds.
    ~~~
    php artisan key:generate
    php artisan migrate --seed
    ~~~

-  Then, install the Passport to create the default auth Clients
    ~~~
       php artisan passport:install
    ~~~
    
   NOTE: The following lines were also added to the boot() method of AuthServiceProvider class
   ~~~
     Passport::routes();

     Passport::personalAccessClientId('1');

     Passport::tokensExpireIn(now()->addDays(7));
   ~~~

