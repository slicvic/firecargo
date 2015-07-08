@extends('layouts.admin.master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>My Profile</h2>
            Manage your Profile
        </div>
        <div class="col-sm-8">
            <div class="title-action">

            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            {!! \App\Helpers\Flash::getHTML() !!}
            <div class="col-md-4">
                <div class="ibox">
                   <div class="ibox-content text-center">
                        <h1>{{ Auth::user()->present()->fullname() }}</h1>
                        <div id="photoContainer" class="m-b-sm">
                            <img class="img-circle" src="{{ Auth::user()->getProfilePhotoURL('md') }}" style="width:200px;height:200px">
                        </div>
                        <button style="margin-top:4px;" type="button" id="btnEditPhoto" class="btn btn-block btn-link"><i class="fa fa-pencil"></i> Edit Photo</button>
                        <div id="dzErrorMessage" class="text-danger"></div>
                        <div class="list-group">
                            <a href="/account/profile" class="{{ Request::is('account/profile') ? 'active ' : '' }}list-group-item btn btn-block btn-success">My Profile</a>
                            <a href="/account/edit" class="{{ Request::is('account/edit') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Edit Profile</a>
                            <a href="/account/password" class="{{ Request::is('account/password') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {!! $content !!}
            </div>
        </div>
    </div>
    <script src="/assets/vendor/dropzone/dropzone.min.js"></script>
    <script>
        $(function() {
            $('#btnEditPhoto').dropzone({
                url: '/account/ajax-upload-photo',
                maxFileSize: 10,
                acceptedFiles: 'image/*',
                parallelUploads: 1,
                previewTemplate: '<div><img class="img-circle" data-dz-thumbnail style="width:200px;height:200px"></div>',
                addedfile: function(file) {
                    file.previewElement = Dropzone.createElement(this.options.previewTemplate);
                    file.previewTemplate = file.previewElement;
                    $('#dzErrorMessage').hide();
                    $('#photoContainer').html(file.previewElement);
                },
                sending: function(file, xhr, formData) {
                    formData.append('_token', '{{ csrf_token() }}');
                },
                error: function(file, errorMessage, xhr) {
                    var errorHtml = '<div class="alert alert-danger"><strong>Whoops! There was an error:</strong><ul><li>';
                    errorHtml += errorMessage.file.join('</li><li>')
                    errorHtml += '</li></ul></div>';
                    $('#dzErrorMessage').html(errorHtml).show();
                }
            });
        });
    </script>
@stop
