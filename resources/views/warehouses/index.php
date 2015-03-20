<div class="row">
	<div class="col-md-12">
		<h1 class="page-header"><i class="fa fa-cube"></i> Warehouses</h1>
	</div>
</div>

<div class="row filter-block">
	<div class="col-md-12">
		<div class="">
			<a href="/admin/warehouses/new" class="btn-flat success">
				<i class="fa fa-plus"></i>
				NEW WAREHOUSE
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
					<?php foreach (array() as $package): ?>
						<tr>
							<td><input type="checkbox" class="form-control"></td>
							<td><?php echo $package->id; ?></td>
							<td><?php echo $package->tracking_number; ?></td>
							<td><?php echo $package->description; ?></td>
							<td><?php echo $package->total_units; ?></td>
							<td><?php echo $package->total_price; ?></td>
							<td><?php echo $package->arrival_date; ?></td>
							<td>
								<a href="/admin/packages/view/<?php echo $package->id; ?>" class="btn btn-default"><i class="fa fa-search-plus"></i></a>
								<a href="/admin/packages/edit/<?php echo $package->id; ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
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
