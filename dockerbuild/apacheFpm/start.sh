#!/bin/sh
/usr/local/bin/mailcatcher --ip 0.0.0.0
/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf



