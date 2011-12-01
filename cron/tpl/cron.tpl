<!-- BEGIN: CRON -->

	<div class="error">{CRON_ERROR}</div>
	
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
			<td>{CRON_ROW_FIRSTRUN}</td>
			<td>{CRON_ROW_DELAY}</td>
			<td>{CRON_ROW_LASTRUN}</td>
			<td>{CRON_ROW_NEXTRUN}</td>
			<td>{CRON_ROW_MODE}</td>
			<td>{CRON_ROW_TRIGGER}</td>
			<td><a href="{CRON_ROW_DELETE}"><img src="images/admin/delete.gif" alt="x" title="{PHP.L.Delete}" /></a></td>
		</tr>
		<!-- END: CRON_ROW -->
	</table>

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
			<td>{CRON_ADD_FORM_FIRSTRUN} {PHP.L.GMT}</td>
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
			<td>{CRON_ADD_FORM_SUBMIT}</td>
		</tr>
	</table>
	</form>
	<!-- BEGIN: CRON_ADD_FORM -->

<!-- END: CRON -->