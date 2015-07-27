$(function() {
    $('table').on('click', '.btn-toggle-packages', function() {
        var toggleBtn = $(this);
        var toggleBtnParentTr = toggleBtn.closest('tr');
        toggleBtn.toggleClass('collapsed');

        if (toggleBtn.hasClass('collapsed')) {
            var packagesTr = $('<tr><td colspan="' + toggleBtnParentTr.children('td').length + '">' + app.getSpinnerHtml() + '</td></tr>')
            toggleBtnParentTr.after(packagesTr);
            toggleBtn.html('<i class="fa fa-angle-down"></i>');
            $.get('/packages/ajax-warehouse-packages/' + toggleBtn.attr('data-warehouse-id')).done(function(data) {
                packagesTr.children('td').html(data);
            });
        }
        else {
            toggleBtnParentTr.next().remove();
            toggleBtn.html('<i class="fa fa-angle-right"></i>');
        }
    });
});
