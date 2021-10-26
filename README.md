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

## API

### Customers

```
# List
[GET] api/customers
# Detail
[GET] api/customers/{id}
# Create [only for Project Manager]
[POST] api/customers (fields: name)
# Update [only for Project Manager]
[PATCH] api/customers/{id} (fields: name, customer)
```

### Projects

```
# List
[GET] api/projects
# Detail
[GET] api/projects/{id}
# Create [only for Project Manager]
[POST] api/projects (fields: name, customer)
# Update [only for Project Manager]
[PATCH] api/projects/{id} (fields: name, customer)
```

### Tasks

```
# List
[GET] api/tasks
# Detail
[GET] api/tasks/{id}
# Create [only for Project Manager]
[POST] api/tasks (fields: name, description, project, status, priority, [user])
# Update [only for Project Manager]
[PATCH] api/tasks/{id} (fields: name, description, project, status, priority, [user])
# Assign user [only for Project Manager]
[PATCH] api/tasks/{id}/assign (fields: user)
# Change status [only for Developer]
[PATCH] api/tasks/{id}/status (fields: status)
```
