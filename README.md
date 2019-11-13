# Hotel API - Coding Challenge

[Repository available on Gitlab: https://gitlab.com/rafaelcaviquioli/hotel-api](https://gitlab.com/rafaelcaviquioli/hotel-api)

#### 1. Install composer dependencies

```bash
$ docker-compose exec php-fpm composer install
```

#### 2. Start docker services

```bash
$ docker-compose up -d
```

#### 3. Apply the database migrations

```bash
$ docker-compose exec php-fpm bin/console doctrine:migrations:migrate -n
```

#### 4. OpenAPI Specification

- [http://localhost:8000/api/doc](http://localhost:8000/api/doc)


#### 5. Run unit tests

```bash
$ docker-compose run php-fpm php bin/phpunit
```

#### 6. Run Phpstan

```bash
$ docker-compose run php-fpm vendor/bin/phpstan analyse src
```