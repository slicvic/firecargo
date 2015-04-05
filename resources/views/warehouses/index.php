<div class="row">
    <h3><i class="fa fa-cube"></i> Warehouses</h3>
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
						<th>ID</th>
						<th>Date</th>
						<th>Pieces</th>
						<th>Weight</th>
						<th>Volume</th>
						<th>Shipper</th>
						<th>Consignee</th>
						<th>Tracking</th>
						<th>Company</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($warehouses as $warehouse): ?>
						<tr>
							<td><?php echo $warehouse->id; ?></td>
							<td><?php echo $warehouse->arrived_at; ?></td>
							<td><?php echo $warehouse->countPackages(); ?></td>
							<td><?php echo $warehouse->calculateWeight(); ?></td>
							<td><?php echo $warehouse->calculateVolume(); ?></td>
							<td><?php echo $warehouse->shipper->name(); ?></td>
							<td><?php echo $warehouse->consignee->name(); ?></td>
							<td>???</td>
							<td><?php echo $warehouse->site->company->name; ?></td>
							<td>
								<a href="/warehouses/view/<?php echo $warehouse->id; ?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
								<a href="/warehouses/edit/<?php echo $warehouse->id; ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
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
