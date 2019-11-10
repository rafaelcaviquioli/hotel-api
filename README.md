#### Start Application on http://localhost:8000

```bash
docker-compose up -d
```

#### Run unit tests

```bash
$ docker-compose run php-fpm php bin/phpunit
```

#### Open php-fpm console

```bash
$ docker-compose exec php-fpm bash
```