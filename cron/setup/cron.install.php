<?php

defined('COT_CODE') or die('Wrong URL');

$db->query("
	CREATE TABLE IF NOT EXISTS {$db_x}cron (
		cron_id INT NOT NULL auto_increment,
		cron_realm VARCHAR(32) NOT NULL default 'cron',
		cron_title VARCHAR(32) NOT NULL,
		cron_script VARCHAR(255) NOT NULL,
		cron_delay INT NOT NULL,
		cron_mode VARCHAR(6) NOT NULL default 'normal',
		cron_trigger VARCHAR(32) NOT NULL default 'header',
		cron_firstrun INT NOT NULL,
		cron_lastrun INT NOT NULL default '0',
		cron_nextrun INT NOT NULL,
		PRIMARY KEY (cron_id)
	) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
");

?>