<div class="row">
    <h3><i class="fa fa-info-circle"></i> <?php echo ($status->id) ? 'Edit' : 'Create'; ?> Package Status</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/package-statuses/<?php echo ($status->id) ? 'update/' . $status->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="site_id" value="<?php echo ($status->id) ? $status->site_id : Auth::user()->site_id; ?>">
            <div class="form-group">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="name" placeholder="e.g. Processing" class="form-control" value="<?php echo Input::old('name', $status->name); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" class="btn btn-flat primary">Save Changes</button>
                    <a href="/package-statuses">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
