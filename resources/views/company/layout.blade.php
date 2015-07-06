@extends('layouts.admin.model.form')

@section('icon', 'building-o')
@section('title', 'Company Profile')
@section('subtitle', 'Manage your Company Profile')

@section('form')
    <div class="row">
        <div class="col-md-4">
            <div class="ibox">
               <div class="ibox-content text-center">
                    <h1>{{ $company->name }}</h1>
                    <div id="logoContainer" class="m-b-sm">
                        <img class="img-circle" src="{{ $company->present()->logoURL('md') }}" style="width:100px;height:100px">
                    </div>
                    <button type="button" id="btnEditLogo" class="btn btn-link btn-block"><i class="fa fa-pencil"></i> Edit Logo</button>
                    <div id="dzErrorMessage" class="text-danger"></div>
                   <div class="list-group">
                        <a href="/company/profile" class="{{ Request::is('company/profile') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Profile</a>
                        <a href="/company/edit-profile" class="{{ Request::is('company/edit-profile') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {!! $content !!}
        </div>
    </div>
    <script src="/assets/vendor/dropzone/dropzone.min.js"></script>
    <script>
        $(function() {
            $('#btnEditLogo').dropzone({
                url: '/company/ajax-upload-logo',
                maxFileSize: 10,
                acceptedFiles: 'image/*',
                parallelUploads: 1,
                previewTemplate: '<div><img class="img-circle" data-dz-thumbnail style="width:100px;height:100px"></div>',
                addedfile: function(file) {
                    file.previewElement = Dropzone.createElement(this.options.previewTemplate);
                    file.previewTemplate = file.previewElement;
                    $('#dzErrorMessage').hide();
                    $('#logoContainer').html(file.previewElement);
                },
                sending: function(file, xhr, formData) {
                    formData.append('_token', '{{ csrf_token() }}');
                },
                error: function(file, errorMessage) {
                    var errorHtml = '<div class="alert alert-danger"><strong>Whoops! There was an error:</strong><ul><li>';
                    errorHtml += errorMessage.file.join('</li><li>')
                    errorHtml += '</li></ul></div>';
                    $('#dzErrorMessage').html(errorHtml).show();
                }
            });
        });
    </script>
@stop
