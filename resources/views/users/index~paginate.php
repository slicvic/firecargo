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
                    <th><a href="/admin/users?orderby=id&order=<?php echo $order; ?>">ID</a></th>
                    <th><a href="/admin/users?orderby=company&order=<?php echo $order; ?>">Company</a></th>
                    <th><a href="/admin/users?orderby=firstname&order=<?php echo $order; ?>">First Name</a></th>
                    <th><a href="/admin/users?orderby=lastname&order=<?php echo $order; ?>">Last Name</a></th>
                    <th><a href="/admin/users?orderby=email&order=<?php echo $order; ?>">Email</a></th>
                    <th>Home Phone</th>
                    <th>Mobile Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->id; ?></td>
                        <td><?php echo ($user->company ? $user->company : '--'); ?></td>
                        <td><?php echo $user->firstname; ?></td>
                        <td><?php echo $user->lastname; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->home_phone; ?></td>
                        <td><?php echo $user->cell_phone; ?></td>
                        <td>
                            <a href="/admin/users/view/<?php echo $user->id; ?>" class="btn btn-default ajax-view-user"><i class="fa fa-search-plus"></i></a>
                            <a href="/admin/users/edit/<?php echo $user->id; ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo $users->appends(['orderby' => $orderby, 'order' => $order])->links(); ?>
        </div>
    </div>
</div>

<script>
$(function() {
    $('table').DataTable();
});
</script>
