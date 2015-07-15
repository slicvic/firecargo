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
            flash = $('#flashMessage'),
            submit = $(this).find('button');

        if (!form.valid()) return;

        submit.attr('disabled', true);
        flash.html('');

        $.post(form.attr('action'), form.serialize(), 'json')
            .done(function(data) {
                window.location = data.redirect_url;
            })
            .fail(function(xhr) {
                var data = JSON.parse(xhr.responseText);
                flash.html(data.error);
                $('html, body').scrollTop(0);
                submit.attr('disabled', false);
            });
    });
 });
