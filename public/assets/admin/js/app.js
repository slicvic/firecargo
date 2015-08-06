var app = {
    init: function() {
        this.initGlobalEvents();
    },

    initGlobalEvents: function() {
        var that = this;

        /**
         * ---------------------------------------------
         * Add CSRF token to ajax requests
         * ---------------------------------------------
         */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * ---------------------------------------------
         * Bind tooltips
         * ---------------------------------------------
         */
        $('[data-toggle="tooltip"]').tooltip();

        /**
         * ---------------------------------------------
         * Bind form validation
         * ---------------------------------------------
         */
        if ($('form').length) $('form').validate();

        /**
         * ---------------------------------------------
         * Bind datatable
         * ---------------------------------------------
         */
        $('.datatable').DataTable({
            'order': [[ 0, 'desc' ]]
        });

        /**
         * ---------------------------------------------
         * Bind datepicker
         * ---------------------------------------------
         */
        $('.date').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        /**
         * ---------------------------------------------
         * Bind icheck
         * ---------------------------------------------
         */
        $('.icheck-green').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('.icheck-red').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
        });

        $('.icheck-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
        });

        /**
         * ---------------------------------------------
         * Bind delete record button
         * ---------------------------------------------
         */
        $('table').on('click', '.delete-record-btn', function() {
            if (!confirm('Are you sure you want to delete this record?')) {
                event.preventDefault();
                return false;
            }
        });

        /**
         * ---------------------------------------------
         * Bind view package button
         * ---------------------------------------------
         */
        $('table').on('click', '.show-package-modal-btn', function() {
            var viewBtn = $(this);
            var modal = $('#modal');
            var modalContent = modal.find('.modal-content');

            viewBtn.attr('data-loading-text', that.getSpinnerHtml());
            viewBtn.button('loading');

            $.get(viewBtn.attr('data-url'), function(response) {
                modalContent.html(response);
                modal.modal({});
            })
            .fail(function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.hasOwnProperty('message')) {
                    toastr.error(xhr.responseJSON.message, xhr.responseJSON.title);
                }
                else {
                    console.log(xhr);
                    toastr.error(xhr.responseText, 'Error');
                }
            })
            .always(function() {
                viewBtn.button('reset');
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
    },

    closeNavbar: function() {
        $('body').toggleClass('mini-navbar');
    }
}

$(function() {
    app.init();
});
