# Field 	        Allowed Values
# minute 	        0-59
# hour 	            0-23
# Day of the month 	1-31
# month 	        1-12 or JAN-DEC
# Day of the week 	0-6 or SUN-SAT
# Shortcut 	Shorthand for
# @hourly 	0 * * * *
# @daily 	0 0 * * *
# @weekly 	0 0 * * 0
# @monthly 	0 0 1 * *
# @yearly 	0 0 1 1 *
# Options
# Minute hour day_of_month month day_of_week command_to_run

0 0 * * * docker exec laravel_app_1 bash -c "php /var/www/html/artisan product:price update"