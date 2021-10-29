<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Initial config

Follow the guide here [Start Laravel Project](https://github.com/falconandrea/start-laravel-project/blob/main/README.md)

## Init database

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
[PATCH] api/customers/{id} (fields: name)
```

### Projects

```
# List
[GET] api/projects
# Detail
[GET] api/projects/{id}
# Create [only for Project Manager]
[POST] api/projects (fields: name, customer_id)
# Update [only for Project Manager]
[PATCH] api/projects/{id} (fields: name, customer_id)
```

### Tasks

```
# List
[GET] api/tasks
# Detail
[GET] api/tasks/{id}
# Create [only for Project Manager]
[POST] api/tasks (fields: name, description, project_id, status, priority, [user_id])
# Update [only for Project Manager]
[PATCH] api/tasks/{id} (fields: name, description, project_id, status, priority, [user_id])
# Assign user [only for Project Manager]
[PATCH] api/tasks/{id}/assign (fields: user_id)
# Change status [only for Developer]
[PATCH] api/tasks/{id}/status (fields: status)
```
