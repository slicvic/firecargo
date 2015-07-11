@extends('layouts.admin.master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>My Profile</h2>
            Your Profile & Preferences
        </div>
        <div class="col-sm-8">
            <div class="title-action">

            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            {!! \App\Helpers\Flash::getAsHTML() !!}
            <div class="col-md-4">
                @include('user_profile.nav')
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
                    $('#dzErrorMessage').html(errorMessage).show();
                }
            });
        });
    </script>
@stop
