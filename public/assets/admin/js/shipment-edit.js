$(function() {
    /**
     * Carrier autocomplete handler
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
     * Form submit handler
     */
    $('#shipment-edit-form').on('submit', function() {
        event.preventDefault();

        var form = $(this),
            flashMessage = $('#flash-message'),
            saveBtn = $(this).find('button[type=submit]');

        if (!form.valid()) return false;

        saveBtn.button('loading');

        $.post(form.attr('action'), form.serialize(), 'json')
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
