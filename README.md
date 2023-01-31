# Orga init

To initialize the project make sure you have the following installed:
php8.2 (or higher), composer, yarn and mailhog to test mail.

## Installation

run `composer install` to install all dependencies

configured in a new file .env.local

add the following to the .env.local file:

```bash
APP_ENV=dev
DATABASE_URL="mysql://user-name:password@localhost/db-name?serverVersion=db-version"
MAILER_DSN="smtp://localhost:1025?auth_mode=login"
```
Replace the values : user-name, password, db-name, db-version. With your own.

The third line is for mailhog, if you don't want to use it, you can remove it and use the mailer of your choice.

run `php bin/console doctrine:database:create` to create the database

run `php bin/console doctrine:migrations:migrate` to create the database tables

run `php bin/console doctrine:fixtures:load` to load the fixtures (At the question do you want to continue ? type yes)

run `yarn install` to install all dependencies

run `yarn encore dev` to build the assets

run `symfony server:start` to start the server

## Mailhog

Mailhog is a mail catcher, it catches all the mails sent by the application and displays them in a web interface.

To install it, follow the instructions :

install go (if you don't have it already)

run `sudo apt-get -y install golang-go`

and then run `go install github.com/mailhog/MailHog`

to start the server run `~/go/bin/MailHog`
and go to http://localhost:8025 to see the mails

## after pulling new changes

run `composer install` to install all dependencies

run `php bin/console doctrine:migrations:migrate` to update the database tables

run `yarn install` to install all dependencies


