# REST API

## Requirements

In order to run this project you just only have Docker and Docker-compose installed.

## Up & Running

Once you have cloned the project run:
> docker-compose up

> docker exec -it Laravel_php bash -c "composer install"

> docker exec -it Laravel_php bash -c "chmod -R 777 -R ./storage/."

To enter inside the project run:
> docker exec -it Laravel_php bash

You can access the customer phones view through:
> http://localhost:8000/customer/phones

## Unit-Test

To run the tests you can run:
> docker exec -it Laravel_php bash -c "vendor/bin/phpunit"
