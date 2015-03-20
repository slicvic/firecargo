<div class="row toppad">
    <div class="col-md-12">
        <form data-parsley-validate action="/roles/<?php echo ($role->id) ? 'update/' . $role->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-male"></i> <?php echo ($role->id) ? 'Edit' : 'Create'; ?> Role</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-3">
                            <input required type="text" name="name" placeholder="Name" class="form-control" value="<?php echo Input::old('name', $role->name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Description</label>
                        <div class="col-sm-5">
                            <input type="text" name="description" placeholder="Description" class="form-control" value="<?php echo Input::old('description', $role->description); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button type="submit" class="btn btn-flat primary">Save</button>
                            <a href="/roles">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
