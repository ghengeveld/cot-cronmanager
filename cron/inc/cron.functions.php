<?php

/**
 * Automate script execution
 *
 * @package Cron Manager
 * @version 1.0
 * @author Koradhil
 * @copyright Webmojo
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$db_cron = $db_x . 'cron';

/**
 * Add a cron job
 *
 * @param string $title Short description
 * @param string $script Path to script file
 * @param int $delay Delay time between executions
 * @param string $mode Cron mode 'normal' or 'strict'
 * @param string $trigger Trigger location 'header', 'index' or 'admin'
 * @param int $firstrun Timestamp of first execution
 * @param string $realm Optional realm name
 * @return bool
 */
function cron_add($title, $script, $delay, $mode, $trigger, $firstrun, $realm = 'cron')
{
	global $db, $db_cron;
	if (in_array($mode, array('normal', 'strict')) && in_array($trigger, array('header', 'index', 'admin')))
	{
		return (bool)$db->insert($db_cron, array(
			'cron_realm' => $realm,
			'cron_title' => $title,
			'cron_script' => $script,
			'cron_delay' => (int)$delay,
			'cron_mode' => $mode,
			'cron_trigger' => $trigger,
			'cron_firstrun' => (int)$firstrun,
			'cron_nextrun' => (int)$firstrun
		));
	}
	return false;
}

/**
 * Remove a cron job
 *
 * @param int $id Cron ID
 * @return bool
 */
function cron_remove($id)
{
	global $db, $db_cron;
	return (bool)$db->delete($db_cron, 'cron_id = ?', array($id));
}

/**
 * Remove all cron jobs from a realm
 *
 * @param string $realm Realm name
 * @return bool
 */
function cron_remove_realm($realm)
{
	global $db, $db_cron;
	return (bool)$db->delete($db_cron, 'cron_realm = ?', array($realm));
}

/**
 * Remove all cron jobs
 *
 * @return bool
 */
function cron_remove_all()
{
	global $db, $db_cron;
	return (bool)$db->delete($db_cron);
}

/**
 * Runs jobs that are due to be executed
 *
 * @param string $trigger Location trigger code 'header', 'index' or 'admin'
 * @param string $realm Execute only jobs from a specific realm
 */
function cron_run($trigger, $realm = '')
{
	global $db, $db_cron, $sys;
	
	$andrealm = ($realm) ? "AND cron_realm = :realm" : '';
	$res = $db->query("
		SELECT * FROM $db_cron 
		WHERE cron_trigger = :trigger
		AND cron_nextrun <= :nextrun
		$andrealm
	", array(
		'trigger' => $trigger,
		'nextrun' => $sys['now'],
		'realm' => $realm
	))->fetchAll();
	foreach ($res as $row)
	{
		$cron_lastrun = $sys['now'];
		if ($row['cron_mode'] == 'strict')
		{	
			$nextrun_diff = $time - $row['cron_firstrun'];
			$nextrun_delayfactor = ceil($nextrun_diff / $row['cron_delay']);
			$nextrun_delay = $row['cron_delay'] * $nextrun_delayfactor;
			$cron_nextrun = $row['cron_firstrun'] + $nextrun_delay;
		}
		else
		{
			$cron_nextrun = $cron_lastrun + $row['cron_delay'];
		}
		$db->update($db_cron, 
			array('cron_nextrun' => $cron_nextrun, 'cron_lastrun' => $cron_lastrun), 
			"cron_id = ?", array($row['cron_id'])
		);
		if (file_exists($row['cron_script']))
		{
			include_once($row['cron_script']);
		}
		else
		{
			cot_log("Failed to execute CRON #".$row['cron_id'].", script file not found. Trigger: $trigger", 'plg');
		}
	}
}

?>