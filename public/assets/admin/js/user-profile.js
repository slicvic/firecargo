$(function() {
    $('#edit-photo-btn').dropzone({
        url: '/user/ajax-upload-photo',
        maxFileSize: 10,
        acceptedFiles: 'image/*',
        parallelUploads: 1,
        previewTemplate: '<div><img class="img-circle" data-dz-thumbnail style="width:200px;height:200px"></div>',
        addedfile: function(file) {
            file.previewElement = Dropzone.createElement(this.options.previewTemplate);
            file.previewTemplate = file.previewElement;
            $('#flash-message').hide();
            $('#photo-container').html(file.previewElement);
        },
        sending: function(file, xhr, formData) {
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        },
        error: function(file, errorMessage, xhr) {
            $('#flash-message').html(errorMessage).show();
        }
    });
});
