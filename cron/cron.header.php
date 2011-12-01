<?PHP
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=cron
Part=header
File=cron.header
Hooks=header.first
Tags=
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

require_once('plugins/cron/inc/runcron.php');

runcron('header');

?>