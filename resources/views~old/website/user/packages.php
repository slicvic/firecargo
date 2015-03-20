<h1 class="page-header">Mi Casillero</h1>

<table>
	<thead>
		<tr>
			<th></th>
			<th>ID</th>
			<th>Tracking</th>
			<th>Description</th>
			<th>Units</th>
			<th>Total</th>
			<th>Arrival</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($packages as $package): ?>
			<tr>
				<td><input type="checkbox" class="form-control"></td>
				<td><?php echo $package->id; ?></td>
				<td><?php echo $package->tracking_number; ?></td>
				<td><?php echo $package->description; ?></td>
				<td><?php echo $package->total_units; ?></td>
				<td><?php echo $package->total_price; ?></td>
				<td><?php echo $package->arrival_date; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script>
$(function() {
	$('table').DataTable();
})
</script>