#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

cd /app

if [ ! -d "vendor" ]; then
    composer install
fi

if [ "$role" = "app" ]; then

    php artisan octane:start --port=8000 --admin-port=2022

elif [ "$role" = "queue" ]; then

    echo "Running the queue..."
    php artisan queue:work --verbose --tries=3 --timeout=90

elif [ "$role" = "reverb" ]; then

    echo "Running reverb..."
    php artisan reverb:start --debug

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
