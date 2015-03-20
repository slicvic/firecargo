<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-truck"></i> Shipping Carriers</h1>
    </div>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        <div class="">
            <a href="/carriers/create" class="btn-flat primary">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carriers as $carrier): ?>
                   <tr>
                        <td><?php echo $carrier->id; ?></td>
                        <td><?php echo $carrier->name; ?></td>
                        <td><a href="/carriers/edit/<?php echo $carrier->id; ?>" class="btn-flat icon"><i class="fa fa-pencil"></i></a></td>
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
