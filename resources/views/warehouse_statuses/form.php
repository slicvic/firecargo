<div class="row toppad">
    <div class="col-md-12">
        <form data-parsley-validate action="/ws/<?php echo $status->id ? 'update/' . $status->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="fa fa-user"></i> <?php echo ($status->id) ? 'Edit' : 'Create'; ?> Warehouse Status</h4></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="name" placeholder="e.g. Processing" class="form-control" value="<?php echo Input::old('name', $status->name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button type="submit" class="btn btn-flat primary">Save</button>
                            <a href="/ws">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
