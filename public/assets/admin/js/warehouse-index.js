$(function() {
    $('#warehouses-table').on('click', '.toggle-packages-btn', function() {
        var toggleBtn = $(this);
        var toggleBtnParentTr = toggleBtn.closest('tr');
        toggleBtn.toggleClass('collapsed');

        if (toggleBtn.hasClass('collapsed')) {
            var packagesTr = $('<tr><td colspan="' + toggleBtnParentTr.children('td').length + '">' + app.getSpinnerHtml() + '</td></tr>')
            toggleBtnParentTr.after(packagesTr);
            toggleBtn.html('<i class="fa fa-angle-down"></i>');
            $.get('/warehouse/' + toggleBtn.attr('data-warehouse-id') + '/packages').done(function(data) {
                packagesTr.children('td').html(data);
            });
        }
        else {
            toggleBtnParentTr.next().remove();
            toggleBtn.html('<i class="fa fa-angle-right"></i>');
        }
    });
});
