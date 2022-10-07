#!/usr/bin/env bash

PHP_IDE_CONFIG="serverName=_" php -c /usr/local/etc/php/php-dev.ini -d xdebug.start_with_request=yes "$@"
