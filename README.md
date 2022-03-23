## TL;DR
 - Click on the button "Use this template" to get started
 - Select username/organisation and type the repo name, and hit enter
```
git clone git@github.com:your-username/saw-api.git
```
```
cd saw-api
```

Find-and-replace `laravel-` with `saw-`, and update IP address (wherever applicable) in following files:
- `docker-compose.yml`
- `composer.json`
- `.env.example`
- `.env.testing`
- `.circleci/config.yml`

```
docker-compose up --build -d
```
```
docker-compose exec saw-api composer install
```
```
docker-compose exec saw-api composer run dev-setup
```
```
http://220.223.1.1
```


# Full version starts here

## Laravel Boilerplate

This repository is a "template" repository, and is intended to be used to create a new repo.

It contains the basic packages that are required in all projects (almost all), and can be changed as per the requirements of the project.

### Basic requirements for setup
- Git :  [Install git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
    - To clone the repo created using this template repo (or even the boilerplate)
- Docker : [Install docker](https://docs.docker.com/engine/install)
- Docker Compose : [Install docker-compose](https://docs.docker.com/compose/install)

### Using the template to create a new repo

- Click the button on the top that says "Use this template" and on the following page enter the repository name.
- The sample name that we would use is `saw-api` short for `Super Awesome Website - API`
- The URL of the repo would now be : `https://github.com/your-username/saw-api.git`

## Clone and setup the project

### Get the code (clone the repo)

```
git clone git@github.com:your-username/saw-api.git
```


### Enter the folder :
```
cd saw-api
```

### Update service names
_To avoid conflicts with other projects using the same template:_

Update the service and container names (and IP addresses, in network sections) from `laravel-api` to `saw-api` and from `laravel-pg` to `saw-pg` (wherever applicable) in following files:
- `docker-compose.yml`* : Update `service names`, `container names` and `network IP addresses`
- `composer.json`* : Update `container names`
- `.env.example`* : Update `IP address` in `DATABASE_URL`
- `.env.testing`* : Update `IP address` in `DATABASE_URL`
- `.circleci/config.yml` : Update `container names` in run commands

Tip: One simple method of using non-repeatable IPs (almost, non-repeatable) is to use the date format for first 2 octets, and if using the month number makes the octet out of range, then toggle month and date.   

E.g. 
 - `January 13, 2022` could translate to `220.113.1.1`
 - `February 13, 2022` could translate to `220.213.1.1`
 - `March 13, 2022` could NOT translate to `220.313.1.1` (`313` being out of range), so toggle month and date and make it `220.133.1.1`


### Make the docker-compose build and bring up the services, in the background

```
docker-compose up --build -d
```

### Install the boilerplate

- Install composer dependencies
```
docker-compose exec saw-api composer install
```

- Setup development environment
```
docker-compose exec saw-api composer run dev-setup
```

#### The landing page URL should be working now
```
http://220.223.1.1
```

## More details

The dependencies and packages (some of these are mentioned in `composer.json`) are included in the Dockerfile, and are listed below:

### Dependencies:
- PHP 8.1
- JSON extension
- mbstring extension
- openssl extension
- PDO extension (for Postgres and Sqlite)

### Packages:
- fruitcake/laravel-cors : ^2.0
- guzzlehttp/guzzle : ^7.0.1
- laravel/framework : ^8.54
- laravel/sanctum : ^2.11
- laravel/telescope : ^4.6
- laravel/tinker : ^2.5
- sentry/sentry-laravel : ^2.9"


## Core technologies for development
- Language: PHP
- Framework: Laravel
- Database: PostgreSql



### Breakdown of the `docker-compose.yml` file
- Version: 3
- Services:
    - laravel-api
        - Uses the commands mentioned in Dockerfile to build the docker image
        - Uses the same name for container `laravel-api`
        - Requires the DB service (`laravel-pg`) to be up and running
        - The current directory (".") is mapped to the webroot of container, to keep files in sync (file-permissions still might need to be managed manually)
        - Restart the container, so that `docker-compose up` will reflect the changes made in `docker-compose.yml`, and additionally it also ensures that the services are started with the system/daemon start-up (basically, auto-start docker service with system boot-up)
        - Some environment variables are setup already
            - APP_NAME: `'F+L Laravel Boilerplate'`
            - APP_DEBUG: `'true'`
            - APP_URL: `'http://220.223.1.1'`
            - DB_CONNECTION: `'pgsql'`
        - IP address is mentioned (belonging to a specific network)
    - laravel-pg
        - Uses the latest postgres image (from Docker hub)
        - There are 2 environment variables
            - Root password, as `docker`
            - Create secondary DB as `test_db` for PhpUnit test cases
        - Uses the same name for container `laravel-pg`
        - The container's data storage folder is mapped to a volume in host machine; this ensures DB is not deleted when the container is removed
        - IP address is mentioned (belonging to a specific network)
- Volume: Creates a volume on host machine, and is used by `laravel-pg` service to store DB data
- Network : Network specific details (primarily the subnet IP range)
