<div id="content">

	<h2>Modules</h2>
	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Version</th>
			</tr>
		</thead>
		<tbody>
			<% loop ModuleData %>
				<tr>
					<td>$Name</td>
					<td>$Version</td>
				</tr>
			<% end_loop %>
		</tbody>
	</table>

</div>






<style>
	#content { padding: 0.5em; }
	table { border-collapse: collapse; margin-bottom: 1em; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; white-space: nowrap; }
	tr:nth-child(2n+1) { background: #eef; }
</style>