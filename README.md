# Hotel Bookings

## Description
A simple tool to manage hotel rooms and keep track of its bookings. 
It consists of two major parts:
- An Admin backend for managing the hotel
- A RESTful API for prospective clients

### Stack
- Laravel
- VueJS

### Setup and Configuration
-  Make configurations in the .env file as with any Laravel application.
    - Copy the '.env.example' file to '.env' and edit the '.env' file
        - Set your preferred APP_KEY_NAME for the to-be-generated tokens
        - Set your Database credentials

-  The dependencies are in two parts: PHP and JS
   - Install PHP dependencies including Laravel Passport 
    ~~~
    composer install
    ~~~

   - Install JS dependencies including Vue-router 
    ~~~
    npm install
    ~~~

-  Generate new App key, then, run migrations and any available database seeds.
    ~~~
    php artisan key:generate
    php artisan migrate --seed
    ~~~

-  Then, install the Passport to create the default auth Clients.
    - NOTE: this will normally run via the '--seed' option during database migration above.
    ~~~
       php artisan passport:install
    ~~~
    
- Add the following lines to the boot() method of AuthServiceProvider class:
   ~~~
     Passport::routes();

     Passport::personalAccessClientId('1');

     Passport::tokensExpireIn(now()->addDays(7));
   ~~~

