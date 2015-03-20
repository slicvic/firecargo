<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-building-o"></i> Companies</h1>
    </div>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        <div class="">
            <a href="/companies/create" class="btn-flat primary">
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
                    <th>Name</th>
                    <th>Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $company): ?>
                   <tr>
                        <td><?php echo $company->id; ?></td>
                        <td><?php echo $company->name; ?></td>
                        <td><?php echo $company->code; ?></td>
                        <td><a href="/companies/edit/<?php echo $company->id; ?>" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a></td>
                   </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function() {
    $('table').dataTable();
});
</script>
