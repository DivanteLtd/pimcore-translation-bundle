#!/bin/bash

set -eu

PROJECT_DIR="$( cd "$(dirname "$0")" ; pwd -P )/../tmp"
DEPENDENCIES="$( cd "$(dirname "$0")" ; pwd -P )/dependencies.txt"

PACKAGE_NAME="GoogleTranslateBundle"
BUNDLE_NAME="GoogleTranslateBundle"

CREATE_DB=${CREATE_DB-true}
DB_HOST=${DB_HOST-localhost}
DB_PORT=${DB_PORT-3306}
DB_USERNAME=${DB_USERNAME-root}
DB_PASSWORD=${DB_PASSWORD-root}
DB_DATABASE=${DB_DATABASE-pimcore_test}

echo -e "\e[34m=> Start installing project \e[0m"

echo -e "\e[32m=> Clean old project files \e[0m"
rm -rf $PROJECT_DIR

echo -e "\e[32m=> Cloning Pimcore Skeleton \e[0m"
git clone https://github.com/pimcore/skeleton.git $PROJECT_DIR

echo -e "\e[32m=> Copy package to project \e[0m"
cp -r src/$PACKAGE_NAME $PROJECT_DIR/src/
cp -r tests $PROJECT_DIR/tests/
cp -r phpunit.xml $PROJECT_DIR/phpunit.xml
cp -r composer.json $PROJECT_DIR/composer.local.json
cp -r scripts/ $PROJECT_DIR/scripts
cp -r scripts/config_test.yml $PROJECT_DIR/app/config/config_test.yml

cd $PROJECT_DIR

echo -e "\e[32m=> Install dependencies \e[0m"
COMPOSER_DISCARD_CHANGES=true COMPOSER_MEMORY_LIMIT=-1 composer install --no-interaction --optimize-autoloader

MYSQL_COMMAND="mysql"
INSTALL_COMMAND="vendor/bin/pimcore-install --ignore-existing-config --admin-username admin --admin-password admin"

if ! test -z "$DB_HOST"
then
    MYSQL_COMMAND="$MYSQL_COMMAND --host=$DB_HOST"
    INSTALL_COMMAND="$INSTALL_COMMAND --mysql-host-socket $DB_HOST"
fi

if ! test -z "$DB_PORT"
then
    MYSQL_COMMAND="$MYSQL_COMMAND --port=$DB_PORT"
    INSTALL_COMMAND="$INSTALL_COMMAND --mysql-port $DB_PORT"
fi

if ! test -z "$DB_USERNAME"
then
    MYSQL_COMMAND="$MYSQL_COMMAND --user=$DB_USERNAME"
    INSTALL_COMMAND="$INSTALL_COMMAND --mysql-username $DB_USERNAME"
fi

if ! test -z "$DB_PASSWORD"
then
    MYSQL_COMMAND="$MYSQL_COMMAND --password=$DB_PASSWORD"
    INSTALL_COMMAND="$INSTALL_COMMAND --mysql-password $DB_PASSWORD"
fi

MYSQL_COMMAND="$MYSQL_COMMAND -e "\""DROP DATABASE IF EXISTS $DB_DATABASE; CREATE DATABASE $DB_DATABASE CHARSET=utf8mb4;"\"""
INSTALL_COMMAND="$INSTALL_COMMAND --mysql-database $DB_DATABASE --no-debug --no-interaction"

if $CREATE_DB = true
then
    echo -e "\e[32m=> Create Database \e[0m"
    bash -c "$MYSQL_COMMAND"
fi

echo -e "\e[32m=> Install Pimcore \e[0m"
echo $INSTALL_COMMAND
bash -c "$INSTALL_COMMAND"

echo -e "\e[32m=> Enable Bundles \e[0m"
while read -r line; do
    bin/console pimcore:bundle:enable $line -n
done < $DEPENDENCIES

bin/console pimcore:bundle:enable $BUNDLE_NAME -n

echo -e "\e[32m=> Done! \e[0m"
