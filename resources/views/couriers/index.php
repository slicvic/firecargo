<div class="row">
    <h3><i class="fa fa-truck"></i> Couriers</h3>
    <hr>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        <div class="">
            <a href="/couriers/create" class="btn-flat primary">
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
                <?php foreach ($couriers as $courier): ?>
                   <tr>
                        <td><?php echo $courier->id; ?></td>
                        <td><?php echo $courier->name; ?></td>
                        <td><a href="/couriers/edit/<?php echo $courier->id; ?>" class="btn-flat icon"><i class="fa fa-pencil"></i></a></td>
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
