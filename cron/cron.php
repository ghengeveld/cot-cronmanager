<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

$cfg['display_errors'] = true;
defined('COT_CODE') or die("Wrong URL.");

require_once cot_incfile('cron', 'plug');
require_once cot_langfile('cron', 'plug');

switch ($a)
{
	case 'add':
		$cron_title = cot_import('cron_title', 'P', 'TXT');
		$cron_script = cot_import('cron_script', 'P', 'TXT');
		$cron_delay = cot_import('cron_delay', 'P', 'INT');
		$cron_mode = cot_import('cron_mode', 'P', 'ALP');
		$cron_trigger = cot_import('cron_trigger', 'P', 'ALP');
		$cron_firstrun = cot_import_date('cron_firstrun');

		if (strlen($cron_title) < 2)
			cot_error('error_title', 'cron_title');
		if (strlen($cron_script) < 5)
			cot_error('error_script', 'cron_script');
		if (!$cron_firstrun)
			cot_error('error_date');

		!cot_error_found() && cron_add(
			$cron_title, $cron_script, $cron_delay, 
			$cron_mode, $cron_trigger, $cron_firstrun
		);
		cot_redirect(cot_url('admin', 'm=other&p=cron'), '', true);
		break;

	case 'delete':
		cron_remove($id);
		cot_redirect(cot_url('admin', 'm=other&p=cron'), '', true);
		break;
	
	case 'deleteall':
		cron_remove_all();
		cot_redirect(cot_url('admin', 'm=other&p=cron'), '', true);
		break;
}

// Display records
$t = new XTemplate(cot_tplfile('cron', 'plug'));
cot_display_messages($t);

$res = $db->query("SELECT * FROM $db_cron")->fetchAll();
foreach ($res as $row)
{
	if(!file_exists($row['cron_script'])) $row['cron_script'] = '<span class="error">! '.$row['cron_script'].'</span>';
	
	$t->assign(array(
		"CRON_ROW_TITLE" => $row['cron_title'],
		"CRON_ROW_SCRIPT" => $row['cron_script'],
		"CRON_ROW_FIRSTRUN" => $row['cron_firstrun'],
		"CRON_ROW_DELAY" => cot_build_timegap(0, $row['cron_delay']),
		"CRON_ROW_LASTRUN" => $row['cron_lastrun'],
		"CRON_ROW_NEXTRUN" => $row['cron_nextrun'],
		"CRON_ROW_MODE" => $L['mode_'.$row['cron_mode']],
		"CRON_ROW_TRIGGER" => $row['cron_trigger'],
		"CRON_ROW_DELETE" => cot_url('admin', 'm=other&p=cron&a=delete&id='.$row['cron_id'])
	));
	$t->parse("CRON.CRON_ROW");
}

// Add new record
require_once cot_incfile('forms');

$delayoptions = array(3600, 7200, 14400, 21600, 43200, 86400, 604800, 1209600, 2419200, 15768000, 31536000);
$delaytitles = array();
foreach ($delayoptions as $option)
{
	$delaytitles[] = cot_build_timegap(0, $option);	
}
$triggeroptions = array('header', 'index', 'admin');

$t->assign(array(
	"CRON_ADD_FORM_URL" => cot_url('admin', 'm=other&p=cron&a=add'),
	"CRON_ADD_FORM_TITLE" => cot_inputbox('text', 'cron_title', $cron_title, 'size="52" maxlength="32"'),
	"CRON_ADD_FORM_SCRIPT" => cot_inputbox('text', 'cron_script', $cron_script, 'size="52" maxlength="255"'),
	"CRON_ADD_FORM_FIRSTRUN" => cot_selectbox_date($sys['now'], 'long', 'cron_firstrun'),
	"CRON_ADD_FORM_DELAY" => cot_selectbox($delayoptions[0], 'cron_delay', $delayoptions, $delaytitles, false),
	"CRON_ADD_FORM_MODE" => cot_selectbox('normal', 'cron_mode', array('normal', 'strict'), array($L['mode_normal'], $L['mode_strict']), false),
	"CRON_ADD_FORM_TRIGGER" => cot_selectbox($triggeroptions[0], 'cron_trigger', $triggeroptions, $triggeroptions, false)
));
$t->parse("CRON");

$plugin_body = $t->text("CRON");

?>