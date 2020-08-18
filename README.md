## Environment installation

- run ```cp .env.example .env```
- configure ```.env```
- run ```docker-compose up -d```
- run ```composer install``` (command can be launched from fpm container, bash and composer included to fpm container)

## Application configure
- run bd schema creation ```php bin/console orm:schema-tool:create```
- run ```php bin/console fetch:trailers``` to import data
