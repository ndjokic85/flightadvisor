# Flightadvisor

Create Flight advisor API for finding the cheapest flights.

## Prerequisite

- Install Docker on Linux (https://docs.docker.com/engine/install/ubuntu)
- Install docker on Windws (https://docs.docker.com/desktop/windows/install)

## Setup

- Git clone https://github.com/ndjokic85/flightadvisor.git
- Run docker-compose up --build on terminal
- Copy env.example to .env
- Run docker-compose exec app bash
- Run composer install
- Run php artisan migrate:fresh --seed
- Default admin user credentials:
  - username: admin
  - password: admin123

## Notes

- Check application/tests/Feature for tests
- Run tests with ./vendor/bin/phpunit
- City can be created only for existing countries (Seeder will seed default countries table)
- Airport upload data will be inserted only for existing Cities
- Routes upload data will be inserted for existing Airports
- IMPORTANT - When you upload routes or airports files via api run 'php artisan queue:work' to trigger queue job process

## Further improvements

- Optimisation queue job with docker
- Write api contract document using swagger for example
- Cover code with more test cases
- Generate admin user via console (not via seeder)
