<div class="row">
    <h3><i class="fa fa-group"></i> Accounts</h3>
    <hr>
</div>

<div class="row filter-block">
	<div class="col-md-12">
		<div class="">
			<a href="/accounts/create" class="btn-flat primary">
				<i class="fa fa-plus"></i>
				New
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table class="datatable table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Company</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Home Phone</th>
					<th>Cell Phone</th>
					<th>Groups</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<script>
$(function() {
    $('table').dataTable({
        //'aaSorting': [[ 0, 'desc' ]],
         'processing': true,
        'serverSide': true,
        'ajax': '/accounts/ajax-index',
    });
});
</script>
