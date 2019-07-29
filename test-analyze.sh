#!/usr/bin/env bash

php ./vendor/bin/phpunit -c ./phpunit.xml --coverage-html ./var/coverage --log-junit ./var/junit.xml
php ./vendor/bin/phpmetrics --report-html=./var/phpmetrics --git --junit=./var/junit.xml --exclude=vendor,tests,resources .
