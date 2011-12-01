<?PHP

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

require_once('plugins/cron/inc/config.php');

function runcron($trigger)
{
	global $db_cron;
	global $sys;
	
	$cron_sql = sed_sql_query("SELECT * FROM $db_cron WHERE cron_trigger='$trigger' AND cron_nextrun<='".$sys['now_offset']."'");
	while($cron_row = sed_sql_fetcharray($cron_sql))
	{
		$cron_lastrun = $sys['now_offset'];
		if($cron_row['cron_mode'] == 'strict')
		{	
			$nextrun_diff = $time - $cron_row['cron_firstrun'];
			$nextrun_delayfactor = ceil($nextrun_diff / $cron_row['cron_delay']);
			$nextrun_delay = $cron_row['cron_delay'] * $nextrun_delayfactor;
			$cron_nextrun = $cron_row['cron_firstrun'] + $nextrun_delay;
		}
		else
		{
			$cron_nextrun = $cron_lastrun + $cron_row['cron_delay'];
		}
		sed_sql_query("UPDATE $db_cron SET cron_nextrun='$cron_nextrun', cron_lastrun='$cron_lastrun'");
		if(file_exists($cron_row['cron_script']))
		{
			include_once($cron_row['cron_script']);
		}
		else
		{
			sed_log("Failed to execute CRON #".$cron_row['cron_id'].", script file not found. Trigger: $trigger", 'plg');
		}
	}
}

?>