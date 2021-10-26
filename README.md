<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Getting started

Copy .env file and update APP_NAME and DB values (don't use root).

```
cp .env.example .env
```

Use Sail for local development.

```
# create alias
alias sail='bash vendor/bin/sail'
# start evironment
sail up -d
# generate key in env file
sail artisan key:generate
# close environment
sail down
```

Init database

```
# create database tables with migrations
sail artisan migrate
# add general data in db (test users and roles)
sail artisan db:seed
# add fake data (customers, projects and tasks)
sail artisan db:seed --class=FakeDataSeeder
```

## Test users

Email Project Manager

```
manager@test.test
```

Email Developers

```
developer@test.test
developer2@test.test
```

all users have default password "password".
