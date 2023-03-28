#!/bin/sh

php bin/console doctrine:migrations:migrate
symfony server:start