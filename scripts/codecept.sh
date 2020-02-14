#!/bin/bash

echo -e "\e[34m=> Functional Tests \e[0m"

./vendor/bin/codecept run -c tests/codeception.dist.yml
