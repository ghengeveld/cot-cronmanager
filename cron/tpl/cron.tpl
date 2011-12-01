<!-- BEGIN: CRON -->

	{FILE "./{PHP.cfg.themes_dir}/{PHP.theme}/warnings.tpl"}
	
	<table class="cells">
		<tr>
			<td class="coltop">{PHP.L.Title} / {PHP.L.ScriptURL}</td>
			<td class="coltop">{PHP.L.FirstRun}</td>
			<td class="coltop">{PHP.L.RunsEvery}</td>
			<td class="coltop">{PHP.L.LastRun}</td>
			<td class="coltop">{PHP.L.NextRun}</td>
			<td class="coltop">{PHP.L.Mode}</td>
			<td class="coltop">{PHP.L.Trigger}</td>
			<td class="coltop"></td>
		</tr>
		<!-- BEGIN: CRON_ROW -->
		<tr>
			<td>{CRON_ROW_TITLE}<br /><span class="small">{CRON_ROW_SCRIPT}</span></td>
			<td>{CRON_ROW_FIRSTRUN|cot_date('datetime_medium', $this)}</td>
			<td>{CRON_ROW_DELAY}</td>
			<td><!-- IF {CRON_ROW_LASTRUN} > 0 -->{CRON_ROW_LASTRUN|cot_date('datetime_medium', $this)}<!-- ELSE -->-<!-- ENDIF --></td>
			<td>{CRON_ROW_NEXTRUN|cot_date('datetime_medium', $this)}</td>
			<td>{CRON_ROW_MODE}</td>
			<td>{CRON_ROW_TRIGGER}</td>
			<td><a href="{CRON_ROW_DELETE}"><img src="images/admin/delete.gif" alt="x" title="{PHP.L.Delete}" /></a></td>
		</tr>
		<!-- END: CRON_ROW -->
	</table>

	<p>Current time: {PHP.sys.now|cot_date('datetime_medium', $this)}</p>

	<!-- BEGIN: CRON_ADD_FORM -->
	<h3>{PHP.L.AddNewCron}</h3>
	<form action="{CRON_ADD_FORM_URL}" method="post">
	<table>
		<tr>
			<td>{PHP.L.Title}:</td>
			<td>{CRON_ADD_FORM_TITLE}</td>
		</tr>
		<tr>
			<td>{PHP.L.ScriptURL}:</td>
			<td>{CRON_ADD_FORM_SCRIPT}</td>
		</tr>
		<tr>
			<td>{PHP.L.FirstRun}:</td>
			<td>{CRON_ADD_FORM_FIRSTRUN}</td>
		</tr>
		<tr>
			<td>{PHP.L.RunsEvery}:</td>
			<td>{CRON_ADD_FORM_DELAY}</td>
		</tr>
		<tr>
			<td>{PHP.L.Mode}:</td>
			<td>{CRON_ADD_FORM_MODE}</td>
		</tr>
		<tr>
			<td>{PHP.L.Trigger}:</td>
			<td>{CRON_ADD_FORM_TRIGGER}</td>
		</tr>
		<tr>
			<td></td>
			<td><button type="submit">{PHP.L.Submit}</button></td>
		</tr>
	</table>
	</form>
	<!-- BEGIN: CRON_ADD_FORM -->

<!-- END: CRON -->