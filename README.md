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

### Create openapi file

```sh
cd docker && docker-compose exec php ./bin/console api:openapi:export >> open_api.json && mv open_api.json ../open_api.json
```

### Check documentation

[Documentation](open_api.json)

## Tests

### Run phpunits

```sh
cd docker && docker-compose exec php composer phpunit
```
