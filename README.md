## Dark Sky API Weather App
- [By Jamie Evans]

## Set up and instructions

- [clone repository]
- [cd into project dir]
- [composer install and download/install dependancies]
- [npm install if you need]
- [set up a local database and copy .env.example and rename to .env]
- [in .env add your database name, username, password and host - also include Google API Key and DarkSky API Key - this includes your email information]
- [run migrations - (php artisan migrate)]
- [php artisan server - or set on on vhost/server]
- [application uses commands and scheduling so set up cron on server]
- [[* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1] - this will run commands as schedules time]
- [register as new user]
- [enjoy]