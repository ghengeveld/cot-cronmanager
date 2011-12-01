<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die("Wrong URL.");

require_once cot_incfile('cron', 'plug');

cron_run('admin');

?>