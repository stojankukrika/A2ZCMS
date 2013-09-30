# A2ZCMS
======

## Cms based on Laravel 4

## A2Z CMS is using:
* Laravel4
* Bootstrap 3
* JeffreyWay Laravel 4 Generators

How to install:

### Step x: Configure Database

Now that you have the environment configured, you need to create a database configuration for it. 
Copy the file app/config/database.php in app/config/local and edit it to match your local database settings. 
You can remove all the parts that you have not changed as this configuration file will be loaded over the initial one.

### Step x1: Configure Mailer

In the same fashion, copy the app/config/mail.php configuration file in app/config/local/mail.php. 
Now set the address and name from the from array in config/mail.php. Those will be used to send account 
confirmation and password reset emails to the users. 
If you don't set that registration will fail because it cannot send the confirmation email.


### Step x2: Set Encryption Key

In app/config/app.php

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| This key is used by the Illuminate encrypter service and should be set
| to a random, long string, otherwise these encrypted values will not
| be safe. Make sure to change it before deploying any application!
|
*/

'key' => 'YourSecretKey!!!',

You can use artisan to do this

php artisan key:generate


### Step x3: Configure Database

Run these commands to create and populate Users table:

php artisan migrate
php artisan db:seed


### Step x4: Start Page
User login with commenting permission

Navigate to your Laravel 4 website and login at /user/login:

username : user
password : user

Create a new user at /user/create
Admin login

Navigate to /admin

username: admin
password: admin
