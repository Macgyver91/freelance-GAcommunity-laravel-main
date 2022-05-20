#!/bin/bash

composer install
yes | php artisan migrate:fresh --seed
# yes | php artisan db:seed