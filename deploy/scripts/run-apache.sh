#!/bin/bash

set -e
set -u

echo "Starting ..."

mkdir -p /usr/local/apache2/htdocs/logs/
apachectl -D FOREGROUND
