<div id="content">

	<h2>Data Objects</h2>
	<table>
		<thead>
			<tr>
				<th>DataObject</th>
				<th>Extends</th>
				<th>Object Extensions</th>
				<th>db</th>
				<th>defaults</th>
				<th>casting</th>
				<th>has_one</th>
				<th>many_many</th>
				<th>extensions</th>
			</tr>
		</thead>
		<tbody>
			<% loop DataObjectData %>
				<tr>
					<td>$ClassName</td>
					<td>$Extends</td>
					<td>$ObjectExtensions</td>
					<td>$Field_db</td>
					<td>$Field_defaults</td>
					<td>$Field_casting</td>
					<td>$Field_has_one</td>
					<td>$Field_many_many</td>
					<td>$Field_extensions</td>
				</tr>
			<% end_loop %>
		</tbody>
	</table>

</div>






<style>
	#content { padding: 0.5em; }
	table { border-collapse: collapse; margin-bottom: 1em; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; }
	tr:nth-child(2n+1) { background: #eef; }
</style>