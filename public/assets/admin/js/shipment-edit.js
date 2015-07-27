$(function() {
    // Bind carrier autocomplete
    $('#carrier').keyup(function() {
        $('#carrierId').val('');
    });

    $('#carrier').autocomplete({
        source: '/carriers/ajax-autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#carrierId').val(ui.item.id);
        }
    });

    // Bind form submit
    $('form').on('submit', function() {
        event.preventDefault();

        var form = $(this),
            flashMessage = $('#flashMessage'),
            submitBtn = $(this).find('button[type=submit]');

        if (!form.valid()) return false;

        submitBtn.button('loading');
        flashMessage.html('');

        $.post(form.attr('action'), form.serialize(), 'json')
            .done(function(data) {
                window.location = data.redirect_url;
            })
            .fail(function(xhr) {
                flashMessage.html(xhr.responseJSON.error);
                $('html, body').scrollTop(0);
                submitBtn.button('reset');
            });
    });
 });
