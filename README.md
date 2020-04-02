### Setup

We use [Laradock](https://laradock.io/getting-started/), make sure you have Docker and Git installed. 

1. Clone this project
2. Navigate to `laradock-ltv` directory
3. `cp env-example .env` to copy default configuration for Laradock
4. Run `docker-compose up -d nginx mysql php-fpm` to spin up the project. Will take a few minutes on first run.
5. Visit http://localhost to view the project