$(function() {
    // Packages Class
    var Packages = {
        $template: null,

        init: function() {
            this.initEvents();
            this.updateTotals();
        },

        initEvents: function() {
            var me = this;
            me.$template = $('#packages > tbody.package-template').clone().removeClass('package-template').removeAttr('style');
            $('#packages > tbody.package-template').remove();

            $('#packages').on('click', '.btn-clone-package', me.clonePackage);
            $('#packages').on('click', '.btn-remove-package', me.removePackage);
            $('#btnNewPackage').on('click', me.newPackage);
            $('#packages').on('keyup', '.metric', me.updateTotals);
        },

        clonePackage: function() {
            var totalPieces = Packages.countPackages();
            var $pkg = $(this).closest('tbody').clone();

            $pkg.find('.unique').val('');

            $pkg.find('input, select, textarea').each(function() {
                $(this).attr('name', 'packages[new_' + totalPieces + '][' + $(this).attr('data-name') + ']');
            });

            $('#packages').append($pkg);
            $('#totalPieces').html(1 + totalPieces);

            Packages.updateTotals();
        },

        newPackage: function() {
            var totalPieces = Packages.countPackages();
            var $pkg = Packages.$template.clone();

            $pkg.find('input, select, textarea').each(function() {
                $(this).val('');
                $(this).attr('name', 'packages[new_' + totalPieces + '][' + $(this).attr('data-name') + ']');
            });

            $('#packages').append($pkg);
            $('#totalPieces').html(1 + totalPieces);

            Packages.updateTotals();
        },

        removePackage: function() {
            $(this).closest('tbody').remove();
            Packages.updateTotals();
        },

        countPackages: function() {
            return $('#packages > tbody').length;
        },

        updateTotals: function() {
            var grossWeight = 0;
            var volumeWeight = 0;

            $('#packages > tbody > tr').each(function() {
                var $tr = $(this);
                var length = parseInt($tr.find('input[data-name="length"]').val()) || 0;
                var width = parseInt($tr.find('input[data-name="width"]').val()) || 0;
                var height = parseInt($tr.find('input[data-name="height"]').val()) || 0;
                var weight = parseInt($tr.find('input[data-name="weight"]').val()) || 0;
                grossWeight += weight;
                volumeWeight += (length * width * height) / 166;
            });

            volumeWeight = Math.round(volumeWeight);

            $('#totalPieces').html(Packages.countPackages());
            $('#grossWeight').html(grossWeight + ' lb(s)');
            $('#volumeWeight').html(volumeWeight + ' lb(s)');
            $('#chargeWeight').html((volumeWeight > grossWeight ? volumeWeight : grossWeight) + ' lb(s)');
        }
    };

    Packages.init();

    // Carrier autocomplete
    $('#carrier').keyup(function() {
        $('#carrierId').val('');
    });

    $('#carrier').autocomplete({
        source: '/warehouses/ajax-carrier-autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#carrier').val(ui.item.label);
            $('#carrierId').val(ui.item.id);
            return false;
        }
    })
    .autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    // Shipper autocomplete
    $('#shipper').keyup(function() {
        $('#shipperId').val('');
    });

    $('#shipper').autocomplete({
        source: '/warehouses/ajax-shipper-consignee-autocomplete?type=shipper',
        minLength: 2,
        select: function(event, ui) {
            $('#shipper').val(ui.item.label);
            $('#shipperId').val(ui.item.id);
            return false;
        }
    })
    .autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    // Consignee autocomplete
    $('#consignee').keyup(function() {
        $('#consigneeId').val('');
    });

    $('#consignee').autocomplete({
        source: '/warehouses/ajax-shipper-consignee-autocomplete?type=consignee',
        minLength: 2,
        select: function(event, ui) {
            $('#consignee').val(ui.item.label);
            $('#consigneeId').val(ui.item.id);
            return false;
        }
    })
    .autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    // Form submit
    $('form').on('submit', function() {
        event.preventDefault();

        var $form = $(this),
            $flashError = $('#flashError'),
            $submit = $(this).find('button');

        $submit.attr('disabled', true);
        $flashError.html('');

        $.post($form.attr('action'), $form.serialize(), function(data) {
            $submit.attr('disabled', false);

            if (data.status == 'ok') {
                window.location = data.redirect_to;
            } else {
                $flashError.html(data.message);
                $('html, body').scrollTop(0);
            }
        }, 'json');
    });
});
