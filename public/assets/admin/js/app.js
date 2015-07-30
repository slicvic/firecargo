var app = {
    init: function() {
        this.initGlobalEvents();
    },

    initGlobalEvents: function() {
        var self = this;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.show-package-btn', function() {
            var btn = $(this);
            var modal = $('#modal');
            var modalContent = modal.find('.modal-content');

            btn.attr('data-loading-text', self.getSpinnerHtml());
            btn.button('loading');

            $.get('/packages/ajax-show/' + btn.attr('data-package-id'), function(response) {
                modalContent.html(response);
            })
            .fail(function(xhr) {
                modalContent.html('<div class="modal-content">' + xhr.responseJSON.error + '</div>');
            })
            .always(function() {
                modal.modal({});
                btn.button('reset');
            });
        });

        // Bind jQuery Validate
        if ($('form').length) $('form').validate();

        // Bind table delete button
        $('table').on('click', '.delete-record-btn', function() {
            if (!confirm('Are you sure you want to delete this item?')) {
                event.preventDefault();
                return false;
            }
        });

        // Bind datatable
        $('.datatable').DataTable();

        // Bind date picker
        $('.date').datepicker({
            //todayBtn: 'linked',
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        // Bind icheckbox
        $('input[type=checkbox], input[type=radio]').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    },

    getSpinnerHtml: function() {
        var html = '<div class="sk-spinner sk-spinner-circle"> \
                <div class="sk-circle1 sk-circle"></div> \
                <div class="sk-circle2 sk-circle"></div> \
                <div class="sk-circle3 sk-circle"></div> \
                <div class="sk-circle4 sk-circle"></div> \
                <div class="sk-circle5 sk-circle"></div> \
                <div class="sk-circle6 sk-circle"></div> \
                <div class="sk-circle7 sk-circle"></div> \
                <div class="sk-circle8 sk-circle"></div> \
                <div class="sk-circle9 sk-circle"></div> \
                <div class="sk-circle10 sk-circle"></div> \
                <div class="sk-circle11 sk-circle"></div> \
                <div class="sk-circle12 sk-circle"></div> \
            </div>';

        return html;
    }
}

$(function() {
    app.init();
});
