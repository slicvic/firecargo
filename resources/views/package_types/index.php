<div class="row">
    <h3><i class="fa fa-info-circle"></i> Package Types</h3>
    <hr>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        <div class="">
            <a href="/package-types/create" class="btn-flat primary">
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
                <?php foreach ($types as $type): ?>
                   <tr>
                        <td><?php echo $type->id; ?></td>
                        <td><?php echo $type->name; ?></td>
                        <td><a href="/package-types/edit/<?php echo $type->id; ?>" class="btn-flat icon"><i class="fa fa-pencil"></i></a></td>
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
