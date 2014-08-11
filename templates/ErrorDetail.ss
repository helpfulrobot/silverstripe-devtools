
<div id="content">
	
	<h2>Message</h2>
	<pre>$Error.LatestOccurance.Message</pre>
	
	<h2>Trace</h2>
	<pre>$Error.LatestOccurance.Stack</pre>
	
	<h2>Hits</h2>
	<table>
		<thead>
			<tr>
				<th>When</th>
				<th>IP</th>
				<th>Request</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<% loop ErrorOccurances %>
				<tr>
					<td>$Created</td>
					<td>$IP</td>
					<td>$RequestMethod $RequestURI</td>
					<td><a href="{$BaseHref}dev/logs/data?id=$ID">data</a></td>
				</tr>
			<% end_loop %>
		</tbody>
	</table>
	
	<h2>Other</h2>
	<form method="post" action="{$BaseHref}dev/logs/delete">
		<input type="submit" name="fn" value="Delete" />
		<input type="hidden" name="hash" value="$Error.Hash" />
	</form>

</div>


<style>
	#content { padding: 0.5em; }
	table { border-collapse: collapse; margin-bottom: 1em; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; white-space: nowrap; }
	tr:nth-child(2n+1) { background: #eef; }
</style>

