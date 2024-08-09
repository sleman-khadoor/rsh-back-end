# Getting started

## Installation

Clone the repository

    git clone https://github.com/sleman-khadoor/rsh-back-end.git

Switch to the repo folder

    cd rsh-back-end

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve


You can now access the server at http://localhost:8000


## Database seeding

    php artisan app:seed (**For development & deployment environments**)
    php artisan db:seed (**Only for development**)
