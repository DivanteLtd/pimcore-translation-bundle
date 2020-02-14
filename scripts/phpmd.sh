#!/bin/bash

echo -e "\e[34m=> PHP DocBlock Checker \e[0m"

vendor/bin/phpdoccheck --directory=src
