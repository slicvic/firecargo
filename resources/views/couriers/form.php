<div class="row">
    <h3><i class="fa fa-truck"></i> <?php echo ($courier->id) ? 'Edit' : 'Create'; ?> Courier</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/couriers/<?php echo ($courier->id) ? 'update/' . $courier->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="name" placeholder="e.g. UPS" class="form-control" value="<?php echo Input::old('name', $courier->name); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" class="btn btn-flat primary">Save Changes</button>
                    <a href="/couriers">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
