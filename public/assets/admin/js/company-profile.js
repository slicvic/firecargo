$(function() {
    /**
     * ---------------------------------------------
     * Bind dropzone
     * ---------------------------------------------
     */
    $('#edit-logo-btn').dropzone({
        url: '/company/ajax-upload-logo',
        maxFileSize: 10,
        acceptedFiles: 'image/*',
        parallelUploads: 1,
        previewTemplate: '<div><img class="img-circle" data-dz-thumbnail style="width:100px;height:100px"></div>',
        addedfile: function(file) {
            file.previewElement = Dropzone.createElement(this.options.previewTemplate);
            file.previewTemplate = file.previewElement;
            $('#flash-message').hide();
            $('#logo-container').html(file.previewElement);
        },
        sending: function(file, xhr, formData) {
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        },
        error: function(file, errorMessage) {
            $('#flash-message').html(errorMessage).show();
        }
    });
});
