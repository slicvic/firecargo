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

        /**
         * Bind jquery validate
         */
        if ($('form').length) $('form').validate();

        /**
         * Bind datatable
         */
        $('.datatable').DataTable();

        /**
         * Bind date picker
         */
        $('.date').datepicker({
            //todayBtn: 'linked',
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        /**
         * Bind iCheckbox
         */
        $('.icheck').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('.icheck-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
        });

        /**
         * Bind button to delete table records
         */
        $('table').on('click', '.delete-record-btn', function() {
            if (!confirm('Are you sure you want to delete this item?')) {
                event.preventDefault();
                return false;
            }
        });

        /**
         * Bind button to open package details modal
         */
        $('body').on('click', '.show-package-modal-btn', function() {
            var btn = $(this);
            var modal = $('#modal');
            var modalContent = modal.find('.modal-content');

            btn.attr('data-loading-text', self.getSpinnerHtml());
            btn.button('loading');

            $.get('/packages/ajax-detail/' + btn.attr('data-package-id'), function(response) {
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
