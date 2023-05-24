# sf_crm

## Run project

### Set .env file for docker

```sh
cp docker/.env.dist docker/.env
```

### Run docker containers

```sh
cd docker && docker-compose up -d
```

### Generate jwt keypair

```sh
cd docker && docker-compose exec php ./bin/console lexik:jwt:generate-keypair
```

### Generate test data

```sh
cd docker && docker-compose exec php ./bin/console hautelook:fixtures:load -n
```

### Create openapi file

```sh
cd docker && docker-compose exec php ./bin/console api:openapi:export >> open_api.json && mv open_api.json ../open_api.json
```

### Documentation - open_api.json

[Documentation](open_api.json)

## Tests

### Run all tests

```sh
cd docker && docker-compose exec php composer tests
```

### Run phpunits

```sh
cd docker && docker-compose exec php composer phpunit
```

### Run rector

```sh
cd docker && docker-compose exec php composer rector
```

### Run phpstan

```sh
cd docker && docker-compose exec php composer phpstan
```

### Run csfixer

```sh
cd docker && docker-compose exec php composer csfix
```
