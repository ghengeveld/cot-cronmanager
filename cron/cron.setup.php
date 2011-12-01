<?PHP
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=cron
Name=Cron Manager
Description=Automate script execution
Version=1.0
Date=2009-sep-03
Author=Koradhil
Copyright=Webmojo
Notes=BSD License
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
delayoptions=01:string::3600,7200,14400,21600,43200,86400,604800,1209600,2419200,15768000,31536000:Delay options, in seconds (comma seperated)
triggeroptions=01:string::header,index,admin:Trigger options (comma seperated). Make sure there is a corresponding file.
[END_SED_EXTPLUGIN_CONFIG]
==================== */

/**
 * Automate script execution
 *
 * @package Cron Manager
 * @version 1.0
 * @author Koradhil
 * @copyright Webmojo
 * @license BSD
 */

defined('SED_CODE') or die('Wrong URL');

if($action == 'install')
{
	require_once("plugins/cron/inc/config.php");
	
	sed_sql_query("
	CREATE TABLE IF NOT EXISTS $db_cron
	(
		cron_id int(11) NOT NULL auto_increment,
		cron_title varchar(32) NOT NULL,
		cron_script varchar(255) NOT NULL,
		cron_delay int(11) NOT NULL,
		cron_mode varchar(6) NOT NULL default 'normal',
		cron_trigger varchar(32) NOT NULL default 'header',
		cron_firstrun int(11) NOT NULL,
		cron_lastrun int(11) NOT NULL,
		cron_nextrun int(11) NOT NULL,
		PRIMARY KEY (cron_id)
	)
	ENGINE=MyISAM 
	DEFAULT CHARSET=utf8 
	COLLATE=utf8_unicode_ci
	");
}

?>