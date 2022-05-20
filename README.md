<p  align="center"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="300"></a></p>

<h1 align="center">GA-Community </h1>

# Getting started

## Prerequisite

-   php (cli) version 7.4.3
-   mysql Ver 15.1 Distrib 10.4.19-MariaDB, for Linux (x86_64) using readline 5.1

## Installation

### Docker and docker-compose launch

If you have docker and docker-compose installed, just follow these step:

-   Clone the repository with `git clone git@github.com:SAYNACROWDSOURCING/freelance-GAcommunity.git`
-   In the directory, in the docker-compose file, for the first run, comment the line `command: php artisan serve --host 0.0.0.0 ` and uncomment `command: bash prepare.sh`
-   Check if the volume ```freelance-gacommunity-laravel_db-data``` exists, delete it if so with ```docker volume rm freelance-gacommunity-laravel_db-data```. You need to stop and remove the connected container if needed.
-   Run `docker-compose up --build ` inside the folder
-   Wait for the laravel container to stop, then stop with Ctrl+C
-   Reverse your command on the second step, then run `docker-compose up` and enjoy.

### Others

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone git@github.com:SAYNACROWDSOURCING/freelance-GAcommunity.git

Switch to the repo folder

    cd freelance-GAcommunity

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Seed the database after migration

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:SAYNACROWDSOURCING/freelance-GAcommunity.git
    cd freelance-GAcommunity
    composer install
    cp .env.example .env

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Environment variables

-   `.env` - Environment variables can be set in this file

**_Note_** : You can quickly set the database information and other variables in this file and have the application fully working.

---

# Functionality:

1. Authentication: 
    - multi-auth admin/user
    - auth using guard (guard:admin, guard: user)
    - authorization using middlewares and policies

2. Email verification:
    - After the creation of an user account, the user receive an email with a link to confirm his email inside a button
    - The user need to login before clicking on this button
    - After login, if the user account is not yet confirmed, he can't perform any action
    - So after login, the user need to click on the button inside the confirmation email, then his account is confirmed
    - If the user didn't receive the confirmation email (somehow), he can click on the resend link to receive another confirmation email

3. Forgot password:
    - The user click on the link "forgot password" to trigger it, then he will be redirected to the "forgot-password" page with a single input for email
    - The user provide his email address (must be a registered email address), after that, an email will be sent into his email inbox
    - Inside the email, there is a link for resetting his password inside a button. 
    - By clicking on this button, he will be redirected to the page "reset-password" to change his password.
