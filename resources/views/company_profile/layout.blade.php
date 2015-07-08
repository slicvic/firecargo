@extends('layouts.admin.model.form')

@section('icon', 'building-o')
@section('title', 'Your Company Profile')
@section('subtitle', 'Manage Your Company Profile')

@section('form')
    <div class="row">
        <div class="col-md-4">
           @include('company_profile.nav')
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
