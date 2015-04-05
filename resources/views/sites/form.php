<div class="row">
    <h3><i class="fa fa-building-o"></i> <?php echo ($site->id) ? 'Edit' : 'Create'; ?> Site</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/sites/<?php echo ($site->id) ? 'update/' . $site->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="name" placeholder="Name" class="form-control" value="<?php echo Input::old('name', $site->name); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Display Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="display_name" placeholder="Name" class="form-control" value="<?php echo Input::old('display_name', $site->display_name); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Company</label>
                <div class="col-sm-5">
                    <select required class="form-control" name="company_id">
                        <option value="">- Choose -</option>
                        <?php foreach(\App\Models\Company::all() as $company): ?>
                            <option<?php echo ($company->id == Input::old('company_id', $site->company_id)) ? ' selected' : ''; ?> value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" class="btn btn-flat primary">Save Changes</button>
                    <a href="/sites">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
