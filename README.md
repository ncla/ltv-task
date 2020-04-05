### Setup

We use [Laradock](https://laradock.io/getting-started/), make sure you have Docker, Docker compose and Git installed. 

1. Clone this repository
2. Copy example .env file `cp .env.example .env`
3. Start setting up Docker by navigating to `laradock-ltv` directory
4. `cp env-example .env` to copy default configuration for Laradock
5. Run `docker-compose up -d nginx mysql php-fpm` to spin up Docker. Will take a few minutes on first run.
6. Connect to Docker container to install dependencies `docker-compose exec --user=laradock workspace bash`
    1. `composer install`, `npm install`, `npm run prod`
7. Visit http://localhost to view the project