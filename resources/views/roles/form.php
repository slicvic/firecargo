<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?php echo ($role->id ? 'Edit Role # ' . $role->id : 'Add Role'); ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/roles/<?php echo $role->id ? 'update/' . $role->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="panel panel-default">
                <div class="panel-heading">Role</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="name" placeholder="Name" class="form-control" value="<?php echo Input::old('name', $role->name); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-flat success">Save</button>
            <a href="/companies">Cancel</a>
        </form>
    </div>
</div>
