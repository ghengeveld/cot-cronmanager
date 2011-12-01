# Cron Manager

Cron Manager is a simple passive task scheduler to allow automated script 
execution in Cotonti.

## Features

* Set first run date/time and delay
* Normal or strict mode
* Multiple triggers (header, index or admin)
* Log failed cron jobs
* Skinnable
* Localisable (includes english and dutch)

## Installation

* Upload files
* Install plugin in admin panel

## Usage

* Go to admin > tools > cron manager
* Add a cron job
* Jobs will automatically be executed when the trigger area is visited and the 
  next run time is past due.
* Failed cron jobs (wrong script url) are marked in the jobs overview and will 
  be logged in the Cotonti log (admin > other > system log).

### Notes

This is a **passive** cron manager, meaning that the script will still need to 
be triggered by a visitor. As a result, cron jobs may be executed later than the 
original set execution time. If you want your cron jobs to be executed at 
(roughly) the same time of day, use the Strict mode. Normal mode will result in 
your cron job going out of sync with the first execution time. This is fine for 
regular usage though.

The script URL must be a local file path, starting at the root of your Cotonti 
installation. You can use 'plugins/cron/inc/testcron.php' for testing script 
execution.