# Procfile for the Account Service
#
# Used by Honcho.
#
# To start the application using Honcho,
#   run the "honcho start" command.
#   This will read this Procfile and start all defined processes.

web: gunicorn --workers=1 --bind 0.0.0.0:$PORT --log-level=info service:app
