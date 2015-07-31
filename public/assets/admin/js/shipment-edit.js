$(function() {

    /**
     * ---------------------------------------------
     * Bind datatable
     * ---------------------------------------------
     */

    // Add column filter inputs
    $('#packages-table thead th').each( function () {
        var th = $(this);
        if (th.attr('data-filter')) {
            $(this).append('<div><input type="text" class="form-control" size="8" placeholder="Search"></div>');
        }
    });

    // Change row color based on checkbox state
    $('.status-icheck').on('ifChanged', function(event) {
        var self = $(this);
        if (self.attr('data-original-status') === 'in') {
            var parentTr = self.closest('tr');
            if  (self.is(':checked')) {
                parentTr.attr('class', 'success');
            }
            else {
                parentTr.attr('class', 'danger');
            }
        }
    });

    var dataTable = $('#packages-table').DataTable({
        order: [[0, 'desc']],
        paging: true,
        columnDefs: [
            {'orderDataType': 'dom-checkbox', targets: 0},
            {'visible': false, "targets": [2]}
        ],
        initComplete: function() {
            // Bind column filters
            this.api().columns().every(function() {
                var that = this;
                $('input', this.header() ).on('keyup change', function() {
                    that.search(this.value).draw();
                });
            });

            // Create an array with the values of all the checkboxes in a column for sorting
            $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
                return this.api().column(col, {order:'index'}).nodes().map(function(td, i) {
                    return $('input', td).prop('checked') ? '1' : '0';
                });
            }
        },
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({page:'current'}).nodes();
            var last = null;

            api.column(2, {page: 'current'}).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group info"><td colspan="7">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        }
    });

    /**
     * ---------------------------------------------
     * Carrier autocomplete handler
     * ---------------------------------------------
     */
    $('#carrier').keyup(function() {
        $('#carrier-id').val('');
    });

    $('#carrier').autocomplete({
        source: '/carriers/ajax-autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#carrier-id').val(ui.item.id);
        }
    });

    /**
     * ---------------------------------------------
     * Form submit handler
     * ---------------------------------------------
     */
    $('#shipment-edit-form').on('submit', function() {
        event.preventDefault();

        var form = $(this),
            flashMessage = $('#flash-message'),
            saveBtn = $(this).find('button[type=submit]');

        if (!form.valid()) return false;

        saveBtn.button('loading');

        $.post(form.attr('action'), form.serialize() + '&' + dataTable.$('input').serialize(), 'json')
            .done(function(data) {
                window.location = data.redirect_url;
            })
            .fail(function(xhr) {
                flashMessage.html(xhr.responseJSON.error);
                $('html, body').scrollTop(0);
                saveBtn.button('reset');
            });
    });
 });
