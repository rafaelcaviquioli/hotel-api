# Hotel API - Coding Challenge

[Repository available on Gitlab: https://gitlab.com/rafaelcaviquioli/hotel-api](https://gitlab.com/rafaelcaviquioli/hotel-api)

#### 1. Start docker services

```bash
$ docker-compose up -d
```

#### 2. Apply the database migrations

```bash
$ docker-compose exec php-fpm bin/console doctrine:migrations:migrate -n
```

#### 3. OpenAPI Specification

- [http://localhost:8000/api/doc](http://localhost:8000/api/doc)


#### 4. Run unit tests

```bash
$ docker-compose run php-fpm php bin/phpunit
```