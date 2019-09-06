# Offers

Product Vision of the "Offerts Application" is a REST parser API for offerts .

## Languages

PHP 7

## Frameworks

Symfony 4

## Databases

Mysql 

## Installation

To Run you need to enter the following folder /offers and execute the following commands:

```bash

php bin/console doctrine:database:create

php bin/console doctrine:schema:drop -n -q --force --full-database && rm src/Migrations/*.php && php bin/console make:migration && php bin/console doctrine:migrations:migrate -n -q

php bin/console doctrine:fixtures:load

php bin/console server:start

php bin/console load_read_offer_command

```

## Usage Example

```bash

php bin/console vendor_offers_count  "Vendor 1"

php bin/console date_filter "2019-01-01 00:00:00" "2019-12-01 00:00:00"

php bin/console price_filter 10 30

```
## TEST

Inside the main directory run the command:

```
./vendor/bin/simple-phpunit

```
