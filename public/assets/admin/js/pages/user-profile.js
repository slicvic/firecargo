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
            formData.append('_token', csrfToken);
        },
        error: function(file, errorMessage, xhr) {
            $('#dzErrorMessage').html(errorMessage).show();
        }
    });
});
