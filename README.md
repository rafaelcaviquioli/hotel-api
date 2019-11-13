# Hotel API - Coding Challenge

[Repository available on Gitlab: https://gitlab.com/rafaelcaviquioli/hotel-api](https://gitlab.com/rafaelcaviquioli/hotel-api)

#### 1. Install composer dependencies

```bash
$ docker-compose build
```

#### 2. Install composer dependencies

```bash
$ docker-compose run --rm php-fpm composer install
```

#### 3. Start docker services

```bash
$ docker-compose up -d
```

#### 4. Apply the database migrations

```bash
$ docker-compose run --rm php-fpm bin/console doctrine:migrations:migrate -n
```

#### 5. OpenAPI Specification

- [http://localhost:8000/api/doc](http://localhost:8000/api/doc)


#### 6. Run unit tests

```bash
$ docker-compose run --rm php-fpm php bin/phpunit
```
