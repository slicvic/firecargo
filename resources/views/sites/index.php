<div class="row">
    <h3><i class="fa fa-building-o"></i> Sites</h3>
    <hr>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        <div class="">
            <a href="/sites/create" class="btn-flat primary">
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
                    <th>Site Name</th>
                    <th>Company Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sites as $site): ?>
                   <tr>
                        <td><?php echo $site->id; ?></td>
                        <td><?php echo $site->name; ?></td>
                        <td><?php echo ($site->company) ? $site->company->name : ''; ?></td>
                        <td><a href="/sites/edit/<?php echo $site->id; ?>" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a></td>
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
