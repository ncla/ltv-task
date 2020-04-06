### Setup

We use [Laradock](https://laradock.io/getting-started/), make sure you have Docker, Docker compose and Git installed. 

1. Clone this repository with `--recursive` flag to install Laradock submodule too: `git clone --recursive git@github.com:ncla/ltv-task.git`
2. Copy example .env file `cp .env.example .env` and put API URL for guides in `LTV_API_URL` env variable
3. Start setting up Docker by navigating to `laradock-ltv` directory
4. `cp env-example .env` to copy default configuration for Laradock
5. Run `docker-compose up -d nginx mysql php-fpm` to spin up Docker. Will take a few minutes on first run.
6. Connect to Docker container to install dependencies and configure Laravel `docker-compose exec --user=laradock workspace bash`. Once connected, run:
    1. `composer install`
    2. `npm install`
    3. `npm run prod`
    4. `php artisan key:generate`
    5. `php artisan migrate`
    6. `php artisan ltv:update` to update television guides
7. Visit http://localhost to view the project

You should be able to see television guide without running update command manually since the Docker container runs Laravel scheduler every minute to update the guide