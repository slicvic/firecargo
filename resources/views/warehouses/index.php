<div class="row">
    <h3><i class="fa fa-info-circle"></i> Warehouses</h3>
    <hr>
</div>


<div class="row filter-block">
	<div class="col-md-12">
		<div class="">
			<a href="/warehouses/create" class="btn-flat primary">
				<i class="fa fa-plus"></i>
				New
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<table class="table table-striped">
				<thead>
					<tr>
						<th></th>
						<th>ID</th>
						<th>Tracking</th>
						<th>Description</th>
						<th>Units</th>
						<th>Total</th>
						<th>Arrival</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($warehouses as $warehouse): ?>
						<tr>
							<td><input type="checkbox" class="form-control"></td>
							<td><?php echo $warehouse->id; ?></td>
							<td><?php echo $warehouse->tracking_number; ?></td>
							<td><?php echo $warehouse->description; ?></td>
							<td><?php echo $warehouse->total_units; ?></td>
							<td><?php echo $warehouse->total_price; ?></td>
							<td><?php echo $warehouse->arrival_date; ?></td>
							<td>
								<a href="/warehouses/view/<?php echo $warehouse->id; ?>" class="btn btn-default"><i class="fa fa-search-plus"></i></a>
								<a href="/warehouses/edit/<?php echo $warehouse->id; ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
$(function () {
	$('table').dataTable({
		'bPaginate': true,
		'bLengthChange': false,
		'bFilter': false,
		'bSort': true,
		'bInfo': true,
		'bAutoWidth': false
	});
});
</script>
