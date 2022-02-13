# 🕹 ScoreCard

ScoreCard is an application made in Symfony to display and keep track of your scores and those of your teammates for any game!

## Setup

1. `docker-compose up --build -d`
1. `yarn encore dev --watch`

In Docker shell :

1. `docker-compose exec php /bin/bash`
1. `composer install`

## Build

1. `yarn encore production `

## Cron Jobs
Consume Symfony Messenger (Every 5 minutes)

   `php bin/console messenger:consume async --memory-limit=128M --time-limit=270`