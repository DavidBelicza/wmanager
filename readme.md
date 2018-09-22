
# Warehouse Manager Test

## Non-Docker

### Requirements

* PHP 7.2
* Composer


```
cd /path/to/project/root/directory/src
composer install
php vendor/bin/phpunit
```

## Docker

### Requirements

* Docker
* Docker-Compose

### Run

```
cd /path/to/project/root/directory
docker-compose up
```

### Rebuild

```
docker stop david_wd_backend
docker rm david_wd_backend
cd /path/to/project/root/directory
docker-compose build
docker-compose up
```

### Test

```
docker exec -i -t david_wd_backend php vendor/bin/phpunit
```
