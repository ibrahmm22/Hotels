# REST API

## Requirements

In order to run this project you just only have Docker and Docker-compose installed.

## Up & Running

Once you have cloned the project run:
> docker run --rm --interactive --tty   --volume $PWD:/app   --user $(id -u):$(id -g)   composer install

> ./vendor/bin/sail sail up -d

> ./vendor/bin/sail artisan migrate --seed



to get access token with the following inputs:
password:password
email:test@gmail.com
>POST http://localhost:8000/api/auth/login

create new hotel:

```json
{
    "name":"test",
    "country":"Egypt",
    "city":"Cairo",
    "price":100,
    "facilities": [
        "num_of_beds",
        "hsjdfsgscsdg"
    ]
}
```
>POST http://localhost:8888/api/hotels

update existing hotel:

```json
{
    "name":"test",
    "country":"Egypt",
    "city":"Cairo",
    "price":100,
    "facilities": [
        "num_of_beds",
        "hsjdfsgscsdg"
    ]
}
```

>PARCH http://localhost:8888/api/hotels/{id}

list hotels:
You can pass sorted method and sorted key as a param:
>GET http://localhost:8000/api/hotels?name=***&country=***&city=**&price=**&sort_key=id&sort_method=asc

Show hotel:

>GET http://localhost:8000/api/hotels/{id}

Delete hotel:

>delete http://localhost:8000/api/hotels/{id}

## Unit-Test

To run the tests you can run:
> ./vendor/bin/sail test
