<div id="content">

	<h3>Page Type Tree</h3>
	
	$RenderPageTypeTree(PageTypeTree) 

	<h3>Page Types</h3>
	
	$PageTypeData.page.ClassName ----

	<% loop PageTypeData %>
		<h4 id="$ClassName">$ClassName <span class="extends">extends <a href="#$Extends">$Extends</a></span></h4>
		
		$Item.ClassName
		
		
		
		
		$Pos / $TotalItems
		

		
		<table>
			<thead>
				<tr>
					<th>Field</th>
					<th>spec</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<% loop Fields %>
					<tr>
						<td>$Name</td>
						<td>$Spec</td>
						<td>$Native</td>
					</tr>
				<% end_loop %>
			</tbody>
		</table>
		
		<hr/>
	<% end_loop %>
	
	<h3>Model Admins</h3>
	
	.. todo ..
	
</div>




<style>
	#content { padding: 0.5em; }
	table { border-collapse: collapse; margin-bottom: 1em; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; white-space: nowrap; }
	tr:nth-child(2n+1) { background: #eef; }
	
	.extends { display: block; font-weight: normal; color: green; margin-left: 1em; margin-bottom: 1em; font-size: 0.7em; font-family: monospace; }
	
</style>