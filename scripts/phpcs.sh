#!/bin/bash

echo -e "\e[34m=> PHP CodeSniffer \e[0m"

vendor/bin/phpcs --config-set colors 1
vendor/bin/phpcs --extensions=php \
    --standard=./vendor/divante-ltd/pimcore-coding-standards/Standards/Pimcore5/ruleset.xml \
    ./src  -s
