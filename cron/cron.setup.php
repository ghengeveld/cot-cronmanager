<?php
/* ====================
[BEGIN_COT_EXT]
Code=cron
Name=Cron Manager
Description=Automate script execution
Version=2.0
Date=2011-dec-01
Author=Gert Hengeveld
Copyright=Webmojo
Notes=BSD License
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
delayoptions=01:string::3600,7200,14400,21600,43200,86400,604800,1209600,2419200,15768000,31536000:Delay options, in seconds (comma seperated)
triggeroptions=01:string::header,index,admin:Trigger options (comma seperated). Make sure there is a corresponding file.
[END_COT_EXT_CONFIG]
==================== */

/**
 * Automate script execution
 *
 * @package Cron Manager
 * @version 2.0
 * @author Gert Hengeveld
 * @copyright Webmojo
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

?>