
<h1>Error</h1>

<h2>Message</h2>
<pre>$Error.Message</pre>

<h2>Stack</h2>
<pre>$Error.Stack</pre>



<h2>Hits</h2>
<table>
	<thead>
		<tr>
			<th>When</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<% loop ErrorOccurances %>
			<tr>
				<td>$Created</td>
				<td><a href="?hash={$Top.Error.Hash}&occuranceId=$ID">full stack</a></td>
			</tr>
		<% end_loop %>
	</tbody>
</table>

<style>
	table { border-collapse: collapse; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; }
</style>