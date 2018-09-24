#!/usr/bin/env bash

echo "xdebug.remote_host=$(getent hosts host.docker.internal | cut -f1 -d" ")" >> /usr/local/etc/php/conf.d/xdebug.ini

bash -o pipefail -c php-fpm -D | tail -f $LOG_STREAM
