<?PHP
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=cron
Part=admin
File=cron
Hooks=tools
Tags=cron.tpl:{CRON_ERROR}
Order=10
[END_SED_EXTPLUGIN]
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

defined('SED_CODE') or die("Wrong URL.");

require_once('plugins/cron/inc/config.php');
$t = new XTemplate(sed_skinfile('cron', true));

function formatTime($secs)
{
	global $L;
	$units = array(
		"year"      =>     365*24*3600,
		"half-year" => (365*24*3600)/2,
		"week"      =>       7*24*3600,
		"day"       =>         24*3600,
		"hour"      =>            3600,
		"minute"    =>              60,
		"second"    =>               1,
	);
	if ($secs == 0) return "-";
	$s = "";
	foreach ($units as $name => $divisor)
	{
		if ($quot = intval($secs / $divisor))
		{
			$name .= (abs($quot) > 1) ? 's' : '';
			$s .= $quot.' '.$L[$name].', ';
			$secs -= $quot * $divisor;
		}
	}
	return substr($s, 0, -2);
}

if($a=='add')
{
	$cron_title = sed_import('cron_title','P','TXT');
	$cron_script = sed_import('cron_script','P','TXT');
	
	$ryear_firstrun = sed_import('ryear_firstrun','P','INT');
	$rmonth_firstrun = sed_import('rmonth_firstrun','P','INT');
	$rday_firstrun = sed_import('rday_firstrun','P','INT');
	$rhour_firstrun = sed_import('rhour_firstrun','P','INT');
	$rminute_firstrun = sed_import('rminute_firstrun','P','INT');
	
	$cron_delay = sed_import('cron_delay','P','INT');
	$cron_mode = sed_import('cron_mode','P','ALP');
	$cron_trigger = sed_import('cron_trigger','P','ALP');
	
	$cron_firstrun = sed_mktime($rhour_firstrun, $rminute_firstrun, 0, $rmonth_firstrun, $rday_firstrun, $ryear_firstrun);
	
	$error_string .= (strlen($cron_title)<2) ? $L['error_title']."<br />" : '';
	$error_string .= (strlen($cron_script)<5) ? $L['error_script']."<br />" : '';
	$error_string .= (!checkdate($rmonth_firstrun,$rday_firstrun,$ryear_firstrun)) ? $L['notthatmanydays']."<br />" : '';
	
	if(empty($error_string))
	{	
		sed_sql_query("INSERT INTO $db_cron (cron_title, cron_script, cron_delay, cron_mode, cron_trigger, cron_firstrun, cron_lastrun, cron_nextrun) VALUES ('$cron_title', '$cron_script', '$cron_delay', '$cron_mode', '$cron_trigger', '$cron_firstrun', '0', '$cron_firstrun')");
	}
}

if($a=='delete' && !empty($id))
{
	sed_sql_query("DELETE FROM $db_cron WHERE cron_id=".(int)$id);
}

// Display records
$sql = sed_sql_query("SELECT * FROM $db_cron");
while($row = sed_sql_fetcharray($sql))
{
	$row['cron_firstrun'] = ($row['cron_firstrun']==0) ? '-' : date($cfg['dateformat'], $row['cron_firstrun']).' '.$L['GMT'];
	$row['cron_lastrun'] = ($row['cron_lastrun']==0) ? '-' : date($cfg['dateformat'], $row['cron_lastrun']).' '.$L['GMT'];
	$row['cron_nextrun'] = ($row['cron_nextrun']==0) ? '-' : date($cfg['dateformat'], $row['cron_nextrun']).' '.$L['GMT'];
	if(!file_exists($row['cron_script'])) $row['cron_script'] = '<span class="error">! '.$row['cron_script'].'</span>';
	
	$t -> assign(array(
		"CRON_ROW_TITLE" => $row['cron_title'],
		"CRON_ROW_SCRIPT" => $row['cron_script'],
		"CRON_ROW_FIRSTRUN" => $row['cron_firstrun'],
		"CRON_ROW_DELAY" => formatTime($row['cron_delay']),
		"CRON_ROW_LASTRUN" => $row['cron_lastrun'],
		"CRON_ROW_NEXTRUN" => $row['cron_nextrun'],
		"CRON_ROW_MODE" => $row['cron_mode'],
		"CRON_ROW_TRIGGER" => $row['cron_trigger'],
		"CRON_ROW_DELETE" => 'admin.php?m=tools&amp;p=cron&amp;a=delete&amp;id='.$row['cron_id']
	));
	$t -> parse("CRON.CRON_ROW");
}

// Add new record
$cron_add_form_firstrun = sed_selectbox_date($sys['now_offset'], 'long', '_firstrun');
$delayoptions = explode(',', $cfg['plugin']['cron']['delayoptions']);
$triggeroptions = explode(',', $cfg['plugin']['cron']['triggeroptions']);

$cron_add_form_delay = '<select name="cron_delay">';
foreach($delayoptions as $delay)
{
	$cron_add_form_delay .= '<option value="'.$delay.'">'.formatTime($delay).'</option>';
}
$cron_add_form_delay .= '</select>';
$cron_add_form_mode = '<select name="cron_mode">';
$cron_add_form_mode .= '<option value="normal">Normal</option><option value="strict">Strict</option>';
$cron_add_form_mode .= '</select>';
$cron_add_form_trigger = '<select name="cron_trigger">';
foreach($triggeroptions as $trigger)
{
	$cron_add_form_trigger .= "<option value=\"$trigger\">$trigger</option>";
}
$cron_add_form_trigger .= '</select>';

$t -> assign(array(
	"CRON_ADD_FORM_URL" => 'admin.php?m=tools&amp;p=cron&amp;a=add',
	"CRON_ADD_FORM_TITLE" => '<input type="text" name="cron_title" size="52" maxlength="32" value="'.$cron_title.'" />',
	"CRON_ADD_FORM_SCRIPT" => '<input type="text" name="cron_script" size="52" maxlength="255" value="'.$cron_script.'" />',
	"CRON_ADD_FORM_FIRSTRUN" => $cron_add_form_firstrun,
	"CRON_ADD_FORM_DELAY" => $cron_add_form_delay,
	"CRON_ADD_FORM_MODE" => $cron_add_form_mode,
	"CRON_ADD_FORM_TRIGGER" => $cron_add_form_trigger,
	"CRON_ADD_FORM_SUBMIT" => '<input type="submit" value="'.$L['Submit'].'">'
));

$t -> assign(array("CRON_ERROR" => $error_string));
$t -> parse("CRON");

$plugin_body = $t -> text("CRON");

?>