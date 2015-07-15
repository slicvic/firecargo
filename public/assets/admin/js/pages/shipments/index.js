$(function() {
    $('table').on('click', '.btn-toggle-packages', function() {
        var btn = $(this);
        var parentTr = btn.closest('tr');
        btn.toggleClass('collapsed');

        if (btn.hasClass('collapsed')) {
            var $packagesTr = $('<tr><td colspan="9"><h5 class="alert alert-warning text-center">Loading packages...</h5></td></tr>')
            parentTr.after($packagesTr);
            btn.html('<i class="fa fa-minus"></i>');
            $.get('/packages/ajax-shipment-packages/' + btn.attr('data-warehouse-id')).done(function(data) {
                $packagesTr.find('td').html(data);
            });
        }
        else {
            parentTr.next().remove();
            btn.html('<i class="fa fa-plus"></i>');
        }
    });
});
