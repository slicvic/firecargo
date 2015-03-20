<div class="row">
	<div class="col-md-12">
		<h1 class="page-header"><i class="fa fa-group"></i> Accounts</h1>
	</div>
</div>

<div class="row filter-block">
	<div class="col-md-12">
		<div class="">
			<a href="/admin/users/new" class="btn-flat success">
				<i class="fa fa-plus"></i>
				NEW ACCOUNT
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
        'ajax': '/admin/users/ajax-datatable',
    });
});
</script>
