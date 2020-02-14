#!/bin/bash

echo -e "\e[34m=> Unit Tests \e[0m"

./vendor/bin/phpunit --coverage-text
