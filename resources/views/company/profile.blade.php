@extends('layouts.admin.model.form')

@section('icon', 'building-o')
@section('title', 'Company Profile')
@section('subtitle', 'Manage your Company Profile')

@section('form')
    <div class="row">
        <div class="col-md-2 text-center">
            <div id="logoContainer">
                <img class="img-circle" src="{{ $company->getLogoUrl('md') ?: '/assets/admin/img/avatar.png' }}" style="width:100px;height:100px">
            </div>
            <button style="margin-top:4px;" type="button" id="btnChangeLogo" class="btn btn-md btn-primary">Change Logo</button>
            <div style="margin-bottom:0px;margin-top:4px;" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div id="dzProgressBar" class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
            </div>
            <div id="dzErrorMessage" class="text-danger"></div>
        </div>
        <div class="col-md-10">
            <form data-parsley-validate action="/company/profile" method="post" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="ibox">
                    <div class="ibox-content">
                        <h2>Contact Info</h2>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Company</label>
                            <div class="col-sm-4">
                                <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $company->name) }}">
                            </div>
                        </div>
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
                <div class="ibox">
                    <div class="ibox-content">
                        <h2>Address</h2>
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
                        <a class="btn btn-white" href="/company/profile">Cancel</a>
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </div>
                </div>
            </form>

            <script src="/assets/vendor/dropzone/dropzone.min.js"></script>
            <link rel="stylesheet" href="/assets/vendor/dropzone/dropzone.min.css">
            <script>
            $(function() {
                $('#btnChangeLogo').dropzone({
                    url: '/company/upload-logo',
                    maxFileSize: 10,
                    acceptedFiles: 'image/*',
                    parallelUploads: 1,
                    previewTemplate: '<div><img class="img-circle" data-dz-thumbnail style="width:100px;height:100px"></div>',
                    addedfile: function(file) {
                        file.previewElement = Dropzone.createElement(this.options.previewTemplate);
                        file.previewTemplate = file.previewElement;
                        $('#dzErrorMessage').hide();
                        $('#dzProgressBar').css('width', '0%').show();
                        $('#logoContainer').html(file.previewElement);
                    },
                    sending: function(file, xhr, formData) {
                        formData.append('_token', $('[name=_token').val());
                    },
                    error: function(file, errorMessage) {
                        var html = '<ul><h4>Oops! Some errors occurred: </h4><li>';
                        html += errorMessage.file.join('</li><li>')
                        html += '</li></ul>';
                        $('#dzErrorMessage').html(html).show();
                    },
                    uploadprogress: function(file, progress) {
                        $('#dzProgressBar').css('width', progress + '%');
                    },
                    complete: function() {
                        $('#dzProgressBar').fadeOut();
                    }
                });
            });
            </script>
        </div>
    </div>
@stop
