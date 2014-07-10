<h1>Errors</h1>
<table>
	<thead>
		<tr>
			<th>Hash</th>
			<th>Latest Hit</th>
			<th>Num Hits</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
		<% loop Errors %>
			<tr>
				<td><a href="logs?hash=$Hash">$Hash</a></td>
				<td>$LatestOccurance.FormatFromSettings</td>
				<td>$NumOccurances</td>
				<td>$Message</td>
			</tr>
		<% end_loop %>
	</tbody>
</table>

<style>
	table { border-collapse: collapse; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; white-space: nowrap; }
	tr:nth-child(2n) { background: #eef; }
</style>


