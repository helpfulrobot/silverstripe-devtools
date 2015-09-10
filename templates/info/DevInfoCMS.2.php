<div id="content">

<h2>Page Typesz</h2>

<?php foreach($data['PageTypeData'] as $i => $p){ ?>
	
	<h3 id="<?php echo $p['ClassName']?>"><?php echo $p['ClassName']?> 
		<span class="extends">extends 
			<a href="<?php echo ('#'.$p['Extends'])?>"><?php echo $p['Extends']?></a>
		</span>
	</h3>

	<table>
		<thead>
			<tr>
				<th>Field</th>
				<th>spec</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($p['Fields'] as $f){ ?>
				<tr class="<?php echo ($f['Native'] ? 'native' : 'inherited')?>">
					<td><?php echo $f['Name']?></td>
					<td><?php echo $f['Spec']?></td>
					<td class="inherited-from">
						<?php if(!$f['Native']){ ?> 
							<?php if($f['InheritedFrom'] == 'SiteTree'){ ?>
								<span><?php echo $f['InheritedFrom']?></span>
							<?php }else{ ?>
								<a href="<?php echo ('#' . $f['InheritedFrom']) ?>"><?php echo $f['InheritedFrom']?></a>
							<?php } ?>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<hr/>
	
<?php } ?>

<h3>Model Admins</h3>

.. todo ..

</div>




<style>
	#content { padding: 0.5em; }
	table { border-collapse: collapse; margin-bottom: 1em; }
	th { background: #ccc; }
	th, td { padding: 0.3em 1em; border: 1px solid #aaa; white-space: nowrap; }
	tr:nth-child(2n+1) { background: #eef; }
	
	.extends { font-weight: normal; color: green; margin-left: 1em; margin-bottom: 1em; font-size: 0.7em; font-family: monospace; }

        tr.inherited td { color: #888; }

        tr:not(:hover) td.inherited-from * { opacity: 0; } 
        
h2, hr { margin: 0.5em 0 2.5em 0; }

</style>