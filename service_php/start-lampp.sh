#!/usr/bin/env sh
# -------------------------------------------------
#  Load variables from .env.development
# -------------------------------------------------
set -a                     # export every assignment

# source the file – POSIX sh uses '.' (dot) for this
. ./env/.env.development

set +a                     # stop automatic export


# -------------------------------------------------
#  Restart LAMPP so Apache inherits the variables
# -------------------------------------------------
sudo /opt/lampp/lampp restart


# -------------------------------------------------
#  Verify that PHP sees the variables (optional)
# -------------------------------------------------
php -r 'printf(
    "DB_HOST=%s\nDB_USER=%s\nDB_PASS=%s\nDB_NAME=%s\nAPP_MODE=%s\n",
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_NAME"),
    getenv("APP_MODE")
);'

