@extends('layouts.admin.form')

@section('icon', 'building-o')
@section('title', 'Company Profile')

@section('form')
<form data-parsley-validate action="/company/profile" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="panel panel-default">
        <div class="panel-heading">Company Logo</div>
        <div class="panel-body">
            <div class="form-group">
                <div id="logoPreview">
                    <img src="" style="width:100px;height:100px;">
                </div>
                <button type="button" id="changeLogo" class="btn">Change Logo</button>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Company Information</div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-sm-2">Company Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $company->name) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Contact Information</div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-sm-2">Phone</label>
                <div class="col-sm-4">
                    <input type="text" name="phone" placeholder="Phone" class="form-control" value="<?php echo Input::old('phone', $company->phone); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Fax</label>
                <div class="col-sm-4">
                    <input type="text" name="fax" placeholder="Fax" class="form-control" value="<?php echo Input::old('fax', $company->fax); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email</label>
                <div class="col-sm-5">
                    <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo Input::old('email', $company->email); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Address</div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-sm-2">Address</label>
                <div class="col-sm-5">
                    <input type="text" name="address1" placeholder="Address" class="form-control" value="<?php echo Input::old('address1', $company->address1); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Apt / Unit</label>
                <div class="col-sm-5">
                    <input type="text" name="address2" placeholder="Apt / Unit" placeholder="Company" class="form-control" value="<?php echo Input::old('address2', $company->address2); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">City</label>
                <div class="col-sm-5">
                    <input type="text" name="city" placeholder="City" class="form-control" value="<?php echo Input::old('city', $company->city); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">State</label>
                <div class="col-sm-5">
                    <input type="text" name="state" placeholder="State" class="form-control" value="<?php echo Input::old('state', $company->state); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Postal Code</label>
                <div class="col-sm-3">
                    <input type="text" name="postal_code" placeholder="Postal Code" class="form-control" value="<?php echo Input::old('postal_code', $company->postal_code); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Country</label>
                <div class="col-sm-3">
                    <select name="country_id" class="form-control">
                        <?php foreach (\App\Models\Country::all() as $country): ?>
                            <option<?php echo ($country->id == $company->country_id) ? ' selected' : ''; ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/company/profile">Cancel</a>
        </div>
    </div>
</form>

<script src="/assets/vendor/dropzone/dropzone.min.js"></script>
<link rel="stylesheet" href="/assets/vendor/dropzone/dropzone.min.css">
<script>
$(function() {
    $('#changeLogo').dropzone({
        url: '/company/upload-logo',
        maxFiles: 1,
        maxFileSize: 2,
        acceptedFiles: 'image/*',
        parallelUploads: 1,
        previewsContainer: null,
        previewTemplate: '<div><span class="preview"><img data-dz-thumbnail /></span></div>',
        addedfile: function(file) {
            file.previewElement = Dropzone.createElement(this.options.previewTemplate);
            $('#logoPreview').html(file.previewElement);
        },
        sending: function(file, xhr, formData) {
            formData.append("_token", $('[name=_token').val());
        }
    });
});
</script>
@stop
