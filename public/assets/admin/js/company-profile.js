$(function() {
    /**
     * ---------------------------------------------
     * Bind dropzone
     * ---------------------------------------------
     */
    var uploadBtn = $('#edit-logo-btn');

    uploadBtn.dropzone({
        url: '/company/upload-logo',
        maxFileSize: 10,
        acceptedFiles: 'image/*',
        parallelUploads: 1,
        previewTemplate: '<div><img class="img-circle" data-dz-thumbnail style="width:100px;height:100px"></div>',
        addedfile: function(file) {
            file.previewElement = Dropzone.createElement(this.options.previewTemplate);
            file.previewTemplate = file.previewElement;
            $('#logo-container').html(file.previewElement);
        },
        sending: function(file, xhr, formData) {
            uploadBtn.attr('data-loading-text', app.getSpinnerHtml());
            uploadBtn.button('loading');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function(file, message) {
            toastr.success(message.message, message.title);
        },
        error: function(file, errorMessage) {
            toastr.error(errorMessage.message, errorMessage.title);
        },
        complete: function() {
            uploadBtn.button('reset');
        }
    });
});
