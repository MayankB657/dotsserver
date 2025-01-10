#!/bin/bash

# Define paths
PHP_PATH="/usr/local/bin/ea-php82"
ARTISAN_PATH="/home/sizafcom/desktop2.sizaf.com/artisan"
LOG_PATH="/home/sizafcom/desktop2.sizaf.com/storage/logs/queue_worker.log"

# Run Laravel queue:work command and log output
$PHP_PATH $ARTISAN_PATH queue:work --stop-when-empty >> $LOG_PATH 2>&1
