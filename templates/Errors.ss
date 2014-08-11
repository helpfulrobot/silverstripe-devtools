
<div id="content">
	<table>
		<thead>
			<tr>
				<th>Hash</th>
				<th>Latest Hit</th>
				<th>Hits</th>
				<th>Message</th>
			</tr>
		</thead>
		<tbody>
			<% loop Errors %>
				<tr>
					<td><a href="{$BaseHref}dev/logs/$Hash">$Hash</a></td>
					<td>$LatestOccurance.Created</td>
					<td>$NumOccurances</td>
					<td>$LatestOccurance.Message.LimitCharacters(150).LimitWordCountXML(20)</td>
				</tr>
			<% end_loop %>
		</tbody>
	</table>
</div>

<style>
	#content { padding: 0.5em; }
	table { border-collapse: collapse; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; white-space: nowrap; }
	tr:nth-child(2n+1) { background: #eef; }
</style>


