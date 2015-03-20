<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?php echo ($company->id ? 'Edit Company # ' . $company->id : 'Add Company'); ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/companies/<?php echo $company->id ? 'update/' . $company->id : 'store'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="panel panel-default">
                <div class="panel-heading">Company</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="name" placeholder="Name" class="form-control" value="<?php echo Input::old('name', $company->name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Code</label>
                        <div class="col-sm-4">
                            <input required type="text" name="code" placeholder="Code" class="form-control" value="<?php echo Input::old('code', $company->code); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-flat success">Save</button>
            <a href="/companies">Cancel</a>
        </form>
    </div>
</div>
